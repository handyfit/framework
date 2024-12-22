<?php

namespace Handyfit\Framework\Cascade;

use Closure;
use Handyfit\Framework\Cascade\Params\Blueprint;
use Handyfit\Framework\Cascade\Params\Schema;
use Illuminate\Contracts\Database\Query\Expression;
use stdClass;

/**
 * 列定义
 *
 * @author KanekiYuto
 */
class ColumnDefinition
{

    use Trait\Helper;

    /**
     * 列名称
     *
     * @var string
     */
    private string $column;

    /**
     * Blueprint params
     *
     * @var Params\Blueprint
     */
    private Params\Blueprint $blueprintParams;

    /**
     * Schema params
     *
     * @var Params\Schema
     */
    private Params\Schema $schemaParams;

    /**
     * 构造一个列定义实例
     *
     * @param string    $column
     * @param Blueprint $blueprint
     * @param Schema    $schema
     *
     * @return void
     */
    public function __construct(string $column, Params\Blueprint $blueprint, Params\Schema $schema)
    {
        $this->column = $column;
        $this->blueprintParams = $blueprint;
        $this->schemaParams = $schema;
    }

    /**
     * 与 Laravel ColumnDefinition 保持一致
     *
     * @param bool $value
     *
     * @return ColumnDefinition
     */
    public function nullable(bool $value = true): static
    {
        return $this->autoParams(__FUNCTION__, [
            '$value' => $value,
        ]);
    }

    /**
     * 与 Laravel ColumnDefinition 保持一致
     *
     * @param string $comment
     *
     * @return ColumnDefinition
     */
    public function comment(string $comment): static
    {
        $this->schemaParams->getColumn($this->column)->setComment($comment);

        return $this->autoParams(__FUNCTION__, [
            '$comment' => $comment,
        ]);
    }

    /**
     * 与 Laravel ColumnDefinition 保持一致
     *
     * @param bool $value
     *
     * @return ColumnDefinition
     */
    public function primary(bool $value = true): static
    {
        return $this->autoParams(__FUNCTION__, [
            '$value' => $value,
        ]);
    }

    /**
     * 与 Laravel ColumnDefinition 保持一致
     *
     * @param bool|string|null $indexName
     *
     * @return ColumnDefinition
     */
    public function unique(bool|string|null $indexName = null): self
    {
        return $this->autoParams(__FUNCTION__, [
            '$indexName' => $indexName,
        ]);
    }

    /**
     * 与 Laravel ColumnDefinition 保持一致
     *
     * @param bool|string|null $indexName
     *
     * @return ColumnDefinition
     */
    public function index(bool|string|null $indexName = null): self
    {
        return $this->autoParams(__FUNCTION__, [
            '$indexName' => $indexName,
        ]);
    }

    /**
     * 与 Laravel ColumnDefinition 保持一致
     *
     * @param string $column
     *
     * @return ColumnDefinition
     */
    public function after(string $column): self
    {
        return $this->autoParams(__FUNCTION__, [
            '$column' => $column,
        ]);
    }

    /**
     * 与 Laravel ColumnDefinition 保持一致
     *
     * @param string|Expression $expression
     *
     * @return ColumnDefinition
     */
    public function storedAs(string|Expression $expression): self
    {
        return $this->autoParams(__FUNCTION__, [
            '$expression' => $expression,
        ]);
    }

    /**
     * 与 Laravel ColumnDefinition 保持一致
     *
     * @param mixed $value
     *
     * @return ColumnDefinition
     */
    public function default(mixed $value): self
    {
        return $this->autoParams(__FUNCTION__, [
            '$value' => $value,
        ]);
    }

    /**
     * 与 Laravel ColumnDefinition 保持一致
     *
     * @param int $startingValue
     *
     * @return ColumnDefinition
     */
    public function from(int $startingValue): self
    {
        return $this->autoParams(__FUNCTION__, [
            '$startingValue' => $startingValue,
        ]);
    }

    /**
     * 与 Laravel ColumnDefinition 保持一致
     *
     * @param string $charset
     *
     * @return ColumnDefinition
     */
    public function charset(string $charset): self
    {
        return $this->autoParams(__FUNCTION__, [
            '$charset' => $charset,
        ]);
    }

