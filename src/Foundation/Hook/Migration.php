<?php

namespace Handyfit\Framework\Foundation\Hook;

use Handyfit\Framework\Hook\Migration as Hook;
use Handyfit\Framework\Summary\Summary;

/**
 * 基础的迁移 - Hook
 *
 * @author KanekiYuto
 */
class Migration extends Hook
{

    public function upBefore(Summary $summary): void
    {
        // Do it...
    }

    public function upAfter(Summary $summary): void
    {
        // Do it...
    }

    public function downBefore(Summary $summary): void
    {
        // Do it...
    }

    public function downAfter(Summary $summary): void
    {
        // Do it...
    }

}
