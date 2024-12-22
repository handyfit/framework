<?php

namespace Handyfit\Framework\Cascade\Params;

/**
 * Schema params
 *
 * @author KanekiYuto
 */
class Schema
{

    /**
     * 表名称
     *
     * @var string
     */
    private string $table;

    /**
     * 列参数信息集
     *
     * @var Column[]
     */
    private array $columns;

    /**
     * 蓝图集
     *
     * @var Blueprint[][]
     */
    private array $blueprints;

    /**
     * 代码集
     *
     * @var string[][]
     */
    private array $codes;

    /**
     * 构建一个 Blueprint 参数实例
     *
     * @param  string  $table
     *
     * @return void
     */
    public function __construct(string $table)
    {
        $this->table = $table;
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
     * 获取蓝图集
     *
     * @param  string  $action
     *
     * @return Blueprint[]
     */
    public function getBlueprints(string $action): array
    {
        return $this->blueprints[$action] ?? [];
    }

    /**
     * 新增蓝图信息
     *
     * @param  string     $action
     * @param  string     $fn
     * @param  Blueprint  $blueprint
     *
     * @return void
     */
    public function setBlueprints(string $action, string $fn, Blueprint $blueprint): void
    {
        if (!isset($this->blueprints[$action])) {
            $this->blueprints[$action] = [];
        }

        $this->blueprints[$action][$fn] = $blueprint;
    }

    /**
     * 获取代码集
     *
     * @return string[]
     */
    public function getCodes(string $action): array
    {
        return $this->codes[$action] ?? [];
    }

    /**
     * 新增代码
     *
     * @param  string  $action
     * @param  string  $value
     *
     * @return void
     */
    public function appendCodes(string $action, string $value): void
    {
        if (!isset($this->codes[$action])) {
            $this->codes[$action] = [];
        }

        $this->codes[$action][] = $value;
    }

    /**
     * 获取列信息集
     *
     * @return Column[]
     */
    public function getColumns(): array
    {
        return $this->columns;
    }

    /**
     * 获取指定列的信息
     *
     * @param  string  $column
     *
     * @return Column
     */
    public function getColumn(string $column): Column
    {
        return $this->columns[$column];
    }

    /**
     * 新增列信息
     *
     * @param  Column  $column
     *
     * @return void
     */
    public function appendColumn(Column $column): void
    {
        $this->columns[$column->getColum()] = $column;
    }

}
