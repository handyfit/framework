<?php

namespace Handyfit\Framework\Hook;

use Handyfit\Framework\Contracts\Hook\Eloquent as Contracts;
use Handyfit\Framework\Summary\Summary;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

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
     * @param Model   $model
     * @param Builder $query
     * @param Summary $summary
     *
     * @return bool
     */
    abstract public function performInsert(Model $model, Builder $query, Summary $summary): bool;

    /**
     * 模型更新前的操作
     *
     * @param Model   $model
     * @param Builder $query
     * @param Summary $summary
     *
     * @return bool
     */
    abstract public function performUpdate(Model $model, Builder $query, Summary $summary): bool;

}
