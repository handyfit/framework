<?php

namespace KanekiYuto\Handy\Cascade\Trait\Laravel;

use stdClass;
use KanekiYuto\Handy\Cascade\ColumnDefinition;
use KanekiYuto\Handy\Cascade\Params\Column as ColumnParams;
use KanekiYuto\Handy\Cascade\Blueprint as CascadeBlueprint;
use KanekiYuto\Handy\Cascade\Params\Migration as MigrationParams;

trait Blueprint
{

	use Helper;

	/**
	 * 自动化的参数处理
	 *
	 * @param  string            $fn
	 * @param  string            $column
	 * @param  array             $params
	 * @param  CascadeBlueprint  $blueprint
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
	 * @param  string            $fn
	 * @param  string            $column
	 * @param  stdClass          $params
	 * @param  CascadeBlueprint  $blueprint
	 *
	 * @return ColumnDefinition
	 */
	protected function pushParams(
		string $fn,
		string $column,
		stdClass $params,
		CascadeBlueprint $blueprint
	): ColumnDefinition {
		$columnParams = (new ColumnParams($column))
			->addMigrationParams(new MigrationParams($fn, $params));

		$blueprint->blueprintParams->addColumn($columnParams);

		return new ColumnDefinition($columnParams);
	}

}