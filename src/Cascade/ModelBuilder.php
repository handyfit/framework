<?php

namespace Handyfit\Framework\Cascade;

use Illuminate\Support\Str;

/**
 * Model builder
 *
 * @author KanekiYuto
 */
class ModelBuilder extends Builder
{

    /**
     * 模型强制转换类型
     *
     * @var array
     */
    private array $casts = [];

    /**
     * 模型包
     *
     * @var array
     */
    private array $packages = [];

    /**
     * 构建参数
     *
     * @var Params\Configure\Model
     */
    private Params\Configure\Model $builderParams;

    /**
     * Model 参数对象
     *
     * @var Params\Builder\Model
     */
    private Params\Builder\Model $modelParams;

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
     * 构建一个 Eloquent Trace Builder 实例
     *
     * @param Params\Configure     $configureParams
     * @param Params\Builder\Table $tableParams
     * @param Params\Builder\Model $modelParams
     * @param Params\Schema        $schemaParams
     *
     * @return void
     */
    public function __construct(
        Params\Configure $configureParams,
        Params\Builder\Table $tableParams,
        Params\Builder\Model $modelParams,
        Params\Schema $schemaParams
    ) {
        parent::__construct($configureParams, $tableParams, $schemaParams);

        $this->modelParams = $modelParams;
        $this->builderParams = $configureParams->getModel();

        // 类名称由表名称决定
        $this->classname = implode('', [
            $tableParams->getClassname(),
            $this->builderParams->getClassSuffix(),
        ]);

        // 命名空间
        $this->namespace = $this->getCascadeNamespace([
            $this->builderParams->getNamespace(),
            $tableParams->getNamespace(),
        ]);
    }

    /**
     * 引导构建
     *
     * @return void
     */
    public function boot(): void
    {
        // 初始化 - 载入存根
        if (!$this->init(__CLASS__, 'model.base')) {
            return;
        }

        $this->columnsMangerBuilder();

        // 文件夹路径
        $folderPath = $this->getCascadeFilepath([
            $this->builderParams->getFilepath(),
            $this->tableParams->getNamespace(),
        ]);

        $this->stubParam('namespace', $this->namespace);
        $this->stubParam('class', $this->classname);
        $this->stubParam('comment', '');

        $this->stubParam('summary', app(SummaryBuilder::class)->getPackage());

        $this->stubParam('timestamps', $this->modelParams->getTimestamps());
        $this->stubParam('incrementing', $this->modelParams->getIncrementing());
        $this->stubParam('extends', $this->modelParams->getExtends());
        $this->stubParam('hook', $this->modelParams->getHook());

        $this->stubParam('casts', $this->castsBuilder());
        $this->stubParam('usePackages', $this->usePackagesBuilder());

        // 写入磁盘
        $this->put($this->builderUUid(__CLASS__), $this->classname, $folderPath);
    }

    /**
     * 构建所有列信息
     *
     * @return void
     */
    private function columnsMangerBuilder(): void
    {
        $columns = $this->schemaParams->getColumns();

        foreach ($columns as $column) {
            $field = $column->getColum();

            if (!empty($column->getCast())) {
                $key = Str::upper($field);
                $this->casts["TheSummary::$key"] = $column->getCast();
            }
        }
    }

    /**
     * Cats 信息构建
     *
     * @return string
     */
    private function castsBuilder(): string
    {
        if (empty($this->casts)) {
            return 'return array_merge(parent::casts(), []);';
        }

        $templates[] = 'return array_merge(parent::casts(), [';

        $casts = collect($this->casts)->map(function (string $value, string $key) {
            if (class_exists($value)) {
                // 使用类名加后缀的方式防止相同命名
                $classname = explode('\\', $value);
                $classname = $classname[count($classname) - 1];
                $classname = "{$classname}CastPackage";

                $namespace = "$value as $classname";
                $value = "$classname::class";

                $this->appendPackages($namespace);
            } else {
                $value = "'$value'";
            }

            return "\t$key => $value,";
        })->all();

        $templates = array_merge($templates, $casts);
        $templates[] = ']);';

        return implode("\n\t\t", $templates);
    }

    /**
     * 加入到包中
     *
     * @param string $value
     *
     * @return void
     */
    private function appendPackages(string $value): void
    {
        if (!in_array($value, $this->packages)) {
            $this->packages[] = $value;
        }
    }

    /**
     * 使用包信息构建
     *
     * @return string
     */
    private function usePackagesBuilder(): string
    {
        $packages = collect($this->packages)->map(function (string $value) {
            return "use $value;";
        })->all();

        return implode("\n", $packages);
    }

}
