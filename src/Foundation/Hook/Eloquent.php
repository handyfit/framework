<?php

namespace Handyfit\Framework\Foundation\Hook;

use Handyfit\Framework\Hook\Eloquent as Hook;
use Handyfit\Framework\Summary\Summary;
use Handyfit\Framework\Support\Timestamp;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * 基础的模型 - Hook
 *
 * @author KanekiYuto
 */
class Eloquent extends Hook
{

    /**
     * 模型插入前的操作
     *
     * @param Model   $model
     * @param Builder $query
     * @param Summary $summary
     *
     * @return bool
     */
    public function performInsert(Model $model, Builder $query, Summary $summary): bool
    {
        if (empty($model->getAttribute($model->getKeyName()))) {
            $model->setAttribute($model->getKeyName(), Timestamp::millisecond());
        }

        $model->setAttribute($model::CREATED_AT, Timestamp::second());
        $model->setAttribute($model::UPDATED_AT, Timestamp::second());

        return true;
    }

    /**
     * 模型更新前的操作
     *
     * @param Model   $model
     * @param Builder $query
     * @param Summary $summary
     *
     * @return bool
     */
    public function performUpdate(Model $model, Builder $query, Summary $summary): bool
    {
        $model->setAttribute($model::UPDATED_AT, Timestamp::second());

        return true;
    }

}
