<?php

namespace Handyfit\Framework\Cascade;

use Handyfit\Framework\Cascade\Params\Builder\Table;
use Handyfit\Framework\Cascade\Params\Configure;
use Handyfit\Framework\Cascade\Params\Manger;
use Handyfit\Framework\Cascade\Params\Schema;
use Illuminate\Support\Str;

/**
 * Summary builder
 *
 * @author KanekiYuto
 */
class SummaryBuilder extends Builder
{

    /**
     * property
     *
     * @var array
     */
    private array $hidden = [];

    /**
     * property
     *
     * @var array
     */
    private array $fillable = [];

    /**
     * 类名称
     *
     * @var string
     */
    private string $classname;

    /**
     * 命名空间
     *
     * @var string
     */
    private string $namespace;

    /**
     * 构建参数
     *
     * @var Params\Configure\Summary
     */
    private Params\Configure\Summary $builderParams;

    /**
     * 构建一个 Eloquent Trace Builder 实例
     *
     * @param Configure $configureParams
     * @param Table     $tableParams
     * @param Manger    $mangerParams
     * @param Schema    $schemaParams
     */
    public function __construct(
        Params\Configure $configureParams,
        Params\Builder\Table $tableParams,
        Params\Manger $mangerParams,
        Params\Schema $schemaParams
    ) {
        parent::__construct($configureParams, $mangerParams);

        $this->builderParams = $configureParams->getSummary();

        // 类名称由表名称决定
        $this->classname = implode('', [
            $tableParams->getClassname(),
            $this->builderParams->getClassSuffix(),
        ]);

        // 命名空间
        $this->namespace = $this->getCascadeNamespace([
            $this->builderParams->getNamespace(),
            ...$tableParams->getNamespace(),
        ]);

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
        if (!$this->init(__CLASS__, 'summary')) {
            return;
        }

        $table = $this->tableParams->getTable();

        // 文件夹路径
        $folderPath = $this->getCascadeFilepath([
            $this->builderParams->getFilepath(),
            ...$this->tableParams->getNamespace(),
        ]);

        // 设置参数到存根
        $this->stubParam('namespace', $this->namespace);
        $this->stubParam('class', $this->classname);
        $this->stubParam('table', $table);
        $this->stubParam('primaryKey', 'self::ID');

        $this->stubParam('columns', $this->columnsBuilder());

        $this->stubParam('hidden', $this->constantValuesBuilder($this->hidden));
        $this->stubParam('fillable', $this->constantValuesBuilder($this->fillable));

        app(Params\Manger::class)->appendSummary(
            new Manger\Summary($table, $this->getPackage())
        );

        // 写入磁盘
        $this->put($this->builderUUid(__CLASS__), $this->classname, $folderPath);
    }

    /**
     * 对外提供的引入包名称
     *
     * @return string
     */
    public function getPackage(): string
    {
        return implode('\\', [
            $this->namespace,
            $this->classname,
        ]);
    }

    /**
     * 构建所有列信息
     *
     * @return string
     */
    private function columnsBuilder(): string
    {
        $columns = $this->schemaParams->getColumns();
        $templates = [];

        foreach ($columns as $column) {
            $templates[] = $this->columnBuilder($column);
        }

        return $this->tab(implode("\n\n", $templates), 1);
    }

    /**
     * 构建列参数
     *
     * @param Params\Column $column
     *
     * @return string
     */
    private function columnBuilder(Params\Column $column): string
    {
        $template = [];

        $field = $column->getColum();
        $constantName = Str::of($field)->upper()->toString();

        $template[] = $this->templatePropertyComment($column->getComment(), 'string');
        $template[] = $this->templateConst($constantName, $field);
        $template = implode("\n", $template);

        if ($column->isHidden()) {
            $this->hidden[] = $constantName;
        }

        if ($column->isFillable()) {
            $this->fillable[] = $constantName;
        }

        return $template;
    }

    /**
     * 构建所有常量值
     *
     * @param array $values
     *
     * @return string
     */
    private function constantValuesBuilder(array $values): string
    {
        $values = collect($values)->map(function (string $value) {
            return "self::$value";
        })->all();

        return implode(', ', $values);
    }

}
