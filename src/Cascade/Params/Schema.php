<?php

namespace Handyfit\Framework\Cascade\Params;

use Closure;

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
     * 回调闭包
     *
     * @var Closure[]
     */
    private array $callable;

    /**
     * 蓝图集
     *
     * @var Blueprint[][]
     */
    private array $blueprints;

    /**
     * 列信息
     *
     * @var ColumnManger[]
     */
    private array $columnsManger;

    /**
     * 代码集
     *
     * @var string[][]
     */
    private array $codes;

    /**
     * 构建一个 Blueprint 参数实例
     *
     * @param string    $table
     * @param Closure[] $callable
     *
     * @return void
     */
    public function __construct(string $table, array $callable)
    {
        $this->table = $table;
        $this->callable = $callable;
        $this->columnsManger = [];
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
     * 获取回调闭包
     *
     * @param string $action
     *
     * @return Closure
     */
    public function getCallable(string $action): Closure
    {
        return $this->callable[$action] ?? fn () => null;
    }

    /**
     * 获取蓝图集
     *
     * @param string $action
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
     * @param string    $action
     * @param string    $fn
     * @param Blueprint $blueprint
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
     * 获取列管理信息
     *
     * @return array
     */
    public function getColumnsManger(): array
    {
        return $this->columnsManger;
    }

    /**
     * 新增列管理信息
     *
     * @param ColumnManger $columnManger
     *
     * @return void
     */
    public function appendColumnsManger(ColumnManger $columnManger): void
    {
        $key = $columnManger->getField();

        $this->columnsManger[$key] = $columnManger;
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
     * @param string $action
     * @param string $value
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

}
