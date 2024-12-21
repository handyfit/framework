<?php

namespace Handyfit\Framework\Cascade\Console;

use Handyfit\Framework\Cascade\DiskManager;
use Handyfit\Framework\Console\Trait\ConfirmableTrait;
use Illuminate\Support\Str;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'make:cascade')]
class MakeCommand extends BaseCommand
{

    use ConfirmableTrait;

    /**
     * Command name
     *
     * @var string
     */
    protected $signature = 'make:cascade {name : The name of the cascade}';

    /**
     * Command description
     *
     * @var string
     */
    protected $description = 'Create a new cascade file.';

    /**
     * Execute artisan command
     *
     * @return int
     */
    public function handle(): int
    {
        $name = Str::trim($this->input->getArgument('name'));

        $stub = DiskManager::stubDisk()->get('cascade.stub');
        $stub = str_replace('{{ name }}', $name, $stub);

        static::useDisk()->put("$name.php", $stub);

        return 0;
    }

}
