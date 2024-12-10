<?php

namespace KanekiYuto\Handy\Cascade\Params;

use Closure;
use KanekiYuto\Handy\Cascade\Params\Column as ColumnParams;

class Blueprint
{

	private string $table;

	private string $comment;

	private Closure $callable;

    /**
     *
     * @var ColumnParams[]
    */
	private array $columns;

	public function __construct(string $table, string $comment, Closure $callable)
	{
		$this->table = $table;
		$this->comment = $comment;
		$this->callable = $callable;
		$this->columns = [];
	}

	public function getTable(): string
	{
		return $this->table;
	}

	public function getComment(): string
	{
		return $this->comment;
	}

	public function getColumns(): array
	{
		return $this->columns;
	}

	public function getCallable(): Closure
	{
		return $this->callable;
	}

	public function addColumn(ColumnParams $column): void
	{
		$this->columns[] = $column;
	}

}