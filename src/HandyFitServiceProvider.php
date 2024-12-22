<?php

namespace Handyfit\Framework;

use Closure;
use Illuminate\Support\Collection;
use Illuminate\Support\ServiceProvider;

/**
 * Handy service provider
 *
 * @author KanekiYuto
 */
class HandyFitServiceProvider extends ServiceProvider
{

    /**
     * Register service
     *
     * @return void
     */
    public function register(): void
    {
        $this->registerCommands()->map(function (Closure $callable, string $command) {
            $this->app->singleton($command, $callable);
        });

        $this->commands(array_keys($this->registerCommands()->all()));

        $this->registerFacades()->map(function (string $accessor, string $facade) {
            $this->app->bind($facade, $accessor);
        });
    }

    /**
     * Register commands
     *
     * @return Collection
     */
    protected function registerCommands(): Collection
    {
        return collect([
            Cascade\Console\CascadeCommand::class => function () {
                return new Cascade\Console\CascadeCommand();
            },
            Cascade\Console\MakeCommand::class => function () {
                return new Cascade\Console\MakeCommand();
            },
        ]);
    }

    /**
     * Register facades
     *
     * @return Collection
     */
    protected function registerFacades(): Collection
    {
        return collect([
            Support\Facades\Preacher::FACADE_ACCESSOR => Preacher\Builder::class,
            Support\Facades\Crush::FACADE_ACCESSOR => Tentative\Crush\Builder::class,
        ]);
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

}
