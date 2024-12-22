<?php

namespace Handyfit\Framework\Cascade\Params;

class Manger
{

    /**
     * 存根集
     *
     * @var Stub[]
     */
    private array $stubs;

    /**
     * Summaries
     *
     * @var Manger\Summary[]
     */
    private array $summaries;

    /**
     * 构建一个 Manger 实例
     *
     * @return void
     */
    public function __construct()
    {
        $this->stubs = [];
        $this->summaries = [];
    }

    /**
     * 获取所有存根
     *
     * @return array
     */
    public function getStubs(): array
    {
        return $this->stubs;
    }

    /**
     * 新增存根
     *
     * @param Stub $stub
     *
     * @return void
     */
    public function appendStub(Stub $stub): void
    {
        $this->stubs[] = $stub;
    }

    /**
     * @return Manger\Summary[]
     */
    public function getSummaries(): array
    {
        return $this->summaries;
    }

    public function appendSummary(Manger\Summary $summary): void
    {
        $this->summaries[$summary->getTable()] = $summary;
    }

}
