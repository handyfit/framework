<?php

namespace Handyfit\Framework\Cascade\Params;

use stdClass;

/**
 * Migration params
 *
 * @author KanekiYuto
 */
class Migration
{

    /**
     * 函数名称
     *
     * @var string
     */
    private string $fn;

    /**
     * 参数对象
     *
     * @var stdClass
     */
    private stdClass $params;

    /**
     * 构造一个 Migration 参数实例
     *
     * @param  string    $fn
     * @param  stdClass  $params
     *
     * @return void
     */
    public function __construct(string $fn, stdClass $params)
    {
        $this->fn = $fn;
        $this->params = $params;
    }

    /**
     * 获取函数名称
     *
     * @return string
     */
    public function getFn(): string
    {
        return $this->fn;
    }

    /**
     * 获取参数对象
     *
     * @return stdClass
     */
    public function getParams(): stdClass
    {
        return $this->params;
    }

}