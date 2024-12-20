<?php

namespace Handyfit\Framework\Cascade\Params;

/**
 * 列管理参数
 *
 * @author KanekiYuto
 */
class ColumnManger
{

    /**
     * 列名称
     *
     * @var string
     */
    private string $field;

    /**
     * 备注
     *
     * @var string
     */
    private string $comment;

    /**
     * 是否隐藏属性
     *
     * @var bool
     */
    private bool $hidden;

    /**
     * 是否可大量分配属性
     *
     * @var bool
     */
    private bool $fillable;

    /**
     * 应该强制转换的类型
     *
     * @var string
     */
    private string $cast;

    /**
     * 构建一个列参数实例
     *
     * @param string $field
     * @param string $comment
     * @param string $cast
     * @param bool   $hidden
     * @param bool   $fillable
     */
    public function __construct(string $field, string $comment, string $cast, bool $hidden, bool $fillable)
    {
        $this->field = $field;
        $this->comment = $comment;
        $this->cast = $cast;
        $this->hidden = $hidden;
        $this->fillable = $fillable;
    }

    /**
     * 是否可大量分配属性
     *
     * @return bool
     */
    public function isFillable(): bool
    {
        return $this->fillable;
    }

    /**
     * 是否隐藏属性
     *
     * @return bool
     */
    public function isHidden(): bool
    {
        return $this->hidden;
    }

    /**
     * 获取列名称
     *
     * @return string
     */
    public function getField(): string
    {
        return $this->field;
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
     * 获取应该强制转换的类型
     *
     * @return string
     */
    public function getCast(): string
    {
        return $this->cast;
    }

}
