<?php

namespace KanekiYuto\Handy\Cascade\Make;

use Illuminate\Support\Str;
use KanekiYuto\Handy\Cascade\DiskManager;
use function Laravel\Prompts\info;
use function Laravel\Prompts\error;
use function Laravel\Prompts\warning;

abstract class CascadeMake extends Make
{

    /**
     * 获取设置的命名空间
     *
     * @param  array  $values
     *
     * @return string
     */
    protected final function getConfigureNamespace(array $values): string
    {
        return implode('\\', [
            $this->configureParams->getAppNamespace(),
            $this->configureParams->getCascadeNamespace(),
            ...$values,
        ]);
    }

    /**
     * 获取默认的类名称
     *
     * @param  string  $suffix
     *
     * @return string
     */
    protected final function getDefaultClassName(string $suffix = ''): string
    {
        $table = $this->tableParams->getTable();

        $className = explode('_', $table);

        // 取最后一个名称作为最终的类名
        $className = collect($className)->last();
        $className = Str::headline($className);

        return $className . $suffix;
    }

    /**
     * 获取 [Cascade] 磁盘路径
     *
     * @param  array  $values
     *
     * @return string
     */
    protected final function cascadeDiskPath(array $values): string
    {
        return implode(DIRECTORY_SEPARATOR, [
            $this->configureParams->getAppFilepath(),
            $this->configureParams->getCascadeFilepath(),
            ...$values,
        ]);
    }

    /**
     * 写入存根内容到磁盘
     *
     * @param  string  $fileName
     * @param  string  $folderPath
     *
     * @return void
     */
    protected final function isPut(string $fileName, string $folderPath): void
    {
        $folderPath = Str::of($folderPath)
            ->replace('\\', DIRECTORY_SEPARATOR)
            ->toString();

        $folderDisk = DiskManager::useDisk($folderPath);

        if (!$folderDisk->put($fileName, $this->stub)) {
            error('创建失败...写入文件失败！');
            return;
        }

        info('创建...完成！');
        warning("文件路径: [$folderPath/$fileName]");
    }

}