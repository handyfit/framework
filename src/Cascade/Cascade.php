<?php

namespace KanekiYuto\Handy\Cascade;

use Closure;
use KanekiYuto\Handy\Cascade\Make\ModelMake;
use KanekiYuto\Handy\Cascade\Make\MigrationMake;
use KanekiYuto\Handy\Cascade\Make\EloquentTraceMake;
use KanekiYuto\Handy\Cascade\Params\Make\Model as ModelParams;
use KanekiYuto\Handy\Cascade\Params\Make\Table as TableParams;
use Illuminate\Database\Eloquent\Model as LaravelEloquentModel;
use KanekiYuto\Handy\Cascade\Params\Blueprint as BlueprintParams;
use KanekiYuto\Handy\Cascade\Params\Configure as ConfigureParams;
use KanekiYuto\Handy\Cascade\Params\Make\Migration as MigrationParams;
use KanekiYuto\Handy\Foundation\Activity\Eloquent\Activity as FoundationEloquentActivity;

/**
 * Cascade
 *
 * @author KanekiYuto
 */
class Cascade
{

    protected ConfigureParams $configureParams;

    private TableParams $tableParams;

    private MigrationParams $migrationParams;

    private ModelParams $modelParams;

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
        $this->migrationParams = new MigrationParams(null, '');

        $this->modelParams = new ModelParams(
            LaravelEloquentModel::class,
            FoundationEloquentActivity::class,
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
     * @param  string  $activity
     * @param  bool    $incrementing
     * @param  bool    $timestamps
     *
     * @return Cascade
     */
    public function withModel(
        string $extends,
        string $activity,
        bool $incrementing = false,
        bool $timestamps = false
    ): static {
        $this->modelParams = new ModelParams($extends, $activity, $incrementing, $timestamps);

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

    public function create(): void
    {
        $blueprintCallable = $this->blueprintParams->getCallable();

        $blueprintCallable(new Blueprint($this->blueprintParams));

        (new MigrationMake(
            $this->configureParams,
            $this->blueprintParams,
            $this->tableParams,
            $this->modelParams,
            $this->migrationParams
        ))->boot();

        (new EloquentTraceMake(
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