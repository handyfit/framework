<?php

namespace Handyfit\Framework\Cascade\Trait\Laravel;

use Handyfit\Framework\Cascade\Blueprint as CascadeBlueprint;
use Handyfit\Framework\Cascade\ColumnDefinition;
use Handyfit\Framework\Cascade\Params\Column as ColumnParams;
use Handyfit\Framework\Cascade\Params\Migration as MigrationParams;
use stdClass;

/**
 * @todo 需要重新整合
 */
trait Blueprint
{

    use Helper;

    /**
     * 自动化的参数处理
     *
     * @param string           $fn
     * @param string           $column
     * @param array            $params
     * @param CascadeBlueprint $blueprint
     *
     * @return ColumnDefinition
     */
    protected function autoParams(
        string $fn,
        string $column,
        array $params,
        CascadeBlueprint $blueprint
    ): ColumnDefinition {
        return $this->pushParams(
            $fn,
            $column,
            $this->useParams(__CLASS__, $fn, $params),
            $blueprint
        );
    }

    /**
     * 把参数加入到对象树中
     *
     * @param string           $fn
     * @param string           $column
     * @param stdClass         $params
     * @param CascadeBlueprint $blueprint
     *
     * @return ColumnDefinition
     */
    protected function pushParams(
        string $fn,
        string $column,
        stdClass $params,
        CascadeBlueprint $blueprint
    ): ColumnDefinition {
        $columnParams = (new ColumnParams($column))->appendMigrationParams(new MigrationParams($fn, $params));

        $blueprint->blueprintParams->appendColumn($columnParams);

        return new ColumnDefinition($columnParams);
    }

}
