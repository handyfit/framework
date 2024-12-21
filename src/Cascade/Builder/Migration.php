<?php

namespace Handyfit\Framework\Cascade\Builder;

use Handyfit\Framework\Cascade\DiskManager;
use Handyfit\Framework\Cascade\Params\Builder\Migration as MigrationParams;
use Handyfit\Framework\Cascade\Params\Builder\Table as TableParams;
use Handyfit\Framework\Cascade\Params\Column as ColumnParams;
use Handyfit\Framework\Cascade\Params\Configure as ConfigureParams;
use Handyfit\Framework\Cascade\Params\Schema as SchemaParams;
use Illuminate\Support\Str;
use stdClass;

/**
 * Migration builder
 *
 * @author KanekiYuto
 */
class Migration extends Builder
{

    /**
     * Migration 参数对象
     *
     * @var MigrationParams
     */
    private MigrationParams $migrationParams;

    /**
     * 构建一个 Eloquent Trace Builder 实例
     *
     * @param ConfigureParams $configureParams
     * @param TableParams     $tableParams
     * @param SchemaParams    $schemaParams
     * @param MigrationParams $migrationParams
     *
     * @return void
     */
    public function __construct(
        ConfigureParams $configureParams,
        TableParams $tableParams,
        SchemaParams $schemaParams,
        MigrationParams $migrationParams
    ) {
        parent::__construct($configureParams, $tableParams, $schemaParams);

        $this->migrationParams = $migrationParams;
    }

    /**
     * 引导构建
     *
     * @return void
     */
    public function boot(): void
    {
        // 初始化 - 载入存根
        if (!$this->init(__CLASS__, 'migration')) {
            return;
        }

        $table = $this->tableParams->getTable();
        $filename = "cascade_create_{$table}_table";
        $folderPath = DiskManager::getMigrationPath();

        $this->stubParam('summary', app(Summary::class)->getPackage());

        $this->stubParam('hook', $this->migrationParams->getHook());
        $this->stubParam('comment', $this->migrationParams->getComment());

        $this->stubParam('upSchema', $this->schemaBuilder('up'));
        $this->stubParam('downSchema', $this->schemaBuilder('down'));

        $this->stub = $this->formattingStub($this->stub);

        // 写入磁盘
        $this->put($this->builderUUid(__CLASS__), $filename, $folderPath);
    }

    /**
     * 构建所有列信息
     *
     * @param ColumnParams[] $columns
     *
     * @return string
     */
    public function columnsBuilder(array $columns): string
    {
        $templates = [];

        foreach ($columns as $column) {
            $templates[] = $this->columnBuilder($column);
        }

        return $this->tab(implode("\n", $templates), 1, false);
    }

    /**
     * 构建一个完整的列定义调用
     *
     * @param ColumnParams $column
     *
     * @return string
     */
    public function columnBuilder(ColumnParams $column): string
    {
        $template = '@table';

        foreach ($column->getMigrationParams() as $param) {
            $fn = $param->getFn();
            $params = $param->getParams();

            $template .= "->$fn(";
            $template .= implode(
                ', ',
                $this->parametersBuilder($params)
            );

            $template .= ')';
        }

        return Str::of($template . ';')->replace('@', '$')->toString();
    }

    /**
     * 构建函数参数信息
     *
     * @param stdClass $values
     *
     * @return array
     */
    public function parametersBuilder(stdClass $values): array
    {
        $parameters = [];

        foreach ($values as $key => $val) {
            // 判断可以处理的类型 [其余类型可能不兼容]
            if (!in_array(gettype($val), ['string', 'boolean', 'double', 'integer', 'array'])) {
                continue;
            }

            // 判定是否引用 [Trace]
            $isQuote = Str::startsWith($key, '@quote');
            $key = $isQuote ? Str::of($key)->chopStart('@quote')->toString() : $key;

            // 类型处理 | 如果是引用 [Trace] 会进行特殊处理
            $val = !$isQuote ? match (gettype($val)) {
                'string' => "'$val'",
                'boolean' => $val ? 'true' : 'false',
                'array' => $this->arrayParamsBuilder($val),
                default => $val
            } : 'TheSummary::' . Str::upper($val);

            // 命名参数设置，避免顺序问题
            $parameters[] = "$key: $val";
        }

        return $parameters;
    }

    /**
     * Schema 构建
     *
     * @param string $action
     *
     * @return string
     */
    private function schemaBuilder(string $action): string
    {
        $templates = [];
        $blueprints = $this->schemaParams->getBlueprints($action);
        $codes = $this->schemaParams->getCodes($action);

        // 生成 Blueprints 部分
        foreach ($blueprints as $fn => $blueprint) {
            $template = [];

            $template[] = "Schema::$fn(TheSummary::TABLE, function (Blueprint @table) {";
            $template[] = $this->columnsBuilder($blueprint->getColumns());
            $template[] = "});";

            $template = implode("\n", $template);
            $template = Str::of($template)->replace('@', '$')->toString();

            $templates[] = $template;
        }

        foreach ($codes as $code) {
            $templates[] = $code;
        }

        return $this->tab(implode("\n\n", $templates), 2);
    }

    /**
     * 数组转换为参数字符串
     *
     * @param array $values
     *
     * @return string
     */
    private function arrayParamsBuilder(array $values): string
    {
        return Str::of(json_encode($values, JSON_UNESCAPED_UNICODE))
            ->replace('"', '\'')
            ->replace(',', ', ')
            ->toString();
    }

}
