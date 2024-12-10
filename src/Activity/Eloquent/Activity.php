<?php

namespace KanekiYuto\Handy\Activity\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use KanekiYuto\Handy\Trace\EloquentTrace;
use KanekiYuto\Handy\Contracts\Activity\Eloquent as ActivityContractEloquent;

/**
 * [Eloquent] activity abstract class
 *
 * @author KanekiYuto
 */
abstract class Activity implements ActivityContractEloquent
{

    /**
     * 模型插入前的操作
     *
     * @param  Model          $model
     * @param  Builder        $query
     * @param  EloquentTrace  $eloquentTrace
     *
     * @return bool
     */
    abstract public function performInsert(Model $model, Builder $query, EloquentTrace $eloquentTrace): bool;

    /**
     * 模型更新前的操作
     *
     * @param  Model          $model
     * @param  Builder        $query
     * @param  EloquentTrace  $eloquentTrace
     *
     * @return bool
     */
    abstract public function performUpdate(Model $model, Builder $query, EloquentTrace $eloquentTrace): bool;

}