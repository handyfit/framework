<?php

namespace Handyfit\Framework\Cascade\Params;

class Stub
{

    private string $name;

    private string $folderPath;

    private string $filename;

    private string $stub;

    public function __construct(string $name, string $folderPath, string $filename, string $stub)
    {
        $this->name = $name;
        $this->folderPath = $folderPath;
        $this->filename = $filename;
        $this->stub = $stub;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getFilename(): string
    {
        return $this->filename;
    }

    /**
     * @return string
     */
    public function getFolderPath(): string
    {
        return $this->folderPath;
    }

    /**
     * @return string
     */
    public function getStub(): string
    {
        return $this->stub;
    }

}
