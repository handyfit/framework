<?php

namespace Handyfit\Framework\Cascade;

use Handyfit\Framework\Cascade\Params\Manger;
use Handyfit\Framework\Cascade\Params\Stub;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;

use function Laravel\Prompts\error;
use function Laravel\Prompts\info;
use function Laravel\Prompts\warning;

/**
 * Distribute
 *
 * @author KanekiYuto
 */
class Distribute
{

    /**
     * 文件路径集
     *
     * @var string[]
     */
    private array $files;

    /**
     * 创建一个 Cascade 实例
     *
     * @param array $files
     */
    public function __construct(array $files)
    {
        $this->files = $files;
    }

    /**
     * 注册
     *
     * @return void
     */
    public function register(): void
    {
        App::forgetInstance(Params\Manger::class);
        App::instance(Params\Manger::class, new Params\Manger());

        // 提供公共依赖
        App::when($this->builders()->all())
            ->needs('$configureParams')
            ->needs('$mangerParams')
            ->give([
                App::make(Params\Configure::class),
                App::make(Params\Manger::class),
            ]);
    }

    /**
     * 启动构建
     *
     * @return bool
     */
    public function boot(): bool
    {
        foreach ($this->files as $file) {
            try {
                $cascade = (new Filesystem())->getRequire($file);
            } catch (FileNotFoundException $e) {
                error("$file: 发生错误！" . $e->getMessage());
                return false;
            }

            if (!($cascade instanceof Cascade)) {
                error("$file: 该 [Cascade] 不可用！");
                return false;
            }

            $cascade->create();
        }

        app(MangerBuilder::class)->boot();

        return true;
    }

    /**
     * 写入文件
     *
     * @return void
     */
    public function write(): void
    {
        $this->writeStub();
    }

    /**
     * 构建器实例与依赖
     *
     * @return Collection
     */
    private function builders(): Collection
    {
        return collect([
            SummaryBuilder::class,
            MigrationBuilder::class,
            ModelBuilder::class,
            MangerBuilder::class,
        ]);
    }

    /**
     * 写入存根文件
     *
     * @return void
     */
    private function writeStub(): void
    {
        // 生成文件
        collect(app(Manger::class)->getStubs())->map(function (Stub $stub) {
            $name = $stub->getName();
            $filename = $stub->getFilename();
            $folderPath = $stub->getFolderPath();
            $disk = DiskManager::useDisk($folderPath);

            if (!$disk->put($filename, $stub->getStub())) {
                error("$name: 生成失败...写入文件失败！");
                return;
            }

            info("$name: 生成...完成！");
            warning("$name: 文件路径 - [$folderPath/$filename]");
        });
    }

}
