<?php

namespace KanekiYuto\Handy\Cascade\Console;

use Illuminate\Filesystem\Filesystem;
use KanekiYuto\Handy\Cascade\Cascade;
use Symfony\Component\Console\Attribute\AsCommand;
use KanekiYuto\Handy\Console\Trait\ConfirmableTrait;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use function Laravel\Prompts\info;
use function Laravel\Prompts\select;
use function Laravel\Prompts\warning;

#[AsCommand(name: 'handy:cascade')]
class CascadeCommand extends BaseCommand
{

    use ConfirmableTrait;

    /**
     * 命令名称
     *
     * @var string
     */
    protected $signature = 'handy:cascade';

    /**
     * 命令说明
     *
     * @var string
     */
    protected $description = '运作这个 - [Cascade]';

    /**
     * 执行控制台命令
     *
     * @return int|void
     */
    public function handle()
    {
        // 生产环境确认
        if (!$this->confirmToProceed()) {
            return 1;
        }

        // 选择需要执行的 [Cascade]
        $cascade = select(
            label: "选择需要执行的 [Cascade]！",
            options: $this->getCascadeFilesOption()
        );

        // 载入文件系统
        $file = new Filesystem();

        try {
            $cascade = $file->requireOnce($cascade);
        } catch (FileNotFoundException $e) {
            warning('发生错误！' . $e->getMessage());
            return 0;
        }

        if (!($cascade instanceof Cascade)){
            warning('该 [Cascade] 不可用！');
            return 0;
        }

        info('开始执行...');

		$cascade->create();
    }

}
