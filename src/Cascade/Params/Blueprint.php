<?php

namespace Handyfit\Framework\Cascade\Params;

use Closure;

/**
 * Blueprint Params
 *
 * @author KanekiYuto
 */
class Blueprint
{

    /**
     * 回调闭包
     *
     * @var Closure
     */
    private Closure $callable;

    /**
     * 迁移参数信息集
     *
     * @var Migration[][]
     */
    private array $migrations;

    /**
     * 构建一个 Blueprint 参数实例
     *
     * @param  Closure  $callable
     *
     * @return void
     */
    public function __construct(Closure $callable)
    {
        $this->callable = $callable;
        $this->migrations = [];
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
     * 获取所有迁移参数信息集
     *
     * @return Migration[][]
     */
    public function getMigrations(): array
    {
        return $this->migrations;
    }

    /**
     * 获取指定列的迁移参数信息集
     *
     * @return Migration[]
     */
    public function getColumnMigrations(string $colum): array
    {
        return $this->migrations[$colum] ?? [];
    }

    /**
     * 设置迁移参数信息集
     *
     * @param  string     $colum
     * @param  Migration  $migration
     *
     * @return static
     */
    public function appendMigration(string $colum, Migration $migration): static
    {
        $this->migrations[$colum][] = $migration;

        return $this;
    }

}
