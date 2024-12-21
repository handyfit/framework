<?php

namespace Handyfit\Framework\Contracts\Hook;

use Handyfit\Framework\Summary\Summary;

/**
 * [Migration] hook interface
 *
 * @author KanekiYuto
 */
interface Migration
{

    /**
     * 执行迁移时之前触发
     *
     * @param Summary $summary
     *
     * @return void
     */
    public function upBefore(Summary $summary): void;

    /**
     * 执行迁移时之后触发
     *
     * @param Summary $summary
     *
     * @return void
     */
    public function upAfter(Summary $summary): void;

    /**
     * 回滚迁移时之前触发
     *
     * @param Summary $summary
     *
     * @return void
     */
    public function downBefore(Summary $summary): void;

    /**
     * 回滚迁移时之后触发
     *
     * @param Summary $summary
     *
     * @return void
     */
    public function downAfter(Summary $summary): void;

}
