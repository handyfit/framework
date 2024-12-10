<?php

namespace KanekiYuto\Handy\Cascade\Make;

use Illuminate\Support\Str;

/**
 * 模型构建
 *
 * @author KanekiYuto
 */
class ModelMake extends CascadeMake
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

    public function boot(): void
    {
        $this->run('Model', 'model.base.stub', function () {
            $configureParams = $this->configureParams;
            $getMakeParams = $configureParams->getModel();

            $className = $this->getDefaultClassName($getMakeParams->getClassSuffix());
            $namespace = $this->getConfigureNamespace([
                $getMakeParams->getNamespace(),
                $this->tableParams->getNamespace(),
            ]);

            $this->makeColumns();
            $this->stubParam('namespace', $namespace);
            $this->stubParam('class', $className);
            $this->stubParam('comment', '');

            $this->stubParam(
                'traceEloquent',
                $this->getTraceEloquentMake()->getPackage()
            );

            $this->stubParam('timestamps', $this->modelParams->getTimestamps());
            $this->stubParam('incrementing', $this->modelParams->getIncrementing());

            $this->stubParam('extends', $this->modelParams->getExtends());
            $this->stubParam('activity', $this->modelParams->getActivity());

            $this->stubParam('casts', $this->makeCasts());
            $this->stubParam('usePackages', $this->makeUsePackages());

            $this->stub = $this->formattingStub($this->stub);

            $folderPath = $this->cascadeDiskPath([
                $getMakeParams->getFilepath(),
                $this->tableParams->getNamespace(),
            ]);

            $this->isPut($this->filename($className), $folderPath);
        });
    }

    private function makeColumns(): void
    {
        $columns = $this->blueprintParams->getColumns();

        foreach ($columns as $column) {
            $field = $column->getField();

            if (!empty($column->getCast())) {
                $field = Str::upper($field);
                $this->casts["TheEloquentTrace::$field"] = $column->getCast();
            }
        }
    }

    private function makeCasts(): string
    {
        if (empty($this->casts)) {
            return 'return array_merge(parent::casts(), []);';
        }

        $templates[] = 'return array_merge(parent::casts(), [';

        $casts = collect($this->casts)->map(function (string $value, string $key) {

            if (class_exists($value)) {
                $namespace = explode('\\', $value);
                $className = $namespace[count($namespace) - 1];
                $value = "$className::class";
                $this->addPackage(implode('\\', $namespace));
            } else {
                $value = "'$value'";
            }

            return "\t$key => $value,";
        })->all();

        $templates = array_merge($templates, $casts);
        $templates[] = ']);';

        return implode("\n\t\t", $templates);
    }

    private function addPackage(string $value): void
    {
        if (!in_array($value, $this->packages)) {
            $this->packages[] = $value;
        }
    }

    private function makeUsePackages(): string
    {
        $packages = collect($this->packages)->map(function (string $value) {
            return "use $value;";
        })->all();

        return implode("\n", $packages);
    }

}