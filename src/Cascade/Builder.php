<?php

namespace Handyfit\Framework\Cascade;

use Handyfit\Framework\Cascade\Params\Configure;
use Handyfit\Framework\Cascade\Params\Manger;
use Illuminate\Support\Str;

use function Laravel\Prompts\error;
use function Laravel\Prompts\note;

/**
 * Builder abstract class
 *
 * @author KanekiYuto
 */
abstract class Builder
{

    use TemplateBuilder;

    /**
     * 存根内容
     *
     * @var string
     */
    protected string $stub;

    /**
     * 配置参数对象
     *
     * @var Params\Configure
     */
    protected Params\Configure $configureParams;

    /**
     * 表参数对象
     *
     * @var Params\Builder\Table
     */
    protected Params\Builder\Table $tableParams;

    /**
     * Schema 参数对象
     *
     * @var Params\Schema
     */
    protected Params\Schema $schemaParams;

    /**
     * Manger 参数对象
     *
     * @var Params\Manger
     */
    protected Params\Manger $mangerParams;

    /**
     * 构建一个 Builder 实例
     *
     * @param Configure $configureParams
     * @param Manger    $mangerParams
     */
    public function __construct(Params\Configure $configureParams, Params\Manger $mangerParams)
    {
        $this->stub = '';
        $this->configureParams = $configureParams;
        $this->mangerParams = $mangerParams;
    }

    /**
     * 引导构建
     *
     * @return void
     */
    abstract public function boot(): void;

    /**
     * 替换参数至存根
     *
     * @param string      $param
     * @param string|bool $value
     *
     * @return void
     */
    final protected function stubParam(string $param, string|bool $value): void
    {
        $this->stub = $this->param($param, $value, $this->stub);
    }

    /**
     * 替换参数
     *
     * @param string      $param
     * @param string|bool $value
     * @param string      $stub
     *
     * @return string
     */
    final protected function param(string $param, string|bool $value, string $stub): string
    {
        $value = match (gettype($value)) {
            'boolean' => $value ? 'true' : 'false',
            default => $value
        };

        return Str::of($stub)->replace("{{ $param }}", $value)->toString();
    }

    /**
     * 初始化
     *
     * @param string $classname
     * @param string $filename
     *
     * @return bool
     */
    final protected function init(string $classname, string $filename): bool
    {
        $classname = $this->builderUUid($classname);

        note("$classname: 开始构建...");

        $stubsDisk = DiskManager::stubDisk();
        $stub = $stubsDisk->get("$filename.stub");

        if (empty($stub)) {
            error("$classname: 创建失败...存根无效或不存在...");
            return false;
        }

        $this->stub = $stub;

        return true;
    }

    /**
     * 构建器唯一标识
     *
     * @param string $classname
     *
     * @return string
     */
    final protected function builderUUid(string $classname): string
    {
        $classname = collect(explode('\\', $classname))->last();

        return is_string($classname) ? $classname : '';
    }

    /**
     * 写入存根内容到磁盘
     *
     * @param string $classname
     * @param string $filename
     * @param string $folderPath
     *
     * @return void
     */
    final protected function put(string $classname, string $filename, string $folderPath): void
    {
        $folderPath = Str::of($folderPath)
            ->replace('\\', DIRECTORY_SEPARATOR)
            ->toString();

        $this->mangerParams->appendStub(
            new Params\Stub($classname, $folderPath, "$filename.php", $this->stub)
        );
    }

    /**
     * 获取 Cascade 命名空间
     *
     * @param array $values
     *
     * @return string
     */
    final protected function getCascadeNamespace(array $values): string
    {
        return $this->getAppNamespace([
            $this->configureParams->getCascade()->getNamespace(),
            ...$values,
        ]);
    }

    /**
     * 获取应用命名空间
     *
     * @param array $values
     *
     * @return string
     */
    final protected function getAppNamespace(array $values): string
    {
        return implode('\\', [
            $this->configureParams->getApp()->getNamespace(),
            ...$values,
        ]);
    }

    /**
     * 获取 Cascade 磁盘路径
     *
     * @param array $values
     *
     * @return string
     */
    final protected function getCascadeFilepath(array $values): string
    {
        return $this->getAppFilepath([
            $this->configureParams->getCascade()->getFilepath(),
            ...$values,
        ]);
    }

    /**
     * 获取应用磁盘路径
     *
     * @param array $values
     *
     * @return string
     */
    final protected function getAppFilepath(array $values): string
    {
        return implode(DIRECTORY_SEPARATOR, [
            $this->configureParams->getApp()->getFilepath(),
            ...$values,
        ]);
    }

}
