<?php

namespace KanekiYuto\Handy\Cascade\Params\Configure;

class Migration
{

    private array $support;

    public function __construct()
    {
        $this->support = [
            'string',
            'binary',
            'dateTimeTz',
            'dateTime',
            'decimal',
            'enum',
            'float',
            'foreignUlid',
            'geography',
            'geometry',
            'set',
            'ulid',
            'smallInteger',
            'mediumInteger',
            'integer',
            'bigInteger',
            'tinyInteger',
            'unsignedBigInteger',
            'unsignedInteger',
            'unsignedMediumInteger',
            'unsignedSmallInteger',
            'unsignedTinyInteger',
            'softDeletes',
            'softDeletesTz',
            'timeTz',
            'time',
            'timestampTz',
            'timestamp',
            'bigIncrements',
            'boolean',
            'date',
            'double',
            'foreignId',
            'foreignUuid',
            'id',
            'increments',
            'ipAddress',
            'json',
            'jsonb',
            'longText',
            'macAddress',
            'mediumIncrements',
            'mediumText',
            'smallIncrements',
            'text',
            'tinyIncrements',
            'tinyText',
            'uuid',
            'year',
            'morphs',
        ];
    }
    
    public function getSupport(): array
    {
        return $this->support;
    }

}