<?php

namespace Handyfit\Framework\Hook;

use Handyfit\Framework\Trace\EloquentTrace;
use Handyfit\Framework\Contracts\Hook\Migration as Contracts;

/**
 * [Migration] hook abstract class
 *
 * @author KanekiYuto
 */
abstract class Migration implements Contracts
{

    abstract public function upBefore(EloquentTrace $eloquentTrace): void;

    abstract public function upAfter(EloquentTrace $eloquentTrace): void;

    abstract public function downBefore(EloquentTrace $eloquentTrace): void;

    abstract public function downAfter(EloquentTrace $eloquentTrace): void;

}