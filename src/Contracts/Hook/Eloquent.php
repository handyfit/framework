<?php

namespace Handyfit\Framework\Contracts\Hook;

use Handyfit\Framework\Trace\EloquentTrace;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * [Eloquent] hook interface
 *
 * @author KanekiYuto
 */
interface Eloquent
{

    /**
     * 模型插入前的操作
     *
     * @param Model         $model
     * @param Builder       $query
     * @param EloquentTrace $eloquentTrace
     *
     * @return bool
     */
    public function performInsert(Model $model, Builder $query, EloquentTrace $eloquentTrace): bool;

    /**
     * 模型更新前的操作
     *
     * @param Model         $model
     * @param Builder       $query
     * @param EloquentTrace $eloquentTrace
     *
     * @return bool
     */
    public function performUpdate(Model $model, Builder $query, EloquentTrace $eloquentTrace): bool;

}
