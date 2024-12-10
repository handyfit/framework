<?php

namespace KanekiYuto\Handy\Cascade\Make;

use Illuminate\Support\Str;
use KanekiYuto\Handy\Cascade\Params\Column as ColumnParams;

/**
 * EloquentTrace
 *
 * @author KanekiYuto
 */
class EloquentTraceMake extends CascadeMake
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
     * 引导构建
     *
     * @return void
     */
    public function boot(): void
    {
        $this->run('Eloquent Trace', 'eloquent-trace.stub', function () {
            $configureParams = $this->configureParams;
            $getMakeParams = $configureParams->getEloquentTrace();

            $className = $this->getDefaultClassName($getMakeParams->getClassSuffix());
            $namespace = $this->getConfigureNamespace([
                $getMakeParams->getNamespace(),
                $this->tableParams->getNamespace(),
            ]);

            $table = $this->tableParams->getTable();

            $this->stubParam('namespace', $namespace);
            $this->stubParam('class', $className);
            $this->stubParam('table', $table);

            $this->stubParam('primaryKey', 'self::ID');
            $this->stubParam('columns', $this->makeColumns());
            $this->stubParam('hidden', $this->makeConstantValues($this->hidden));
            $this->stubParam('fillable', $this->makeConstantValues($this->fillable));

            $folderPath = $this->cascadeDiskPath([
                $getMakeParams->getFilepath(),
                $this->tableParams->getNamespace(),
            ]);

            $this->isPut($this->filename($className), $folderPath);
        });
    }

    /**
     * 构建所有列信息
     *
     * @return string
     */
    private function makeColumns(): string
    {
        $columns = $this->blueprintParams->getColumns();
        $templates = [];

        foreach ($columns as $column) {
            $templates[] = $this->makeColumn($column);
        }

        return $this->tab(implode("\n", $templates), 1);
    }

    /**
     * 构建列参数
     *
     * @param  ColumnParams  $column
     *
     * @return string
     */
    private function makeColumn(ColumnParams $column): string
    {
        $template = [];

        $field = $column->getField();
        $constantName = Str::of($field)->upper()->toString();

        $template[] = $this->templatePropertyComment($column->getComment(), 'string');
        $template[] = $this->templateConst($constantName, $field);
        $template = implode('', $template);

        if ($column->isHidden()) {
            $this->hidden[] = $constantName;
        }

        if ($column->isFillable()) {
            $this->fillable[] = $constantName;
        }

        return $template;
    }

    /**
     * 构建常量值
     *
     * @param  array  $values
     *
     * @return string
     */
    private function makeConstantValues(array $values): string
    {
        $values = collect($values)->map(function (string $value) {
            return "self::$value";
        })->all();

        return implode(', ', $values);
    }

    /**
     * 获取引入的包完整名称
     *
     * @return string
     */
    public function getPackage(): string
    {
        return $this->getConfigureNamespace([
            $this->configureParams->getEloquentTrace()->getNamespace(),
            $this->tableParams->getNamespace(),
            $this->getDefaultClassName($this->configureParams->getEloquentTrace()->getClassSuffix()),
        ]);
    }

}