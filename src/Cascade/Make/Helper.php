<?php

namespace KanekiYuto\Handy\Cascade\Make;

use Illuminate\Support\Str;

trait Helper
{

    /**
     * 设置存根参数
     *
     * @param  string       $param
     * @param  string|bool  $value
     *
     * @return void
     */
    public function stubParam(string $param, string|bool $value): void
    {
        $value = match (gettype($value)) {
            'boolean' => $this->boolConvertString($value),
            default => $value
        };

        $this->stub = Str::of($this->stub)
            ->replace("{{ $param }}", $value)
            ->toString();
    }

    /**
     * 布尔值转换成字符串
     *
     * @param  bool  $bool
     *
     * @return string
     */
    protected final function boolConvertString(bool $bool): string
    {
        return $bool ? 'true' : 'false';
    }

    /**
     * load param to the stub
     *
     * @param  string       $param
     * @param  string|bool  $value
     * @param  string       $stub
     *
     * @return string
     */
    public function param(string $param, string|bool $value, string $stub): string
    {
        $value = match (gettype($value)) {
            'boolean' => $this->boolConvertString($value),
            default => $value
        };

        return Str::of($stub)
            ->replace("{{ $param }}", $value)
            ->toString();
    }

    /**
     * 载入存根
     *
     * @param  string|null  $stub
     *
     * @return void
     */
    protected final function load(string|null $stub): void
    {
        $this->stub = !empty($stub) ? $stub : '';
    }

    /**
     * 生成一个文件名称
     *
     * @param  string  $filename
     * @param  string  $suffix
     *
     * @return string
     */
    protected final function filename(string $filename, string $suffix = 'php'): string
    {
        return "$filename.$suffix";
    }

}