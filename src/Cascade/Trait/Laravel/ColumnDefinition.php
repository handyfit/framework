<?php

namespace Handyfit\Framework\Cascade\Trait\Laravel;

use stdClass;
use Handyfit\Framework\Cascade\Params\Migration as MigrationParams;
use Handyfit\Framework\Cascade\ColumnDefinition as CascadeColumnDefinition;

trait ColumnDefinition
{

	use Helper;

	protected function autoParams(
		string $fn,
		array $params,
		CascadeColumnDefinition $columnDefinition
	): CascadeColumnDefinition {
		return $this->pushParams($fn,
			$this->useParams(__CLASS__, $fn, $params),
			$columnDefinition
		);
	}

	protected function pushParams(
		string $fn,
		stdClass $params,
		CascadeColumnDefinition $columnDefinition
	): CascadeColumnDefinition {
		$columnDefinition->columnParams->addMigrationParams(
			new MigrationParams($fn, $params)
		);

		return $columnDefinition;
	}

}