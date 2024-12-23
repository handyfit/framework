<?php

namespace Handyfit\Framework\Cascade;

use Handyfit\Framework\Cascade\Params\Builder\Migration;
use Handyfit\Framework\Cascade\Params\Builder\Table;
use Handyfit\Framework\Cascade\Params\Configure;
use Handyfit\Framework\Cascade\Params\Manger;
use Handyfit\Framework\Cascade\Params\Schema;
use Illuminate\Support\Str;
use stdClass;

/**
 * Migration builder
 *
 * @author KanekiYuto
 */
class MigrationBuilder extends Builder
{

    /**
     * Migration 参数对象
     *
     * @var Params\Builder\Migration
     */
    private Params\Builder\Migration $migrationParams;

    /**
     * 构建一个 Eloquent Trace Builder 实例
     *
     * @param Configure $configureParams
     * @param Manger    $mangerParams
     * @param Migration $migrationParams
     * @param Table     $tableParams
     * @param Schema    $schemaParams
     */
    public function __construct(
        Params\Configure $configureParams,
        Params\Manger $mangerParams,
        Params\Builder\Migration $migrationParams,
        Params\Builder\Table $tableParams,
        Params\Schema $schemaParams
    ) {
        parent::__construct($configureParams, $mangerParams);

        $this->migrationParams = $migrationParams;
        $this->schemaParams = $schemaParams;
        $this->tableParams = $tableParams;
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

        $this->stubParam('summary', app(SummaryBuilder::class)->getPackage());

        $this->stubParam('hook', $this->migrationParams->getHook());
        $this->stubParam('comment', $this->migrationParams->getComment());

        $this->stubParam('upSchema', $this->schemaBuilder('up'));
        $this->stubParam('downSchema', $this->schemaBuilder('down'));

        // 写入磁盘
        $this->put($this->builderUUid(__CLASS__), $filename, $folderPath);
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
     * 构建 Schema 部分
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

        foreach ($blueprints as $fn => $blueprint) {
            $template = [];

            $template[] = "Schema::$fn(TheSummary::TABLE, function (Blueprint @table) {";
            $template[] = $this->blueprintBuilder($blueprint->getMigrations());
            $template[] = "});";

            $template = implode("\n", $template);
            $template = Str::of($template)->replace('@', '$')->toString();

            $templates[] = $template;
        }

        $templates = array_merge($templates, $codes);

        return $this->tab(implode("\n\n", $templates), 2);
    }

    /**
     * 构建 Blueprint 部分
     *
     * @param array $migrations
     *
     * @return string
     */
    private function blueprintBuilder(array $migrations): string
    {
        $templates = [];

        foreach ($migrations as $column) {
            $migrationBuilder = $this->migrationBuilder($column);

            $templates[] = Str::of("@table$migrationBuilder;")
                ->replace('@', '$')
                ->toString();
        }

        return $this->tab(implode("\n", $templates), 1, false);
    }

    /**
     * 构建 Migration 部分
     *
     * @param Params\Migration[] $migrations
     *
     * @return string
     */
    private function migrationBuilder(array $migrations): string
    {
        $templates = [];

        foreach ($migrations as $migration) {
            $fn = $migration->getFn();
            $params = $migration->getParams();
            $parameters = implode(', ', $this->parametersBuilder($params));

            $templates[] = "->$fn($parameters)";
        }

        return implode('', $templates);
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
