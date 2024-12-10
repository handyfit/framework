<?php

namespace KanekiYuto\Handy\Cascade;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use KanekiYuto\Handy\Trace\EloquentTrace;

/**
 * 模型生命周期
 *
 * @author KanekiYuto
 */
abstract class ModelActivity
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