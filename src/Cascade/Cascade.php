<?php

namespace Handyfit\Framework\Cascade;

use Closure;
use Handyfit\Framework\Foundation\Hook\Eloquent as FoundationEloquentHook;
use Handyfit\Framework\Foundation\Hook\Migration as FoundationMigrationHook;
use Illuminate\Support\Facades\App;

use function Laravel\Prompts\error;

/**
 * Cascade
 *
 * @author KanekiYuto
 */
class Cascade
{

    /**
     * 创建一个 Cascade 实例
     *
     * @return void
     */
    private function __construct()
    {
        App::bind(Params\Configure\App::class, function () {
            return new Params\Configure\App('App', 'app');
        });

        App::bind(Params\Configure\Cascade::class, function () {
            return new Params\Configure\Cascade('Cascade');
        });

        App::bind(Params\Configure\Summary::class, function () {
            return new Params\Configure\Summary('Summaries', 'Summary');
        });

        App::bind(Params\Configure\Model::class, function () {
            return new Params\Configure\Model('Models', 'Model');
        });

        App::bind(Params\Configure::class, function () {
            return new Params\Configure(
                App::make(Params\Configure\App::class),
                App::make(Params\Configure\Cascade::class),
                App::make(Params\Configure\Summary::class),
                App::make(Params\Configure\Model::class)
            );
        });
    }

    /**
     * 设置 Configure
     *
     * @return static
     */
    public static function configure(): static
    {
        return new static();
    }

    /**
     * 设置 - Table
     *
     * @param string $table
     * @param string $comment
     *
     * @return static
     */
    public function withTable(string $table, string $comment = ''): static
    {
        App::bind(Params\Builder\Table::class, function () use ($table, $comment) {
            return new Params\Builder\Table($table, $comment);
        });

        return $this;
    }

    /**
     * 设置 - Migration
     *
     * @param string $filename
     * @param string $comment
     * @param string $hook
     *
     * @return static
     */
    public function withMigration(
        string $filename = '',
        string $comment = '',
        string $hook = FoundationMigrationHook::class
    ): static {
        App::bind(Params\Builder\Migration::class, function () use ($filename, $comment, $hook) {
            return new Params\Builder\Migration($filename, $comment, $hook);
        });

        return $this;
    }

    /**
     * 设置 - Model
     *
     * @param string $extends
     * @param string $hook
     * @param bool   $incrementing
     * @param bool   $timestamps
     *
     * @return static
     */
    public function withModel(
        string $extends,
        string $hook = FoundationEloquentHook::class,
        bool $incrementing = false,
        bool $timestamps = false
    ): static {
        App::bind(Params\Builder\Model::class, function () use (
            $extends,
            $hook,
            $incrementing,
            $timestamps
        ) {
            return new Params\Builder\Model($extends, $hook, $incrementing, $timestamps);
        });

        return $this;
    }

    /**
     * 设置 - Schema
     *
     * @param Closure $up
     * @param Closure $down
     *
     * @return static
     */
    public function withSchema(Closure $up, Closure $down): static
    {
        App::bind(Params\Closure\Schema::class, function () use ($up, $down) {
            return new Params\Closure\Schema($up, $down);
        });

        return $this;
    }

    /**
     * 创建 Cascade
     *
     * @return void
     */
    public function create(): void
    {
        if (!$this->verify()) {
            return;
        }

        // 无论如何都注销以防止污染
        App::forgetInstance(Params\Schema::class);

        App::instance(
            Params\Schema::class,
            new Params\Schema(app(Params\Builder\Table::class)->getTable())
        );

        app(Params\Closure\Schema::class)->getUp()(
            new Schema(App::make(Params\Schema::class), 'up')
        );

        app(Params\Closure\Schema::class)->getDown()(
            new Schema(App::make(Params\Schema::class), 'down')
        );

        $this->runSummary();

        if (App::bound(Params\Builder\Migration::class)) {
            $this->runMigrationBuilder();
        }

        if (App::bound(Params\Builder\Model::class)) {
            $this->runModelBuilder();
        }
    }

    /**
     * 验证配置有效性
     *
     * @return bool
     */
    private function verify(): bool
    {
        $required = collect([
            Params\Configure::class => '预期之外的结果',
            Params\Builder\Table::class => '必须调用 withTable 并给予参数',
            Params\Closure\Schema::class => '必须调用 withSchema 并给予参数',
        ]);

        foreach ($required as $abstract => $message) {
            if (!App::bound($abstract)) {
                error($message);

                return false;
            }
        }

        return true;
    }

    /**
     * 绑定并运行 Summary
     *
     * @return void
     */
    private function runSummary(): void
    {
        App::bind(Builder\Summary::class, function () {
            return new Builder\Summary(
                App::make(Params\Configure::class),
                App::make(Params\Builder\Table::class),
                App::make(Params\Schema::class)
            );
        });

        app(Builder\Summary::class)->boot();
    }

    /**
     * 绑定并运行迁移构建器
     *
     * @return void
     */
    private function runMigrationBuilder(): void
    {
        App::bind(Builder\Migration::class, function () {
            return new Builder\Migration(
                App::make(Params\Configure::class),
                App::make(Params\Builder\Table::class),
                App::make(Params\Schema::class),
                App::make(Params\Builder\Migration::class)
            );
        });

        app(Builder\Migration::class)->boot();
    }

    /**
     * 绑定并运行模型构建器
     *
     * @return void
     */
    private function runModelBuilder(): void
    {
        App::bind(Builder\Model::class, function () {
            return new Builder\Model(
                App::make(Params\Configure::class),
                App::make(Params\Builder\Table::class),
                App::make(Params\Builder\Model::class),
                App::make(Params\Schema::class),
            );
        });

        app(Builder\Model::class)->boot();
    }

}
