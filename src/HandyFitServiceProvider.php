<?php

namespace Handyfit\Framework;

use Closure;
use Illuminate\Support\ServiceProvider;

/**
 * Handy service provider
 *
 * @author KanekiYuto
 */
class HandyFitServiceProvider extends ServiceProvider
{

    /**
     * Handy commands
     *
     * @var array
     */
    protected array $commands = [
        Cascade\Console\CascadeCommand::class,
        Cascade\Console\MakeCommand::class,
    ];

    /**
     * Register service
     *
     * @return void
     */
    public function register(): void
    {
        $this->registerCommands($this->commands);

        $this->app->bind(Support\Facades\Preacher::FACADE_ACCESSOR, Preacher\Builder::class);
        $this->app->bind(Support\Facades\Crush::FACADE_ACCESSOR, Tentative\Crush\Builder::class);
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
     * Register the given command
     *
     * @param array $commands
     *
     * @return void
     */
    protected function registerCommands(array $commands): void
    {
        foreach ($commands as $command) {
            $this->app->singleton($command, $this->matchCommand($command));
        }

        $this->commands(array_values($commands));
    }

    /**
     * Matches the corresponding command function
     *
     * @param string $className
     *
     * @return Closure
     */
    protected function matchCommand(string $className): Closure
    {
        return match ($className) {
            Cascade\Console\CascadeCommand::class => function () {
                return new Cascade\Console\CascadeCommand();
            },
            Cascade\Console\MakeCommand::class => function () {
                return new Cascade\Console\MakeCommand();
            },
            default => function () {
                return null;
            }
        };
    }

}
