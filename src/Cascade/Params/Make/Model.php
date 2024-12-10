<?php

namespace KanekiYuto\Handy\Cascade\Params\Make;

class Model
{

    private string $extends;

    private string $activity;

    private bool $incrementing;

    private bool $timestamps;

    public function __construct(string $extends, string $activity, bool $incrementing, bool $timestamps)
    {
        $this->extends = $extends;
        $this->incrementing = $incrementing;
        $this->activity = $activity;
        $this->timestamps = $timestamps;
    }

    public function getExtends(): string
    {
        return $this->extends;
    }

    public function getActivity(): string
    {
        return $this->activity;
    }

    public function getIncrementing(): bool
    {
        return $this->incrementing;
    }

    public function getTimestamps(): bool
    {
        return $this->timestamps;
    }
}