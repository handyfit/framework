<?php

namespace Handyfit\Framework\Cascade\Params;

/**
 * Column Params
 *
 * @author KanekiYuto
 */
class Column
{

    /**
     * 列名称
     *
     * @var string
     */
    private string $colum;

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
     * @param string $colum
     */
    public function __construct(string $colum)
    {
        $this->colum = $colum;
        $this->comment = '';
        $this->cast = '';
        $this->hidden = false;
        $this->fillable = false;
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
     * 设置是否可大量分配属性
     *
     * @param bool $value
     *
     * @return static
     */
    public function setFillable(bool $value): static
    {
        $this->fillable = $value;

        return $this;
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
     * 设置是否隐藏属性
     *
     * @param bool $value
     *
     * @return static
     */
    public function setHidden(bool $value): static
    {
        $this->hidden = $value;

        return $this;
    }

    /**
     * 获取列名称
     *
     * @return string
     */
    public function getColum(): string
    {
        return $this->colum;
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
     * 设置备注
     *
     * @param string $comment
     *
     * @return static
     */
    public function setComment(string $comment): static
    {
        $this->comment = $comment;

        return $this;
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

    /**
     * 设置应该强制转换的类型
     *
     * @param string $cast
     *
     * @return static
     */
    public function setCast(string $cast): static
    {
        $this->cast = $cast;

        return $this;
    }

}
