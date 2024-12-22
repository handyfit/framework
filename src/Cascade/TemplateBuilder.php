<?php

namespace Handyfit\Framework\Cascade;

/**
 * 存根模板
 *
 * @author KanekiYuto
 */
trait TemplateBuilder
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

        return $this->param('value', $value, $this->param('const', $const, $stub));
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

}
