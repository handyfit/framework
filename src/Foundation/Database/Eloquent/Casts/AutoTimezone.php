<?php

namespace KanekiYuto\Handy\Foundation\Database\Eloquent\Casts;

use Exception;
use DateTimeZone;
use DateTimeImmutable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Request;
use KanekiYuto\Handy\Support\IdeIgnore;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

/**
 * [Eloquent - Cast] 自动时间转换
 *
 * @author KanekiYuto
 */
class AutoTimezone implements CastsAttributes
{

    /**
     * 对提取的数据进行转换
     *
     * @param  Model   $model
     * @param  string  $key
     * @param  mixed   $value
     * @param  array   $attributes
     *
     * @return string
     */
    public function get(Model $model, string $key, mixed $value, array $attributes): string
    {
        IdeIgnore::noUseParam($model, $key, $attributes);
        $timezone = Request::header('timezone');

        try {
            return (new DateTimeImmutable())
                ->setTimestamp($value)
                ->setTimezone(new DateTimeZone($timezone))
                ->format('Y-m-d H:i:s');
        } catch (Exception) {
            return date('Y-m-d H:i:s', $value);
        }
    }

    /**
     * 转换为将被存储的值
     *
     * @param  Model   $model
     * @param  string  $key
     * @param  array   $value
     * @param  array   $attributes
     *
     * @return int
     */
    public function set(Model $model, string $key, mixed $value, array $attributes): int
    {
        IdeIgnore::noUseParam($model, $key, $attributes);

        return (int) $value;
    }

}
