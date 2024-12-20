<?php

namespace Handyfit\Framework\Cascade\Console;

use Handyfit\Framework\Cascade\Cascade;
use Handyfit\Framework\Console\Trait\ConfirmableTrait;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;

use function Laravel\Prompts\error;
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
    public function handle()
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

        foreach ($files as $file) {
            $result = $this->runCascade($file);

            if ($result === 1) {
                return $result;
            }
        }

        info(Str::of('|──|')->repeat(30));
        info("全部执行完成！");

        return 0;
    }

    /**
     * Run the cascade
     *
     * @param string $filepath
     *
     * @return int
     */
    private function runCascade(string $filepath): int
    {
        // 载入文件系统
        $file = new Filesystem();

        try {
            $cascade = $file->requireOnce($filepath);
        } catch (FileNotFoundException $e) {
            error("$filepath: 发生错误！" . $e->getMessage());
            return 1;
        }

        if (!($cascade instanceof Cascade)) {
            error("$filepath: 该 [Cascade] 不可用！");
            return 1;
        }

        $this->newLine();

        info("$filepath: 开始执行...");
        info(Str::of('|──|')->repeat(30));

        $cascade->create();

        return 0;
    }

}
