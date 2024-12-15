<?php

namespace Handyfit\Framework\Cascade;

use Closure;
use Handyfit\Framework\Cascade\Params\Schema as SchemaParams;
use Handyfit\Framework\Cascade\Builder\Model as ModelBuilder;
use Illuminate\Database\Eloquent\Model as LaravelEloquentModel;
use Handyfit\Framework\Cascade\Params\Builder\Model as ModelParams;
use Handyfit\Framework\Cascade\Params\Builder\Table as TableParams;
use Handyfit\Framework\Cascade\Params\Blueprint as BlueprintParams;
use Handyfit\Framework\Cascade\Params\Configure as ConfigureParams;
use Handyfit\Framework\Cascade\Builder\Migration as MigrationBuilder;
use Handyfit\Framework\Foundation\Hook\Eloquent as FoundationEloquentHook;
use Handyfit\Framework\Cascade\Params\Builder\Migration as MigrationParams;
use Handyfit\Framework\Foundation\Hook\Migration as FoundationMigrationHook;
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
     * Scheme 参数对象
     *
     * @var SchemaParams
     */
    private SchemaParams $schemaParams;

    /**
     * 创建一个 [Cascade] 实例
     *
     * @return void
     */
    private function __construct()
    {
        $this->configureParams = new ConfigureParams();
        $this->tableParams = new TableParams('default', '');

        $this->migrationParams = new MigrationParams(
            '',
            '',
            FoundationMigrationHook::class
        );

        $this->modelParams = new ModelParams(
            LaravelEloquentModel::class,
            FoundationEloquentHook::class,
            false,
            false
        );

        $this->blueprintParams = new BlueprintParams('default', fn() => null);
        $this->schemaParams = new SchemaParams('default', [
            'up' => fn() => null,
            'down' => fn() => null,
        ]);
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
     * @return static
     */
    public function withTable(string $table, string $comment = ''): static
    {
        $this->tableParams = new TableParams($table, $comment);

        return $this;
    }

    /**
     * 设置 - 【Migration】
     *
     * @param  string       $filename
     * @param  string       $comment
     * @param  string|null  $hook
     *
     * @return static
     */
    public function withMigration(string $filename = '', string $comment = '', string $hook = null): static
    {
        if (empty($hook)) {
            $hook = FoundationMigrationHook::class;
        }

        $this->migrationParams = new MigrationParams($filename, $comment, $hook);

        return $this;
    }

    /**
     * 设置 - [Model]
     *
     * @param  string       $extends
     * @param  string|null  $hook
     * @param  bool         $incrementing
     * @param  bool         $timestamps
     *
     * @return static
     */
    public function withModel(
        string $extends,
        string $hook = null,
        bool $incrementing = false,
        bool $timestamps = false
    ): static {
        if (empty($hook)) {
            $hook = FoundationEloquentHook::class;
        }

        $this->modelParams = new ModelParams($extends, $hook, $incrementing, $timestamps);

        return $this;
    }

    /**
     * 设置 - [Blueprint]
     *
     * @param  Closure  $callable
     *
     * @return static
     */
    public function withBlueprint(Closure $callable): static
    {
        if (!isset($this->tableParams)) {
            return $this;
        }

        $this->blueprintParams = new BlueprintParams(
            $this->tableParams->getTable(),
            $callable,
        );

        return $this;
    }

    /**
     * 设置 Schema
     *
     * @param  Closure  $up
     * @param  Closure  $down
     *
     * @return static
     */
    public function withSchema(Closure $up, Closure $down): static
    {
        if (!isset($this->tableParams)) {
            return $this;
        }

        $this->schemaParams = new SchemaParams(
            $this->tableParams->getTable(),
            ['up' => $up, 'down' => $down],
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
        Schema::init($this->schemaParams);

        $registers = [
            EloquentTraceBuilder::class,
            MigrationBuilder::class,
            ModelBuilder::class,
        ];

        foreach ($registers as $register) {
            (new $register(
                $this->configureParams,
                $this->blueprintParams,
                $this->tableParams,
                $this->modelParams,
                $this->migrationParams,
                $this->schemaParams
            ))->boot();
        }
    }

}