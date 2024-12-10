<?php

namespace KanekiYuto\Handy\Cascade;

use Illuminate\Support\Facades\Storage;
use Illuminate\Contracts\Filesystem\Filesystem;

/**
 * 磁盘管理
 *
 * @author KanekiYuto
 */
class DiskManager
{

    /**
     * 迁移磁盘
     *
     * @return Filesystem
     */
    public static function migrationDisk(): Filesystem
    {
        return static::useDisk(self::getMigrationPath());
    }

    /**
     * 使用磁盘
     *
     * @param  string  $root
     *
     * @return Filesystem
     */
    public static function useDisk(string $root): Filesystem
    {
        return Storage::build([
            'driver' => 'local',
            'root' => $root,
        ]);
    }

    /**
     * 获取迁移路径
     *
     * @return string
     */
    public static function getMigrationPath(): string
    {
        return database_path() . DIRECTORY_SEPARATOR . 'migrations';
    }

    /**
     * 获取应用磁盘
     *
     * @return Filesystem
     */
    public static function appDisk(): Filesystem
    {
        return static::useDisk(self::getAppPath());
    }

    /**
     * 获取应用路径
     *
     * @return string
     */
    public static function getAppPath(): string
    {
        return base_path() . DIRECTORY_SEPARATOR . 'app';
    }

    /**
     * 存根磁盘
     *
     * @return Filesystem
     */
    public static function stubDisk(): Filesystem
    {
        return static::useDisk(self::getStubPath());
    }

    /**
     * 获取存根路径
     *
     * @return string
     */
    public static function getStubPath(): string
    {
        return dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . 'stubs';
    }

}