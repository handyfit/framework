<?php

namespace Handyfit\Framework\Cascade\Params\Configure;

use Illuminate\Support\Str;

/**
 * Eloquent Trace
 *
 * @author KanekiYuto
 */
class Summary
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
     * 类名后缀
     *
     * @var string
     */
    private string $classSuffix;

    /**
     * 构建一个 Summary 参数实例
     *
     * @param string $namespace
     * @param string $classSuffix
     *
     * @return void
     */
    public function __construct(string $namespace, string $classSuffix)
    {
        $this->namespace = $namespace;
        $this->filepath = Str::of($namespace)
            ->replace('\\', DIRECTORY_SEPARATOR)
            ->toString();
        $this->classSuffix = $classSuffix;
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

    /**
     * 获取类名后缀
     *
     * @return string
     */
    public function getClassSuffix(): string
    {
        return $this->classSuffix;
    }

}
