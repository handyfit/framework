<?php

namespace Handyfit\Framework\Foundation\Hook;

use Handyfit\Framework\Support\Timestamp;
use Illuminate\Database\Eloquent\Builder;
use Handyfit\Framework\Trace\EloquentTrace;
use Illuminate\Database\Eloquent\Model as EloquentModel;
use Handyfit\Framework\Hook\Eloquent as EloquentHook;

/**
 * 基础的模型钩子
 *
 * @author KanekiYuto
 */
class Eloquent extends EloquentHook
{

    /**
     * 模型插入前的操作
     *
     * @param  EloquentModel  $model
     * @param  Builder        $query
     * @param  EloquentTrace  $eloquentTrace
     *
     * @return bool
     */
    public function performInsert(EloquentModel $model, Builder $query, EloquentTrace $eloquentTrace): bool
    {
        $model->setAttribute($model->getKeyName(), Timestamp::millisecond());
        $model->setAttribute($model::CREATED_AT, Timestamp::second());
        $model->setAttribute($model::UPDATED_AT, Timestamp::second());

        return true;
    }

    /**
     * 模型更新前的操作
     *
     * @param  EloquentModel  $model
     * @param  Builder        $query
     * @param  EloquentTrace  $eloquentTrace
     *
     * @return bool
     */
    public function performUpdate(EloquentModel $model, Builder $query, EloquentTrace $eloquentTrace): bool
    {
        $model->setAttribute($model::UPDATED_AT, Timestamp::second());

        return true;
    }

}