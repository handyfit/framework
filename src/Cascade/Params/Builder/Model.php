<?php

namespace Handyfit\Framework\Cascade\Params\Builder;

/**
 * Model builder params
 *
 * @author KanekiYuto
 */
class Model
{

    /**
     * 基础类
     *
     * @var string
     */
    private string $extends;

    /**
     * Hook 类
     *
     * @var string
     */
    private string $hook;

    /**
     * 是否自增
     *
     * @var bool
     */
    private bool $incrementing;

    /**
     * 是否维护时间戳
     *
     * @var bool
     */
    private bool $timestamps;

    /**
     * 构建一个 Model Builder 参数实例
     *
     * @param  string  $extends
     * @param  string  $hook
     * @param  bool    $incrementing
     * @param  bool    $timestamps
     *
     * @return void
     */
    public function __construct(string $extends, string $hook, bool $incrementing, bool $timestamps)
    {
        $this->extends = $extends;
        $this->incrementing = $incrementing;
        $this->hook = $hook;
        $this->timestamps = $timestamps;
    }

    /**
     * 获取继承类名称
     *
     * @return string
     */
    public function getExtends(): string
    {
        return $this->extends;
    }

    /**
     * 获取钩子类名称
     *
     * @return string
     */
    public function getHook(): string
    {
        return $this->hook;
    }

    /**
     * 获取是否自增
     *
     * @return bool
     */
    public function getIncrementing(): bool
    {
        return $this->incrementing;
    }

    /**
     * 获取是否维护时间戳
     *
     * @return bool
     */
    public function getTimestamps(): bool
    {
        return $this->timestamps;
    }

}