<?php

namespace KanekiYuto\Handy\Cascade\Make;

use stdClass;
use Illuminate\Support\Str;
use KanekiYuto\Handy\Cascade\DiskManager;
use KanekiYuto\Handy\Cascade\Params\Column as ColumnParams;
use function Laravel\Prompts\info;
use function Laravel\Prompts\error;

/**
 * 迁移构建
 *
 * @author KanekiYuto
 */
class MigrationMake extends Make
{

    /**
     * 引导构建
     *
     * @return void
     */
    public function boot(): void
    {
        $this->run('Migration', 'migration.stub', function () {
            $table = $this->tableParams->getTable();

            $this->stubParam(
                'traceEloquent',
                $this->getTraceEloquentMake()->getPackage()
            );

            $this->stubParam('comment', $this->migrationParams->getComment());
            $this->stubParam('blueprint', $this->makeColumns());

            $folderDisk = DiskManager::migrationDisk();
            $fileName = $this->filename("cascade_create_{$table}_table");

            if (!$folderDisk->put($fileName, $this->stub)) {
                error('创建失败...写入文件失败！');
                return;
            }

            info('创建...完成！');
        });
    }

    /**
     * 构建所有列信息
     *
     * @return string
     */
    public function makeColumns(): string
    {
        $columns = $this->blueprintParams->getColumns();
        $templates = [];

        foreach ($columns as $column) {
            $templates[] = $this->makeColumn($column);
        }

        return $this->tab(implode("\n", $templates), 3);
    }

    /**
     * 构建一个完整的列定义调用
     *
     * @param  ColumnParams  $column
     *
     * @return string
     */
    public function makeColumn(ColumnParams $column): string
    {
        $template = '@table';

        foreach ($column->getMigrationParams() as $param) {
            $fn = $param->getFn();
            $params = $param->getParams();

            $template .= "->$fn(";
            $template .= implode(
                ', ',
                $this->makeParameters($params)
            );

            $template .= ')';
        }

        return Str::of($template . ';')
            ->replace('@', '$')
            ->toString();
    }

    /**
     * 构建函数参数信息
     *
     * @param  stdClass  $values
     *
     * @return array
     */
    public function makeParameters(stdClass $values): array
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
                'boolean' => $this->boolConvertString($val),
                'array' => $this->makeArrayParams($val),
                default => $val
            } : 'TheTrace::' . Str::upper($val);

            // 命名参数设置，避免顺序问题
            $parameters[] = "$key: $val";
        }

        return $parameters;
    }

    /**
     * 数组转换为参数字符串
     *
     * @param  array  $values
     *
     * @return string
     */
    private function makeArrayParams(array $values): string
    {
        return Str::of(json_encode($values, JSON_UNESCAPED_UNICODE))
            ->replace('"', '\'')
            ->replace(',', ', ')
            ->toString();
    }

}