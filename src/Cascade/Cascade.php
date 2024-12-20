<?php

namespace Handyfit\Framework\Cascade;

use Closure;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;
use Handyfit\Framework\Foundation\Hook\Eloquent as FoundationEloquentHook;
use Handyfit\Framework\Foundation\Hook\Migration as FoundationMigrationHook;
use function Laravel\Prompts\error;

/**
 * Cascade
 *
 * @author KanekiYuto
 */
class Cascade
{

    /**
     * 容器集合
     *
     * @var Collection
     */
    private Collection $container;

    /**
     * 创建一个 Cascade 实例
     *
     * @return void
     */
    private function __construct()
    {
        $this->container = collect([
            Params\Configure::class,
            Params\Builder\Table::class,
            Params\Builder\Migration::class,
            Params\Builder\Model::class,
            Params\Schema::class,
        ]);

        // 批量注销绑定
        $this->container->map(function (string $abstract) {
            App::forgetInstance($abstract);
        });

        App::instance(Params\Configure::class, new Params\Configure());
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
     * @param  string  $table
     * @param  string  $comment
     *
     * @return static
     */
    public function withTable(string $table, string $comment = ''): static
    {
        App::instance(
            Params\Builder\Table::class,
            new Params\Builder\Table($table, $comment)
        );

        return $this;
    }

    /**
     * 设置 - Migration
     *
     * @param  string  $filename
     * @param  string  $comment
     * @param  string  $hook
     *
     * @return static
     */
    public function withMigration(
        string $filename = '',
        string $comment = '',
        string $hook = FoundationMigrationHook::class
    ): static {
        App::instance(
            Params\Builder\Migration::class,
            new Params\Builder\Migration($filename, $comment, $hook)
        );

        return $this;
    }

    /**
     * 设置 - Model
     *
     * @param  string  $extends
     * @param  string  $hook
     * @param  bool    $incrementing
     * @param  bool    $timestamps
     *
     * @return static
     */
    public function withModel(
        string $extends,
        string $hook = FoundationEloquentHook::class,
        bool $incrementing = false,
        bool $timestamps = false
    ): static {
        App::instance(
            Params\Builder\Model::class,
            new Params\Builder\Model($extends, $hook, $incrementing, $timestamps)
        );

        return $this;
    }

    /**
     * 设置 - Schema
     *
     * @param  Closure  $up
     * @param  Closure  $down
     *
     * @return static
     */
    public function withSchema(Closure $up, Closure $down): static
    {
        App::instance(
            Params\Schema::class,
            new Params\Schema('', ['up' => $up, 'down' => $down])
        );

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

        // 兼容调用顺序重新绑定实例
        $schemaParams = App::make(Params\Schema::class);
        $tableParams = App::make(Params\Builder\Table::class);

        App::instance(
            Params\Schema::class,
            new Params\Schema(
                $tableParams->getTable(),
                [
                    'up' => $schemaParams->getCallable('up'),
                    'down' => $schemaParams->getCallable('down'),
                ]
            )
        );

        $this->container->map(function (string $abstract) {
            if (App::bound($abstract)) {
                echo "\n $abstract 已绑定\n";
            } else {
                echo "\n $abstract 未绑定\n";
            }
        });

        // 注册闭包方法
        Schema::builder(App::make(Params\Schema::class));

        $this->runEloquentTrace();

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
            Params\Schema::class => '必须调用 withSchema 并给予参数',
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
     * 绑定并运行 Eloquent trace
     *
     * @return void
     */
    private function runEloquentTrace(): void
    {
        App::when(Builder\EloquentTrace::class)
            ->needs('$configureParams')
            ->needs('$tableParams')
            ->needs('$schemaParams')
            ->give([
                App::make(Params\Configure::class),
                App::make(Params\Builder\Table::class),
                App::make(Params\Configure::class),
            ]);

        app(Builder\EloquentTrace::class)->boot();
    }

    /**
     * 绑定并运行迁移构建器
     *
     * @return void
     */
    private function runMigrationBuilder(): void
    {
        App::when(Builder\Migration::class)
            ->needs('$configureParams')
            ->needs('$tableParams')
            ->needs('$schemaParams')
            ->needs('$migrationParams')
            ->give([
                App::make(Params\Configure::class),
                App::make(Params\Builder\Table::class),
                App::make(Params\Configure::class),
                App::make(Params\Builder\Migration::class),
            ]);

        app(Builder\Migration::class)->boot();
    }

    /**
     * 绑定并运行模型构建器
     *
     * @return void
     */
    private function runModelBuilder(): void
    {
        App::when(Builder\Model::class)
            ->needs('$configureParams')
            ->needs('$tableParams')
            ->needs('$schemaParams')
            ->needs('$modelParams')
            ->give([
                App::make(Params\Configure::class),
                App::make(Params\Builder\Table::class),
                App::make(Params\Configure::class),
                App::make(Params\Builder\Model::class),
            ]);

        app(Builder\Model::class)->boot();
    }

}