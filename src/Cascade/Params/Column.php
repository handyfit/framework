<?php

namespace KanekiYuto\Handy\Cascade\Params;

use KanekiYuto\Handy\Cascade\Params\Migration as MigrationParams;

class Column
{

    private string $field;

    private string $comment;

    private array $migrationParams;

    private bool $hidden;

    private bool $fillable;

    private string $cast;

    public function __construct(string $field)
    {
        $this->field = $field;
        $this->comment = '';
        $this->cast = '';
        $this->hidden = false;
        $this->fillable = false;
        $this->migrationParams = [];
    }

    public function isFillable(): bool
    {
        return $this->fillable;
    }

    public function setFillable(bool $value): static
    {
        $this->fillable = $value;

        return $this;
    }

    public function setHidden(bool $value): static
    {
        $this->hidden = $value;

        return $this;
    }

    public function isHidden(): bool
    {
        return $this->hidden;
    }

    public function getField(): string
    {
        return $this->field;
    }

    public function getComment(): string
    {
        return $this->comment;
    }

    public function setComment(string $comment): static
    {
        $this->comment = $comment;

        return $this;
    }

    public function getCast(): string
    {
        return $this->cast;
    }

    public function setCast(string $cast): static
    {
        $this->cast = $cast;

        return $this;
    }

    public function getMigrationParams(): array
    {
        return $this->migrationParams;
    }

    public function addMigrationParams(MigrationParams $migrationParams): static
    {
        $this->migrationParams[] = $migrationParams;

        return $this;
    }

}