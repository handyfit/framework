<?php

namespace Handyfit\Framework\Cascade;

use Closure;
use Handyfit\Framework\Cascade\Params\ColumnManger;
use Handyfit\Framework\Cascade\Params\Schema as SchemaParams;
use Handyfit\Framework\Cascade\Params\Column as ColumnParams;
use Handyfit\Framework\Cascade\Params\Blueprint as BlueprintParams;

/**
 * Cascade schema
 *
 * @author KanekiYuto
 */
class Schema
{

    /**
     * Scheme 参数对象
     *
     * @var SchemaParams
     */
    private static SchemaParams $schemaParams;

    /**
     * 初始化
     *
     * @param  SchemaParams  $schemaParams
     *
     * @return void
     */
    public static function init(SchemaParams $schemaParams): void
    {
        static::$schemaParams = $schemaParams;

        $callable = static::$schemaParams->getCallable();

        $callable(new static());
    }

    /**
     * 标记为 - create
     *
     * @param  Closure  $callable
     *
     * @return void
     */
    public static function create(Closure $callable): void
    {
        static::build(__FUNCTION__, $callable);
    }

    /**
     * Build blueprint params
     *
     * @param  string   $fn
     * @param  Closure  $callable
     *
     * @return void
     */
    private static function build(string $fn, Closure $callable): void
    {
        $params = new BlueprintParams(
            static::$schemaParams->getTable(),
            $callable
        );

        $blueprintCallable = $params->getCallable();
        $blueprintCallable(new Blueprint($params));

        static::cloneToManger($params->getColumns());

        static::$schemaParams->setBlueprints('up', $fn, $params);
    }


    /**
     * 参数克隆至 Manger
     *
     * @param  ColumnParams[]  $columns
     *
     * @return void
     */
    private static function cloneToManger(array $columns): void
    {
        foreach ($columns as $column) {
            $columnManger = new ColumnManger(
                $column->getField(),
                $column->getComment(),
                $column->getCast(),
                $column->isHidden(),
                $column->isFillable()
            );

            static::$schemaParams->appendColumnsManger($columnManger);
        }
    }

    /**
     * 标记为 - table
     *
     * @param  Closure  $callable
     *
     * @return void
     */
    public static function table(Closure $callable): void
    {
        static::build(__FUNCTION__, $callable);
    }

}