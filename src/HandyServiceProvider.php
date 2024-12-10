<?php

namespace KanekiYuto\Handy;

use Closure;
use KanekiYuto\Handy\Preacher\Builder;
use Illuminate\Support\ServiceProvider;
use KanekiYuto\Handy\Support\Facades\Preacher;
use KanekiYuto\Handy\Cascade\Console\CascadeCommand;

/**
 * Handy service provider
 *
 * @author KanekiYuto
 */
class HandyServiceProvider extends ServiceProvider
{

	/**
	 * Handy commands
	 *
	 * @var array
	 */
	protected array $commands = [
		CascadeCommand::class,
	];

	/**
	 * Register service
	 *
	 * @return void
	 */
	public function register(): void
	{
		$this->registerCommands($this->commands);

		$this->app->bind(Preacher::FACADE_ACCESSOR, Builder::class);
	}

	/**
	 * Register the given command
	 *
	 * @param  array  $commands
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
	 * @param  string  $className
	 *
	 * @return Closure
	 */
	protected function matchCommand(string $className): Closure
	{
		return match ($className) {
			CascadeCommand::class => function () {
				return new CascadeCommand();
			},
			default => function () {
				return null;
			}
		};
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
