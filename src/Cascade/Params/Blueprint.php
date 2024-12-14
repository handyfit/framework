<?php

namespace Handyfit\Framework\Cascade\Params;

use Closure;
use Handyfit\Framework\Cascade\Params\Column as ColumnParams;

/**
 * Blueprint Params
 *
 * @author KanekiYuto
 */
class Blueprint
{

    /**
     * 表名称
     *
     * @var string
     */
    private string $table;

    /**
     * 备注
     *
     * @var string
     */
    private string $comment;

    /**
     * 回调闭包
     *
     * @var Closure
     */
    private Closure $callable;

    /**
     * 列参数信息集
     *
     * @var ColumnParams[]
     */
    private array $columns;

    /**
     * 构建一个 Blueprint 参数实例
     *
     * @param  string   $table
     * @param  string   $comment
     * @param  Closure  $callable
     *
     * @return void
     */
    public function __construct(string $table, string $comment, Closure $callable)
    {
        $this->table = $table;
        $this->comment = $comment;
        $this->callable = $callable;
        $this->columns = [];
    }

    /**
     * 获取表名称
     *
     * @return string
     */
    public function getTable(): string
    {
        return $this->table;
    }

    /**
     * 获取备注
     *
     * @return string
     */
    public function getComment(): string
    {
        return $this->comment;
    }

    /**
     * 获取列信息集
     *
     * @return array
     */
    public function getColumns(): array
    {
        return $this->columns;
    }

    /**
     * 获取回调闭包
     *
     * @return Closure
     */
    public function getCallable(): Closure
    {
        return $this->callable;
    }

    /**
     * 新增列信息
     *
     * @param  Column  $column
     *
     * @return void
     */
    public function appendColumn(ColumnParams $column): void
    {
        $this->columns[] = $column;
    }

}