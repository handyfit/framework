<?php

namespace KanekiYuto\Handy\Cascade;

use Closure;
use Illuminate\Contracts\Database\Query\Expression;
use KanekiYuto\Handy\Cascade\Params\Column as ColumnParams;
use KanekiYuto\Handy\Cascade\Trait\Laravel\ColumnDefinition as LaravelColumnDefinition;

class ColumnDefinition
{

    use LaravelColumnDefinition;

    protected ColumnParams $columnParams;

    public function __construct(ColumnParams $columnParams)
    {
        $this->columnParams = $columnParams;
    }

    /**
     * 与 Laravel ColumnDefinition 保持一致
     *
     * @param  bool  $value
     *
     * @return ColumnDefinition
     */
    public function nullable(bool $value = true): static
    {
        return $this->autoParams(__FUNCTION__, [
            '$value' => $value,
        ], $this);
    }

    /**
     * 与 Laravel ColumnDefinition 保持一致
     *
     * @param  string  $comment
     *
     * @return ColumnDefinition
     */
    public function comment(string $comment): static
    {
        $this->columnParams->setComment($comment);

        return $this->autoParams(__FUNCTION__, [
            '$comment' => $comment,
        ], $this);
    }

    /**
     * 与 Laravel ColumnDefinition 保持一致
     *
     * @param  bool  $value
     *
     * @return ColumnDefinition
     */
    public function primary(bool $value = true): static
    {
        return $this->autoParams(__FUNCTION__, [
            '$value' => $value,
        ], $this);
    }

    /**
     * 与 Laravel ColumnDefinition 保持一致
     *
     * @param  bool|string|null  $indexName
     *
     * @return ColumnDefinition
     */
    public function unique(bool|string|null $indexName = null): self
    {
        return $this->autoParams(__FUNCTION__, [
            '$indexName' => $indexName,
        ], $this);
    }

    /**
     * 与 Laravel ColumnDefinition 保持一致
     *
     * @param  bool|string|null  $indexName
     *
     * @return ColumnDefinition
     */
    public function index(bool|string|null $indexName = null): self
    {
        return $this->autoParams(__FUNCTION__, [
            '$indexName' => $indexName,
        ], $this);
    }

    /**
     * 与 Laravel ColumnDefinition 保持一致
     *
     * @param  string  $column
     *
     * @return ColumnDefinition
     */
    public function after(string $column): self
    {
        return $this->autoParams(__FUNCTION__, [
            '$column' => $column,
        ], $this);
    }

    /**
     * 与 Laravel ColumnDefinition 保持一致
     *
     * @param  string|Expression  $expression
     *
     * @return ColumnDefinition
     */
    public function storedAs(string|Expression $expression): self
    {
        return $this->autoParams(__FUNCTION__, [
            '$expression' => $expression,
        ], $this);
    }


    /**
     * 与 Laravel ColumnDefinition 保持一致
     *
     * @param  mixed  $value
     *
     * @return ColumnDefinition
     */
    public function default(mixed $value): self
    {
        return $this->autoParams(__FUNCTION__, [
            '$value' => $value,
        ], $this);
    }

    /**
     * 与 Laravel ColumnDefinition 保持一致
     *
     * @param  int  $startingValue
     *
     * @return ColumnDefinition
     */
    public function from(int $startingValue): self
    {
        return $this->autoParams(__FUNCTION__, [
            '$startingValue' => $startingValue,
        ], $this);
    }

    /**
     * 与 Laravel ColumnDefinition 保持一致
     *
     * @param  string  $charset
     *
     * @return ColumnDefinition
     */
    public function charset(string $charset): self
    {
        return $this->autoParams(__FUNCTION__, [
            '$charset' => $charset,
        ], $this);
    }

    /**
     * 与 Laravel ColumnDefinition 保持一致
     *
     * @param  string|Expression  $expression
     *
     * @return LaravelColumnDefinition|ColumnDefinition
     */
    public function virtualAs(string|Expression $expression): self
    {
        return $this->autoParams(__FUNCTION__, [
            '$expression' => $expression,
        ], $this);
    }

    /**
     * 与 Laravel ColumnDefinition 保持一致
     *
     * @param  string|Expression|null  $expression
     *
     * @return ColumnDefinition
     */
    public function generatedAs(string|Expression $expression = null): self
    {
        return $this->autoParams(__FUNCTION__, [
            '$expression' => $expression,
        ], $this);
    }

    /**
     * 与 Laravel ColumnDefinition 保持一致
     *
     * @return ColumnDefinition
     */
    public function unsigned(): self
    {
        return $this->autoParams(__FUNCTION__, [], $this);
    }

    /**
     * 与 Laravel ColumnDefinition 保持一致
     *
     * @return ColumnDefinition
     */
    public function useCurrent(): self
    {
        return $this->autoParams(__FUNCTION__, [], $this);
    }

    /**
     * 与 Laravel ColumnDefinition 保持一致
     *
     * @return ColumnDefinition
     */
    public function useCurrentOnUpdate(): self
    {
        return $this->autoParams(__FUNCTION__, [], $this);
    }

    /**
     * 与 Laravel ColumnDefinition 保持一致
     *
     * @return ColumnDefinition
     */
    public function always(): self
    {
        return $this->autoParams(__FUNCTION__, [], $this);
    }

    /**
     * 与 Laravel ColumnDefinition 保持一致
     *
     * @return ColumnDefinition
     */
    public function first(): self
    {
        return $this->autoParams(__FUNCTION__, [], $this);
    }

    /**
     * 与 Laravel ColumnDefinition 保持一致
     *
     * @return ColumnDefinition
     */
    public function invisible(): self
    {
        return $this->autoParams(__FUNCTION__, [], $this);
    }

    /**
     * 与 Laravel ColumnDefinition 保持一致
     *
     * @param  string  $collation
     *
     * @return ColumnDefinition
     */
    public function collation(string $collation): self
    {
        return $this->autoParams(__FUNCTION__, [
            '$collation' => $collation,
        ], $this);
    }

    /**
     * 与 Laravel ColumnDefinition 保持一致
     *
     * @return ColumnDefinition
     */
    public function autoIncrement(): self
    {
        return $this->autoParams(__FUNCTION__, [], $this);
    }

    /**
     * 与 Laravel ColumnDefinition 保持一致
     *
     * @return ColumnDefinition
     */
    public function change(): self
    {
        return $this->autoParams(__FUNCTION__, [], $this);
    }

    /**
     * 标记为隐藏列
     *
     * @param  bool  $value
     *
     * @return ColumnDefinition
     */
    public function hidden(bool $value = true): static
    {
        $this->columnParams->setHidden($value);

        return $this;
    }

    /**
     * 标记为可填充列
     *
     * @param  bool  $value
     *
     * @return ColumnDefinition
     */
    public function fillable(bool $value = true): static
    {
        $this->columnParams->setFillable($value);

        return $this;
    }

    /**
     * 指定转换类型
     *
     * @param  Closure|string  $value
     *
     * @return ColumnDefinition
     */
    public function cast(Closure|string $value): static
    {
        if (!is_string($value)) {
            $value = $value();
        }

        $this->columnParams->setCast($value);

        return $this;
    }

}