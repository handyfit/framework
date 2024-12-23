<?php

namespace Handyfit\Framework;

use Closure;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;

/**
 * HandyFit cascade service provider
 *
 * @author KanekiYuto
 */
class CascadeServiceProvider extends ServiceProvider
{

    /**
     * Register service
     *
     * @return void
     */
    public function register(): void
    {
        $this->registerConfigure()->map(function (Closure $callable, string $configure) {
            App::bind($configure, $callable);
        });

        App::bind(Cascade\Params\Configure::class, function () {
            $params = $this->registerConfigure()->keys()->map(function (string $configure) {
                return App::make($configure);
            });

            return new Cascade\Params\Configure(...$params);
        });
    }

    /**
     * Bootstrap service
     *
     * @return void
     */
    public function boot()
    {
        // ...
    }

    /**
     * 配置依赖注册
     *
     * @return Collection
     */
    private function registerConfigure(): Collection
    {
        return collect([
            Cascade\Params\Configure\App::class => function () {
                return new Cascade\Params\Configure\App('App', 'app');
            },
            Cascade\Params\Configure\Cascade::class => function () {
                return new Cascade\Params\Configure\Cascade('Cascade');
            },
            Cascade\Params\Configure\Summary::class => function () {
                return new Cascade\Params\Configure\Summary('Summaries', 'Summary');
            },
            Cascade\Params\Configure\Model::class => function () {
                return new Cascade\Params\Configure\Model('Models', 'Model');
            },
        ]);
    }

}
