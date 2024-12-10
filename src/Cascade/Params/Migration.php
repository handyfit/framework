<?php

namespace KanekiYuto\Handy\Cascade\Params;

use stdClass;

class Migration
{

	private string $fn;

	private stdClass $params;

	public function __construct(string $fn, stdClass $params)
	{
		$this->fn = $fn;
		$this->params = $params;
	}

	public function getFn(): string
	{
		return $this->fn;
	}

	public function getParams(): stdClass
	{
		return $this->params;
	}

}