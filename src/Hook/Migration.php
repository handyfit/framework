<?php

namespace Handyfit\Framework\Hook;

use Handyfit\Framework\Contracts\Hook\Migration as Contracts;
use Handyfit\Framework\Summary\Summary;

/**
 * [Migration] hook abstract class
 *
 * @author KanekiYuto
 */
abstract class Migration implements Contracts
{

    abstract public function upBefore(Summary $summary): void;

    abstract public function upAfter(Summary $summary): void;

    abstract public function downBefore(Summary $summary): void;

    abstract public function downAfter(Summary $summary): void;

}
