<?php

namespace Handyfit\Framework\Cascade;

use Closure;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;

class Distribute
{

    /**
     * 文件路径集
     *
     * @var Cascade[]
     */
    private array $cascades;

    /**
     * 创建一个 Cascade 实例
     *
     * @return void
     */
    private function __construct(array $cascades)
    {
        $this->cascades = $cascades;

        $this->registerConfigure()->map(function (Closure $callable, string $configure) {
            App::bind($configure, $callable);
        });

        App::bind(Params\Configure::class, function () {
            $params = $this->registerConfigure()->keys()->map(function (string $configure) {
                return App::make($configure);
            });

            return new Params\Configure(...$params);
        });
    }

    /**
     * 注册配置项
     *
     * @return Collection
     */
    private function registerConfigure(): Collection
    {
        return collect([
            Params\Configure\App::class => function () {
                return new Params\Configure\App('App', 'app');
            },
            Params\Configure\Cascade::class => function () {
                return new Params\Configure\Cascade('Cascade');
            },
            Params\Configure\Summary::class => function () {
                return new Params\Configure\Summary('Summaries', 'Summary');
            },
            Params\Configure\Model::class => function () {
                return new Params\Configure\Model('Models', 'Model');
            },
        ]);
    }

}