    /**
     * 与 Laravel ColumnDefinition 保持一致
     *
     * @param string|Expression $expression
     *
     * @return ColumnDefinition
     */
    public function virtualAs(string|Expression $expression): self
    {
        return $this->autoParams(__FUNCTION__, [
            '$expression' => $expression,
        ]);
    }

    /**
     * 与 Laravel ColumnDefinition 保持一致
     *
     * @param string|Expression|null $expression
     *
     * @return ColumnDefinition
     */
    public function generatedAs(string|Expression $expression = null): self
    {
        return $this->autoParams(__FUNCTION__, [
            '$expression' => $expression,
        ]);
    }

    /**
     * 与 Laravel ColumnDefinition 保持一致
     *
     * @return ColumnDefinition
     */
    public function unsigned(): self
    {
        return $this->autoParams(__FUNCTION__, []);
    }

    /**
     * 与 Laravel ColumnDefinition 保持一致
     *
     * @return ColumnDefinition
     */
    public function useCurrent(): self
    {
        return $this->autoParams(__FUNCTION__, []);
    }

    /**
     * 与 Laravel ColumnDefinition 保持一致
     *
     * @return ColumnDefinition
     */
    public function useCurrentOnUpdate(): self
    {
        return $this->autoParams(__FUNCTION__, []);
    }

    /**
     * 与 Laravel ColumnDefinition 保持一致
     *
     * @return ColumnDefinition
     */
    public function always(): self
    {
        return $this->autoParams(__FUNCTION__, []);
    }

    /**
     * 与 Laravel ColumnDefinition 保持一致
     *
     * @return ColumnDefinition
     */
    public function first(): self
    {
        return $this->autoParams(__FUNCTION__, []);
    }

    /**
     * 与 Laravel ColumnDefinition 保持一致
     *
     * @return ColumnDefinition
     */
    public function invisible(): self
    {
        return $this->autoParams(__FUNCTION__, []);
    }

    /**
     * 与 Laravel ColumnDefinition 保持一致
     *
     * @param string $collation
     *
     * @return ColumnDefinition
     */
    public function collation(string $collation): self
    {
        return $this->autoParams(__FUNCTION__, [
            '$collation' => $collation,
        ]);
    }

    /**
     * 与 Laravel ColumnDefinition 保持一致
     *
     * @return ColumnDefinition
     */
    public function autoIncrement(): self
    {
        return $this->autoParams(__FUNCTION__, []);
    }

    /**
     * 与 Laravel ColumnDefinition 保持一致
     *
     * @return ColumnDefinition
     */
    public function change(): self
    {
        return $this->autoParams(__FUNCTION__, []);
    }

    /**
     * 标记为隐藏列
     *
     * @param bool $value
     *
     * @return ColumnDefinition
     */
    public function hidden(bool $value = true): static
    {
        $this->schemaParams->getColumn($this->column)->setHidden($value);

        return $this;
    }

    /**
     * 标记为可填充列
     *
     * @param bool $value
     *
     * @return ColumnDefinition
     */
    public function fillable(bool $value = true): static
    {
        $this->schemaParams->getColumn($this->column)->setFillable($value);

        return $this;
    }

    /**
     * 指定转换类型
     *
     * @param Closure|string $value
     *
     * @return ColumnDefinition
     */
    public function cast(Closure|string $value): static
    {
        if (!is_string($value)) {
            $value = $value();
        }

        $this->schemaParams->getColumn($this->column)->setCast($value);

        return $this;
    }

    /**
     * 自动处理参数
     *
     * @param string $fn
     * @param array  $params
     *
     * @return ColumnDefinition
     */
    protected function autoParams(string $fn, array $params): static
    {
        return $this->pushParams($fn, $this->useParams(__CLASS__, $fn, $params));
    }

    /**
     * 把参数加入到对象树中
     *
     * @param string   $fn
     * @param stdClass $params
     *
     * @return static
     */
    protected function pushParams(string $fn, stdClass $params): static
    {
        $this->blueprintParams->appendMigration($this->column, new Params\Migration($fn, $params));

        return $this;
    }

}
