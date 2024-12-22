<?php

namespace Handyfit\Framework\Cascade\Console;

use Handyfit\Framework\Cascade\Distribute;
use Handyfit\Framework\Console\Trait\ConfirmableTrait;
use Illuminate\Support\Str;

use function Laravel\Prompts\info;
use function Laravel\Prompts\multiselect;
use function Laravel\Prompts\select;
use function Laravel\Prompts\warning;

use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'handyfit:cascade')]
class CascadeCommand extends BaseCommand
{

    use ConfirmableTrait;

    /**
     * Command name
     *
     * @var string
     */
    protected $signature = 'handyfit:cascade {--pattern=all : Which mode to select the file in}';

    /**
     * Command description
     *
     * @var string
     */
    protected $description = 'Run the cascades.';

    /**
     * Execute artisan command
     *
     * @return int
     */
    public function handle(): int
    {
        $pattern = $this->option('pattern');

        if (!in_array($pattern, ['all', 'select', 'multiselect'])) {
            warning('The pattern must be all, select, or multiselect!');

            return 1;
        }

        $files = match ($pattern) {
            'select' => [
                select(
                    label: 'Select the file you want to execute!',
                    options: $this->getCascadeFilesOption()
                ),
            ],
            'multiselect' => multiselect(
                label: 'Select the files you want to execute!',
                options: $this->getCascadeFilesOption(),
                hint: 'Press the space bar to select the desired option.'
            ),
            default => array_keys($this->getCascadeFilesOption())
        };

        $distribute = new Distribute($files);

        $distribute->register();

        if (!$distribute->boot()) {
            return 1;
        }

        $distribute->write();

        info(Str::of('|──|')->repeat(30));
        info("全部执行完成！");

        return 0;
    }

}
