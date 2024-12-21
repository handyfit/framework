<?php

namespace Handyfit\Framework\Summary;

use ReflectionClass;

/**
 * Summary - Tentative
 *
 * @author KanekiYuto
 */
class Summary
{

    /**
     * 表名称
     *
     * @var string
     */
    public const TABLE = '';

    /**
     * 隐藏的属性
     *
     * @var array<int, string>
     */
    public const HIDDEN = [];

    /**
     * 可填充的属性
     *
     * @var array<int, string>
     */
    public const FILLABLE = [];

    /**
     * Gets all column names
     *
     * @return array
     */
    public static function getAllColumns(): array
    {
        $constants = self::getConstants();

        return array_filter($constants, function (string $key) {
            return !in_array($key, ['TABLE', 'HIDDEN', 'FILLABLE']);
        }, ARRAY_FILTER_USE_KEY);
    }

    /**
     * Gets all subclass constants
     *
     * @return array
     */
    private static function getConstants(): array
    {
        return (new ReflectionClass(
            get_called_class()
        ))->getConstants();
    }

}
