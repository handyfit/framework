<?php

namespace Handyfit\Framework\Contracts\Hook;

use Handyfit\Framework\Trace\EloquentTrace;

/**
 * [Migration] hook interface
 *
 * @author KanekiYuto
 */
interface Migration
{

    /**
     * 执行迁移时之前触发
     *
     * @param EloquentTrace $eloquentTrace
     *
     * @return void
     */
    public function upBefore(EloquentTrace $eloquentTrace): void;

    /**
     * 执行迁移时之后触发
     *
     * @param EloquentTrace $eloquentTrace
     *
     * @return void
     */
    public function upAfter(EloquentTrace $eloquentTrace): void;

    /**
     * 回滚迁移时之前触发
     *
     * @param EloquentTrace $eloquentTrace
     *
     * @return void
     */
    public function downBefore(EloquentTrace $eloquentTrace): void;

    /**
     * 回滚迁移时之后触发
     *
     * @param EloquentTrace $eloquentTrace
     *
     * @return void
     */
    public function downAfter(EloquentTrace $eloquentTrace): void;

}
