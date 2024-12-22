<?php

namespace Handyfit\Framework\Cascade\Params\Builder;

use Illuminate\Support\Str;

/**
 * Table builder params
 *
 * @todo 需要修改命名空间和文件分类机制
 * @author KanekiYuto
 */
class Table
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
     * 命名空间
     *
     * @var string
     */
    private string $namespace;

    /**
     * 类名称
     *
     * @var string
     */
    private string $classname;

    /**
     * 构建一个 Table Builder 参数实例
     *
     * @param string $table
     * @param string $comment
     *
     * @return void
     */
    public function __construct(string $table, string $comment)
    {
        $this->table = $table;
        $this->comment = $comment;

        $this->setNamespace();
        $this->setClassname();
    }

    /**
     * 获取命名空间
     *
     * @return string
     */
    public function getNamespace(): string
    {
        return $this->namespace;
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
     * 获取类名
     *
     * @return string
     */
    public function getClassname(): string
    {
        return $this->classname;
    }

    /**
     * 设置命名空间
     *
     * @return void
     */
    private function setNamespace(): void
    {
        $table = explode('_', $this->table);
        $table = collect($table)->except([count($table) - 1])->all();
        $table = implode('_', $table);

        $this->namespace = Str::of(Str::headline($table))
            ->replace(' ', '')
            ->toString();
    }

    /**
     * 设置类名称
     *
     * @return void
     */
    private function setClassname(): void
    {
        // 取最后一个名称作为最终的类名
        $classname = collect(explode('_', $this->table))->last();

        $this->classname = Str::headline($classname);
    }

}
