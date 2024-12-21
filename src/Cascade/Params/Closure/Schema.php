<?php

namespace Handyfit\Framework\Cascade\Params\Closure;

use Closure;

/**
 * Schema closure
 *
 * @author KanekiYuto
 */
class Schema
{

    /**
     * Up closure
     *
     * @var Closure
     */
    private Closure $up;

    /**
     * Down closure
     *
     * @var Closure
     */
    private Closure $down;

    /**
     * 构造一个 Schema closure 参数实例
     *
     * @param Closure $up
     * @param Closure $down
     *
     * @return void
     */
    public function __construct(Closure $up, Closure $down)
    {
        $this->up = $up;
        $this->down = $down;
    }

    /**
     * Get down closure
     *
     * @return Closure
     */
    public function getDown(): Closure
    {
        return $this->down;
    }

    /**
     * Get up closure
     *
     * @return Closure
     */
    public function getUp(): Closure
    {
        return $this->up;
    }

}
