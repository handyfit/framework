<?php

namespace Handyfit\Framework\Tentative\Crush;

use Illuminate\Support\Facades\Request;

/**
 * Crush Builder
 *
 * @author KanekiYuto
 */
class Builder
{

    /**
     * 分页查询参数标记
     *
     * @var string
     */
    public const PAGING_PARAMS_MARK = 'query_';

    /**
     * Request
     *
     * @var Request $request
     */
    private Request $request;

    /**
     * 构造一个 Crush builder 实例
     *
     * @param Request $request
     *
     * @return void
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

}
