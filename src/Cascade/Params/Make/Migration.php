<?php

namespace KanekiYuto\Handy\Cascade\Params\Make;

class Migration
{

    private string|null $filename;

    private string $comment;

    public function __construct(string|null $filename, string $comment)
    {
        $this->filename = $filename;
        $this->comment = $comment;
    }

    public function getFilename(): string|null
    {
        return $this->filename;
    }

    public function getComment(): string
    {
        return $this->comment;
    }

}