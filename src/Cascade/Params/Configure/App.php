<?php

namespace Handyfit\Framework\Cascade\Params\Configure;

/**
 * App params
 *
 * @author KanekiYuto
 */
class App
{

    /**
     * 命名空间
     *
     * @var string
     */
    private string $namespace;

    /**
     * 文件路径
     *
     * @var string
     */
    private string $filepath;

    /**
     * 构建一个 App 参数实例
     *
     * @param string $namespace
     * @param string $filepath
     *
     * @return void
     */
    public function __construct(string $namespace, string $filepath)
    {
        $this->namespace = $namespace;
        $this->filepath = $filepath;
    }

    /**
     * 获取命名空间
     *
     * @return string
     */
    public function getNamespace(): string
    {
        return $this->namespace;
    }

    /**
     * 获取文件路径
     *
     * @return string
     */
    public function getFilepath(): string
    {
        return $this->filepath;
    }

}
