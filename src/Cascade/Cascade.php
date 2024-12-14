<?php

namespace Handyfit\Framework\Cascade;

use Closure;
use Handyfit\Framework\Cascade\Make\ModelMake;
use Handyfit\Framework\Cascade\Make\MigrationMake;
use Illuminate\Database\Eloquent\Model as LaravelEloquentModel;
use Handyfit\Framework\Cascade\Params\Builder\Model as ModelParams;
use Handyfit\Framework\Cascade\Params\Builder\Table as TableParams;
use Handyfit\Framework\Cascade\Params\Blueprint as BlueprintParams;
use Handyfit\Framework\Cascade\Params\Configure as ConfigureParams;
use Handyfit\Framework\Foundation\Hook\Eloquent as FoundationEloquentHook;
use Handyfit\Framework\Cascade\Params\Builder\Migration as MigrationParams;
use Handyfit\Framework\Cascade\Builder\EloquentTrace as EloquentTraceBuilder;

/**
 * Cascade
 *
 * @author KanekiYuto
 */
class Cascade
{

    /**
     * 配置参数对象
     *
     * @var ConfigureParams
     */
    protected ConfigureParams $configureParams;

    /**
     * 表参数对象
     *
     * @var TableParams
     */
    private TableParams $tableParams;

    /**
     * Migration 参数对象
     *
     * @var MigrationParams
     */
    private MigrationParams $migrationParams;

    /**
     * 模型参数对象
     *
     * @var ModelParams
     */
    private ModelParams $modelParams;

    /**
     * Blueprint 参数对象
     *
     * @var BlueprintParams
     */
    private BlueprintParams $blueprintParams;

    /**
     * 创建一个 [Cascade] 实例
     *
     * @return void
     */
    private function __construct()
    {
        $this->configureParams = new ConfigureParams();
        $this->tableParams = new TableParams('default', '');
        $this->migrationParams = new MigrationParams('', '');

        $this->modelParams = new ModelParams(
            LaravelEloquentModel::class,
            FoundationEloquentHook::class,
            false,
            false
        );

        $this->blueprintParams = new BlueprintParams('default', '', fn() => null);
    }

    /**
     * 配置信息
     *
     * @return static
     */
    public static function configure(): static
    {
        return new static();
    }

    /**
     * 设置 - 【Table】
     *
     * @param  string  $table
     * @param  string  $comment
     *
     * @return Cascade
     */
    public function withTable(string $table, string $comment = ''): static
    {
        $this->tableParams = new TableParams($table, $comment);

        return $this;
    }

    /**
     * 设置 - 【Migration】
     *
     * @param  string|null  $filename
     * @param  string       $comment
     *
     * @return Cascade
     */
    public function withMigration(string $filename = null, string $comment = ''): static
    {
        $this->migrationParams = new MigrationParams($filename, $comment);

        return $this;
    }

    /**
     * 设置 - [Model]
     *
     * @param  string  $extends
     * @param  string  $hook
     * @param  bool    $incrementing
     * @param  bool    $timestamps
     *
     * @return Cascade
     */
    public function withModel(
        string $extends,
        string $hook,
        bool $incrementing = false,
        bool $timestamps = false
    ): static {
        $this->modelParams = new ModelParams($extends, $hook, $incrementing, $timestamps);

        return $this;
    }

    /**
     * 设置 - [Blueprint]
     *
     * @param  Closure  $callable
     *
     * @return Cascade
     */
    public function withBlueprint(Closure $callable): static
    {
        if (!isset($this->tableParams)) {
            return $this;
        }

        $this->blueprintParams = new BlueprintParams(
            $this->tableParams->getTable(),
            $this->tableParams->getComment(),
            $callable,
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
        $blueprintCallable = $this->blueprintParams->getCallable();

        $blueprintCallable(new Blueprint($this->blueprintParams));

        (new EloquentTraceBuilder(
            $this->configureParams,
            $this->blueprintParams,
            $this->tableParams,
            $this->modelParams,
            $this->migrationParams
        ))->boot();

        (new MigrationMake(
            $this->configureParams,
            $this->blueprintParams,
            $this->tableParams,
            $this->modelParams,
            $this->migrationParams
        ))->boot();

        (new ModelMake(
            $this->configureParams,
            $this->blueprintParams,
            $this->tableParams,
            $this->modelParams,
            $this->migrationParams
        ))->boot();
    }

}