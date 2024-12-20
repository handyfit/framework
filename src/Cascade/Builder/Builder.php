<?php

namespace Handyfit\Framework\Cascade\Builder;

use Handyfit\Framework\Cascade\DiskManager;
use Handyfit\Framework\Cascade\Params\Blueprint as BlueprintParams;
use Handyfit\Framework\Cascade\Params\Builder\Migration as MigrationParams;
use Handyfit\Framework\Cascade\Params\Builder\Model as ModelParams;
use Handyfit\Framework\Cascade\Params\Builder\Table as TableParams;
use Handyfit\Framework\Cascade\Params\Configure as ConfigureParams;
use Handyfit\Framework\Cascade\Params\Schema as SchemaParams;
use Illuminate\Support\Str;

use function Laravel\Prompts\error;
use function Laravel\Prompts\info;
use function Laravel\Prompts\note;
use function Laravel\Prompts\warning;

/**
 * Builder abstract class
 *
 * @author KanekiYuto
 */
abstract class Builder
{

    use Template;

    /**
     * 存根内容
     *
     * @var string
     */
    protected string $stub;

    /**
     * 配置参数对象
     *
     * @var ConfigureParams
     */
    protected ConfigureParams $configureParams;

    /**
     * 表参数对象
     *
     * @var TableParams
     */
    protected TableParams $tableParams;

    /**
     * Migration 参数对象
     *
     * @var MigrationParams
     */
    protected MigrationParams $migrationParams;

    /**
     * 模型参数对象
     *
     * @var ModelParams
     */
    protected ModelParams $modelParams;

    /**
     * Blueprint 参数对象
     *
     * @var BlueprintParams
     */
    protected BlueprintParams $blueprintParams;

    /**
     * Schema 参数对象
     *
     * @var SchemaParams
     */
    protected SchemaParams $schemaParams;

    /**
     * 构建一个 Builder 实例
     *
     * @param ConfigureParams $configureParams
     * @param BlueprintParams $blueprintParams
     * @param TableParams     $tableParams
     * @param ModelParams     $modelParams
     * @param MigrationParams $migrationParams
     * @param SchemaParams    $schemaParams
     *
     * @return void
     */
    public function __construct(
        ConfigureParams $configureParams,
        BlueprintParams $blueprintParams,
        TableParams $tableParams,
        ModelParams $modelParams,
        MigrationParams $migrationParams,
        SchemaParams $schemaParams
    ) {
        $this->stub = '';
        $this->configureParams = $configureParams;
        $this->blueprintParams = $blueprintParams;
        $this->migrationParams = $migrationParams;
        $this->tableParams = $tableParams;
        $this->modelParams = $modelParams;
        $this->schemaParams = $schemaParams;
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
        $classname = $this->builderUUid($classname);

        $filename = "$filename.php";
        $folderDisk = DiskManager::useDisk($folderPath);

        if (!$folderDisk->put($filename, $this->stub)) {
            error("$classname: 创建失败...写入文件失败！");
            return;
        }

        info("$classname: 创建...完成！");
        warning("$classname: 文件路径 - [$folderPath/$filename]");
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
            $this->configureParams->getCascadeNamespace(),
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
            $this->configureParams->getAppNamespace(),
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
            $this->configureParams->getCascadeFilepath(),
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
            $this->configureParams->getAppFilepath(),
            ...$values,
        ]);
    }

    /**
     * 获取 Eloquent Trace 实例
     *
     * @return EloquentTrace
     */
    protected function getEloquentTrace(): EloquentTrace
    {
        return new EloquentTrace(
            $this->configureParams,
            $this->blueprintParams,
            $this->tableParams,
            $this->modelParams,
            $this->migrationParams,
            $this->schemaParams
        );
    }

}
