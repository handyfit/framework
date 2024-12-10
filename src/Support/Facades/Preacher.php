<?php

namespace KanekiYuto\Handy\Support\Facades;

use Closure;
use Illuminate\Support\Facades\Facade;
use KanekiYuto\Handy\Preacher\PreacherResponse;

/**
 * Preacher Facade
 *
 * @method static void useMessageActivity(Closure $closure)
 * @method static PreacherResponse base()
 * @method static PreacherResponse msg(string $msg)
 * @method static PreacherResponse code(int $code)
 * @method static PreacherResponse msgCode(int $code, string $msg)
 * @method static PreacherResponse paging(int $page, int $prePage, int $total, array $data)
 * @method static PreacherResponse receipt(object $data)
 * @method static PreacherResponse rows(array $data)
 * @method static PreacherResponse allow(bool $allow, mixed $pass, mixed $noPass, callable $handle = null)
 *
 * @see \KanekiYuto\Handy\Preacher\Builder
 *
 * @author KanekiTuto
 */
class Preacher extends Facade
{

    /**
     * Facade accessor
     *
     * @var string
     */
    const FACADE_ACCESSOR = 'handy.preacher';

    /**
     * Indicates whether the parsed Facade should be cached
     *
     * @var bool
     */
    protected static $cached = false;

    /**
     * Gets the registered name of the component
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return self::FACADE_ACCESSOR;
    }

}
