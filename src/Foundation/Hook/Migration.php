<?php

namespace Handyfit\Framework\Foundation\Hook;

use Handyfit\Framework\Hook\Migration as Hook;
use Handyfit\Framework\Trace\EloquentTrace;

/**
 * 基础的迁移 - Hook
 *
 * @author KanekiYuto
 */
class Migration extends Hook
{

    public function upBefore(EloquentTrace $eloquentTrace): void
    {
        // Do it...
    }

    public function upAfter(EloquentTrace $eloquentTrace): void
    {
        // Do it...
    }

    public function downBefore(EloquentTrace $eloquentTrace): void
    {
        // Do it...
    }

    public function downAfter(EloquentTrace $eloquentTrace): void
    {
        // Do it...
    }

}
