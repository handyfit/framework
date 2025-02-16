<?php

namespace Handyfit\Framework\Cascade;

use Closure;
use Handyfit\Framework\Foundation\Hook\Eloquent as FoundationEloquentHook;
use Handyfit\Framework\Foundation\Hook\Migration as FoundationMigrationHook;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;

use function Laravel\Prompts\error;
use function Laravel\Prompts\warning;

/**
 * Cascade
 *
 * @author KanekiYuto
 */
class Cascade
{

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

        // 重新绑定实例防止因为调用顺序导致的错误
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

        $this->boot();
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
     * 启动执行
     *
     * @return void
     */
    private function boot(): void
    {
        // 提供公共依赖
        collect([
            Params\Schema::class,
            Params\Builder\Table::class,
        ])->map(function (string $abstract) {
            App::when(array_keys($this->builders()->all()))
                ->needs($abstract)
                ->give(function () use ($abstract) {
                    return App::make($abstract);
                });
        });

        // 动态注册依赖
        $this->builders()->map(function (array $dependencies, string $builder) {
            foreach ($dependencies as $dependency) {
                if (!App::bound($dependency)) {
                    warning("[Debug]: $builder - 缺少 [$dependency] 依赖- 跳过注入");
                    return;
                }

                App::when($builder)->needs($dependency)->give(function () use ($dependency) {
                    return App::make($dependency);
                });
            }

            app($builder)->boot();
        });
    }

    /**
     * 构建器实例与依赖
     *
     * @return Collection
     */
    private function builders(): Collection
    {
        return collect([
            SummaryBuilder::class => [],
            MigrationBuilder::class => [
                Params\Builder\Migration::class,
            ],
            ModelBuilder::class => [
                Params\Builder\Model::class,
            ],
        ]);
    }

}
