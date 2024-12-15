<?php

namespace Handyfit\Framework\Hook;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Handyfit\Framework\Trace\EloquentTrace;
use Handyfit\Framework\Contracts\Hook\Eloquent as Contracts;

/**
 * [Eloquent] hook abstract class
 *
 * @author KanekiYuto
 */
abstract class Eloquent implements Contracts
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