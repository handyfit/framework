<?php

namespace Handyfit\Framework\Cascade\Builder;

use Illuminate\Support\Str;
use Handyfit\Framework\Cascade\DiskManager;

/**
 * 存根模板
 *
 * @author KanekiYuto
 *
 * @todo   需要简化重构
 */
trait Template
{

    /**
     * 制表
     *
     * @param string $string
     * @param int    $quantity
     * @param bool   $first
     *
     * @return string
     */
    final protected function tab(string $string, int $quantity, bool $first = true): string
    {
        $string = explode("\n", $string);
        $tabString = [];

        foreach ($string as $key => $value) {
            if ($key !== 0 || $first === false) {
                $value = str_repeat("\t", $quantity) . $value;
            }

            $tabString[] = $value;
        }

        return implode("\n", $tabString);
    }

    /**
     * 常量声明模板
     *
     * @param string       $const
     * @param string|array $value
     *
     * @return string
     */
    final protected function templateConst(string $const, string|array $value): string
    {
        $value = match (gettype($value)) {
            'array' => '[' . implode(', ', $value) . ']',
            'string' => "'$value'",
            default => $value
        };

        $stubsDisk = DiskManager::stubDisk();
        $stub = $stubsDisk->get('template.const.stub');

        return $this->param(
            'value',
            $value,
            $this->param('const', $const, $stub)
        );
    }

    /**
     * 属性注释模板
     *
     * @param string $comment
     * @param string $var
     *
     * @return string
     */
    final protected function templatePropertyComment(string $comment, string $var): string
    {
        $stubsDisk = DiskManager::stubDisk();
        $stub = $stubsDisk->get('template.comment.property.stub');

        return $this->param(
            '@var',
            "@var " . $var,
            $this->param('comment', $comment, $stub)
        );
    }

    /**
     * 存根代码格式化
     *
     * @param string $stub
     *
     * @return string
     */
    final protected function formattingStub(string $stub): string
    {
        $stubArray = explode("\n", $stub);
        $recordRow = [];
        $returnStub = [];

        foreach ($stubArray as $index => $str) {
            if ($index === 0 || $index === count($stubArray) - 1) {
                $returnStub[] = $str;
                continue;
            }

            if (in_array($index, $recordRow)) {
                continue;
            }

            $lastRow = $stubArray[$index - 1];
            $nextRow = $stubArray[$index + 1];

            $nullRow = Str::of($str)
                ->replace(' ', '')
                ->toString();

            if (empty($lastRow) && empty($nextRow) && empty($nullRow)) {
                $recordRow[] = $index + 1;
                continue;
            }

            $returnStub[] = $str;
            $recordRow = [];
        }

        return implode("\n", $returnStub);
    }

    /**
     * 引导构建
     *
     * @return void
     */
    abstract public function boot(): void;

}
