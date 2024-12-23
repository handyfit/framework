<?php

namespace Handyfit\Framework\Cascade\Params\Builder;

use Illuminate\Support\Str;

/**
 * Table builder params
 *
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
     * 类名称
     *
     * @var string
     */
    private string $classname;

    /**
     * 构建一个 Table Builder 参数实例
     *
     * @param  string  $table
     * @param  string  $comment
     *
     * @return void
     */
    public function __construct(string $table, string $comment)
    {
        $this->table = $table;
        $this->comment = $comment;

        $this->setClassname();
    }

    /**
     * 设置类名称
     *
     * @return void
     */
    private function setClassname(): void
    {
        // 取最后一个名称作为最终的类名
        $table = explode('_', $this->table);
        $table = collect($table)->only([
            count($table) - 1,
            count($table) - 2,
        ]);

        $classname = $table->implode('_');

        $this->classname = Str::of($classname)
            ->headline()
            ->replace(' ', '')
            ->toString();
    }

    /**
     * 获取命名空间
     *
     * @return array
     */
    public function getNamespace(): array
    {
        $table = Str::of($this->table)->headline()->explode(' ');

        // 移除最后两个
        return collect($table)->except([
            count($table) - 1,
            count($table) - 2,
        ])->all();
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

}
