<?php

namespace KanekiYuto\Handy\Cascade\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Illuminate\Contracts\Filesystem\Filesystem;

/**
 * Base Command
 *
 * @author KanekiYuto
 */
class BaseCommand extends Command
{

    /**
     * 获取所有的文件名
     *
     * @return array
     */
    public function getCascadeFilesName(): array
    {
        return collect($this->getCascadeFiles())->map(function ($path) {
            return explode('.', $path)[0];
        })->all();
    }

    /**
     * 获取所有的 [Cascade] 文件
     *
     * @return array
     */
    protected function getCascadeFiles(): array
    {
        return $this->useDisk()->files();
    }

    /**
     * 使用文件驱动
     *
     * @return Filesystem
     */
    public function useDisk(): Filesystem
    {
        return Storage::build([
            'driver' => 'local',
            'root' => $this->getCascadePath(),
        ]);
    }

    /**
     * 获取 [Cascade] 目录的路径
     *
     * @return string
     */
    protected function getCascadePath(): string
    {
        return $this->laravel->databasePath() . DIRECTORY_SEPARATOR . 'cascades';
    }

    /**
     * 获取选项型文件信息
     *
     * @return array
     */
    public function getCascadeFilesOption(): array
    {
        return collect(collect($this->getCascadeFiles())->map(function ($path) {
            $fileName = explode('.', $path)[0];
            return [$this->getCascadePath() . DIRECTORY_SEPARATOR . $path => $fileName];
        })->all())->flatMap(function (array $values) {
            return $values;
        })->all();
    }

    /**
     * 获取所有 [Cascade] 路径
     *
     * @return string[]
     */
    protected function getCascadePaths(): array
    {
        return collect($this->getCascadeFiles())->map(function ($path) {
            return $this->getCascadePath() . DIRECTORY_SEPARATOR . $path;
        })->all();
    }

}
