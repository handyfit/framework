<?php

namespace Handyfit\Framework\Cascade;

use Closure;

/**
 * Cascade schema
 *
 * @author KanekiYuto
 */
class Schema
{

    /**
     * Schema 参数对象
     *
     * @var Params\Schema
     */
    private Params\Schema $schemaParams;

    /**
     * 行为
     *
     * @var string
     */
    private string $action;

    /**
     * 构造一个 Schema 实例
     *
     * @param Params\Schema $schemaParams
     * @param string        $action
     *
     * @return void
     */
    public function __construct(Params\Schema $schemaParams, string $action)
    {
        $this->schemaParams = $schemaParams;
        $this->action = $action;
    }

    /**
     * 标记为 - create
     *
     * @param Closure $callable
     *
     * @return void
     */
    public function create(Closure $callable): void
    {
        $this->build(__FUNCTION__, $callable);
    }

    /**
     * 标记为 - table
     *
     * @param Closure $callable
     *
     * @return void
     */
    public function table(Closure $callable): void
    {
        $this->build(__FUNCTION__, $callable);
    }

    /**
     * 使用 dropIfExists
     *
     * @return void
     */
    public function dropIfExists(): void
    {
        $this->schemaParams->appendCodes(
            $this->action,
            "Schema::dropIfExists(TheSummary::TABLE);"
        );
    }

    /**
     * Build blueprint params
     *
     * @param string  $fn
     * @param Closure $callable
     *
     * @return void
     */
    private function build(string $fn, Closure $callable): void
    {
        $params = new Params\Blueprint($callable);

        $params->getCallable()(new Blueprint($params, $this->schemaParams));

        $this->schemaParams->setBlueprints($this->action, $fn, $params);
    }

}
