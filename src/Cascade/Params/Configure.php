<?php

namespace Handyfit\Framework\Cascade\Params;

/**
 * Configure params
 *
 * @author KanekiYuto
 */
class Configure
{

    /**
     * App 参数对象
     *
     * @var Configure\App
     */
    private Configure\App $app;

    /**
     * Cascade 参数对象
     *
     * @var Configure\Cascade
     */
    private Configure\Cascade $cascade;

    /**
     * Summary 参数对象
     *
     * @var Configure\Summary
     */
    private Configure\Summary $summary;

    /**
     * Model 参数对象
     *
     * @var Configure\Model
     */
    private Configure\Model $model;

    /**
     * 构建一个配置参数实例
     *
     * @param Configure\App     $app
     * @param Configure\Cascade $cascade
     * @param Configure\Summary $summary
     * @param Configure\Model   $model
     *
     * @return void
     */
    public function __construct(
        Configure\App $app,
        Configure\Cascade $cascade,
        Configure\Summary $summary,
        Configure\Model $model
    ) {
        $this->app = $app;
        $this->cascade = $cascade;
        $this->summary = $summary;
        $this->model = $model;
    }

    /**
     * 获取 App 参数对象
     *
     * @return Configure\App
     */
    public function getApp(): Configure\App
    {
        return $this->app;
    }

    /**
     * 获取 Cascade 参数对象
     *
     * @return Configure\Cascade
     */
    public function getCascade(): Configure\Cascade
    {
        return $this->cascade;
    }

    /**
     * 获取 Model 参数对象
     *
     * @return Configure\Model
     */
    public function getModel(): Configure\Model
    {
        return $this->model;
    }

    /**
     * 获取 Summary 参数对象
     *
     * @return Configure\Summary
     */
    public function getSummary(): Configure\Summary
    {
        return $this->summary;
    }

}
