<?php

namespace Handyfit\Framework\Cascade\Params\Manger;

class Summary
{

    private string $table;

    private string $classname;

    public function __construct(string $table, string $classname)
    {
        $this->table = $table;
        $this->classname = $classname;
    }

    /**
     * @return string
     */
    public function getTable(): string
    {
        return $this->table;
    }

    /**
     * @return string
     */
    public function getClassname(): string
    {
        return $this->classname;
    }

}
