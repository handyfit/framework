<?php

namespace Handyfit\Framework\Cascade\Params;

use Handyfit\Framework\Cascade\Params\Configure\EloquentModel;
use Handyfit\Framework\Cascade\Params\Configure\EloquentTrace;

/**
 * Configure params
 *
 * @author KanekiYuto
 */
class Configure
{

    /**
     * 应用命名空间
     *
     * @var string
     */
    private string $appNamespace;

    /**
     * 应用文件路径
     *
     * @var string
     */
    private string $appFilePath;

    /**
     * Cascade 命名空间
     *
     * @var string
     */
    private string $cascadeNamespace;

    /**
     * Cascade 文件路径
     *
     * @var string
     */
    private string $cascadeFilepath;

    /**
     * Eloquent Trace 参数对象
     *
     * @var EloquentTrace
     */
    private EloquentTrace $eloquentTrace;

    /**
     * Eloquent Model 参数对象
     *
     * @var EloquentModel
     */
    private EloquentModel $eloquentModel;

    /**
     * 构建一个配置参数实例
     *
     * @return void
     */
    public function __construct()
    {
        $this->appNamespace = 'App';
        $this->appFilePath = 'app';
        $this->cascadeNamespace = 'Cascade';
        $this->cascadeFilepath = $this->cascadeNamespace;
        $this->eloquentTrace = new EloquentTrace();
        $this->eloquentModel = new EloquentModel();
    }

    /**
     * 获取应用命名空间
     *
     * @return string
     */
    public function getAppNamespace(): string
    {
        return $this->appNamespace;
    }

    /**
     * 获取应用文件路径
     *
     * @return string
     */
    public function getAppFilepath(): string
    {
        return $this->appFilePath;
    }

    /**
     * 获取 Cascade 命名空间
     *
     * @return string
     */
    public function getCascadeNamespace(): string
    {
        return $this->cascadeNamespace;
    }

    /**
     * 获取 Cascade 文件路径
     *
     * @return string
     */
    public function getCascadeFilepath(): string
    {
        return $this->cascadeFilepath;
    }

    /**
     * 获取 Eloquent Trace 参数对象
     *
     * @return EloquentTrace
     */
    public function getEloquentTrace(): EloquentTrace
    {
        return $this->eloquentTrace;
    }

    /**
     * 获取 getEloquent Model 参数对象
     *
     * @return EloquentModel
     */
    public function getEloquentModel(): EloquentModel
    {
        return $this->eloquentModel;
    }

}
