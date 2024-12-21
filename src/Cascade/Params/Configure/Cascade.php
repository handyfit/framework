<?php

namespace Handyfit\Framework\Cascade\Params\Configure;

use Illuminate\Support\Str;

/**
 * Cascade params
 *
 * @author KanekiYuto
 */
class Cascade
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
     * 构建一个 Eloquent Model 参数实例
     *
     * @param string $namespace
     *
     * @return void
     */
    public function __construct(string $namespace)
    {
        $this->namespace = $namespace;
        $this->filepath = Str::of($namespace)
            ->replace('\\', DIRECTORY_SEPARATOR)
            ->toString();
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
