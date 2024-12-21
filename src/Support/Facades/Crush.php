<?php

namespace Handyfit\Framework\Support\Facades;

use Closure;
use Illuminate\Support\Facades\Facade;

/**
 * Crush Facade
 *
 * @method static void useMsgHook(Closure $closure)
 *
 * @author KanekiTuto
 *
 * @see    \Handyfit\Framework\Tentative\Crush\Builder
 */
class Crush extends Facade
{

    /**
     * Facade accessor
     *
     * @var string
     */
    public const FACADE_ACCESSOR = 'handyfit.crush';

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
