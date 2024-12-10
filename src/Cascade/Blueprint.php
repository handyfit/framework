<?php

namespace KanekiYuto\Handy\Cascade;

use KanekiYuto\Handy\Cascade\Params\Blueprint as BlueprintParams;
use KanekiYuto\Handy\Cascade\Trait\Laravel\Blueprint as LaravelBlueprint;

class Blueprint
{

    use LaravelBlueprint;

    private BlueprintParams $blueprintParams;

    public function __construct(BlueprintParams $blueprintParams)
    {
        $this->blueprintParams = $blueprintParams;
    }

    /**
     * 与 Laravel Blueprint 保持一致
     *
     * @param  string    $column
     * @param  int|null  $length
     *
     * @return ColumnDefinition
     */
    public function string(string $column, int $length = null): ColumnDefinition
    {
        return $this->autoParams(__FUNCTION__, $column, [
            '@quote$column' => $column,
            '$length' => $length,
        ], $this);
    }

    /**
     * 与 Laravel Blueprint 保持一致
     *
     * @param  string    $column
     * @param  int|null  $length
     * @param  bool      $fixed
     *
     * @return ColumnDefinition
     */
    public function binary(string $column, int $length = null, bool $fixed = false): ColumnDefinition
    {
        return $this->autoParams(__FUNCTION__, $column, [
            '@quote$column' => $column,
            '$length' => $length,
            '$fixed' => $fixed,
        ], $this);
    }

    /**
     * 与 Laravel Blueprint 保持一致
     *
     * @param  string  $column
     * @param  int     $precision
     *
     * @return ColumnDefinition
     */
    public function dateTimeTz(string $column, int $precision = 0): ColumnDefinition
    {
        return $this->autoParams(__FUNCTION__, $column, [
            '@quote$column' => $column,
            '$precision' => $precision,
        ], $this);
    }

    /**
     * 与 Laravel Blueprint 保持一致
     *
     * @param  string  $column
     * @param  int     $precision
     *
     * @return ColumnDefinition
     */
    public function dateTime(string $column, int $precision = 0): ColumnDefinition
    {
        return $this->autoParams(__FUNCTION__, $column, [
            '@quote$column' => $column,
            '$precision' => $precision,
        ], $this);
    }

    /**
     * 与 Laravel Blueprint 保持一致
     *
     * @param  string  $column
     * @param  int     $total
     * @param  int     $places
     *
     * @return ColumnDefinition
     */
    public function decimal(string $column, int $total = 8, int $places = 2): ColumnDefinition
    {
        return $this->autoParams(__FUNCTION__, $column, [
            '@quote$column' => $column,
            '$total' => $total,
            '$places' => $places,
        ], $this);
    }

    /**
     * 与 Laravel Blueprint 保持一致
     *
     * @param  string  $column
     * @param  array   $allowed
     *
     * @return ColumnDefinition
     */
    public function enum(string $column, array $allowed): ColumnDefinition
    {
        return $this->autoParams(__FUNCTION__, $column, [
            '@quote$column' => $column,
            '$allowed' => $allowed,
        ], $this);
    }

    /**
     * 与 Laravel Blueprint 保持一致
     *
     * @param  string  $column
     * @param  int     $precision
     *
     * @return ColumnDefinition
     */
    public function float(string $column, int $precision = 53): ColumnDefinition
    {
        return $this->autoParams(__FUNCTION__, $column, [
            '@quote$column' => $column,
            '$precision' => $precision,
        ], $this);
    }

    /**
     * 与 Laravel Blueprint 保持一致
     *
     * @param  string  $column
     * @param  int     $length
     *
     * @return ColumnDefinition
     */
    public function foreignUlid(string $column, int $length = 26): ColumnDefinition
    {
        return $this->autoParams(__FUNCTION__, $column, [
            '@quote$column' => $column,
            '$length' => $length,
        ], $this);
    }

    /**
     * 与 Laravel Blueprint 保持一致
     *
     * @param  string       $column
     * @param  string|null  $subtype
     * @param  int          $srid
     *
     * @return ColumnDefinition
     */
    public function geography(string $column, string $subtype = null, int $srid = 4326): ColumnDefinition
    {
        return $this->autoParams(__FUNCTION__, $column, [
            '@quote$column' => $column,
            '$subtype' => $subtype,
            '$srid' => $srid,
        ], $this);
    }

    /**
     * 与 Laravel Blueprint 保持一致
     *
     * @param  string       $column
     * @param  string|null  $subtype
     * @param  int          $srid
     *
     * @return ColumnDefinition
     */
    public function geometry(string $column, string $subtype = null, int $srid = 0): ColumnDefinition
    {
        return $this->autoParams(__FUNCTION__, $column, [
            '@quote$column' => $column,
            '$subtype' => $subtype,
            '$srid' => $srid,
        ], $this);
    }

    /**
     * 与 Laravel Blueprint 保持一致
     *
     * @param  string  $column
     * @param  array   $allowed
     *
     * @return ColumnDefinition
     */
    public function set(string $column, array $allowed): ColumnDefinition
    {
        return $this->autoParams(__FUNCTION__, $column, [
            '@quote$column' => $column,
            '$allowed' => $allowed,
        ], $this);
    }

    /**
     * 与 Laravel Blueprint 保持一致
     *
     * @param  string  $column
     * @param  int     $length
     *
     * @return ColumnDefinition
     */
    public function ulid(string $column = 'ulid', int $length = 26): ColumnDefinition
    {
        return $this->autoParams(__FUNCTION__, $column, [
            '@quote$column' => $column,
            '$length' => $length,
        ], $this);
    }

    /**
     * 与 Laravel Blueprint 保持一致
     *
     * @param  string  $column
     * @param  bool    $autoIncrement
     * @param  bool    $unsigned
     *
     * @return ColumnDefinition
     */
    public function smallInteger(string $column, bool $autoIncrement = false, bool $unsigned = false): ColumnDefinition
    {
        return $this->autoParams(__FUNCTION__, $column, [
            '@quote$column' => $column,
            '$autoIncrement' => $autoIncrement,
            '$unsigned' => $unsigned,
        ], $this);
    }

    /**
     * 与 Laravel Blueprint 保持一致
     *
     * @param  string  $column
     * @param  bool    $autoIncrement
     * @param  bool    $unsigned
     *
     * @return ColumnDefinition
     */
    public function mediumInteger(string $column, bool $autoIncrement = false, bool $unsigned = false): ColumnDefinition
    {
        return $this->autoParams(__FUNCTION__, $column, [
            '@quote$column' => $column,
            '$autoIncrement' => $autoIncrement,
            '$unsigned' => $unsigned,
        ], $this);
    }

    /**
     * 与 Laravel Blueprint 保持一致
     *
     * @param  string  $column
     * @param  bool    $autoIncrement
     * @param  bool    $unsigned
     *
     * @return ColumnDefinition
     */
    public function integer(string $column, bool $autoIncrement = false, bool $unsigned = false): ColumnDefinition
    {
        return $this->autoParams(__FUNCTION__, $column, [
            '@quote$column' => $column,
            '$autoIncrement' => $autoIncrement,
            '$unsigned' => $unsigned,
        ], $this);
    }

    /**
     * 与 Laravel Blueprint 保持一致
     *
     * @param  string  $column
     * @param  bool    $autoIncrement
     * @param  bool    $unsigned
     *
     * @return ColumnDefinition
     */
    public function bigInteger(string $column, bool $autoIncrement = false, bool $unsigned = false): ColumnDefinition
    {
        return $this->autoParams(__FUNCTION__, $column, [
            '@quote$column' => $column,
            '$autoIncrement' => $autoIncrement,
            '$unsigned' => $unsigned,
        ], $this);
    }

    /**
     * 与 Laravel Blueprint 保持一致
     *
     * @param  string  $column
     * @param  bool    $autoIncrement
     * @param  bool    $unsigned
     *
     * @return ColumnDefinition
     */
    public function tinyInteger(string $column, bool $autoIncrement = false, bool $unsigned = false): ColumnDefinition
    {
        return $this->autoParams(__FUNCTION__, $column, [
            '@quote$column' => $column,
            '$autoIncrement' => $autoIncrement,
            '$unsigned' => $unsigned,
        ], $this);
    }

    /**
     * 与 Laravel Blueprint 保持一致
     *
     * @param  string  $column
     * @param  bool    $autoIncrement
     *
     * @return ColumnDefinition
     */
    public function unsignedBigInteger(string $column, bool $autoIncrement = false): ColumnDefinition
    {
        return $this->autoParams(__FUNCTION__, $column, [
            '@quote$column' => $column,
            '$autoIncrement' => $autoIncrement,
        ], $this);
    }

    /**
     * 与 Laravel Blueprint 保持一致
     *
     * @param  string  $column
     * @param  bool    $autoIncrement
     *
     * @return ColumnDefinition
     */
    public function unsignedInteger(string $column, bool $autoIncrement = false): ColumnDefinition
    {
        return $this->autoParams(__FUNCTION__, $column, [
            '@quote$column' => $column,
            '$autoIncrement' => $autoIncrement,
        ], $this);
    }

    /**
     * 与 Laravel Blueprint 保持一致
     *
     * @param  string  $column
     * @param  bool    $autoIncrement
     *
     * @return ColumnDefinition
     */
    public function unsignedMediumInteger(string $column, bool $autoIncrement = false): ColumnDefinition
    {
        return $this->autoParams(__FUNCTION__, $column, [
            '@quote$column' => $column,
            '$autoIncrement' => $autoIncrement,
        ], $this);
    }

    /**
     * 与 Laravel Blueprint 保持一致
     *
     * @param  string  $column
     * @param  bool    $autoIncrement
     *
     * @return ColumnDefinition
     */
    public function unsignedSmallInteger(string $column, bool $autoIncrement = false): ColumnDefinition
    {
        return $this->autoParams(__FUNCTION__, $column, [
            '@quote$column' => $column,
            '$autoIncrement' => $autoIncrement,
        ], $this);
    }

    /**
     * 与 Laravel Blueprint 保持一致
     *
     * @param  string  $column
     * @param  bool    $autoIncrement
     *
     * @return ColumnDefinition
     */
    public function unsignedTinyInteger(string $column, bool $autoIncrement = false): ColumnDefinition
    {
        return $this->autoParams(__FUNCTION__, $column, [
            '@quote$column' => $column,
            '$autoIncrement' => $autoIncrement,
        ], $this);
    }

    /**
     * 与 Laravel Blueprint 保持一致
     *
     * @param  string  $column
     * @param  int     $precision
     *
     * @return ColumnDefinition
     */
    public function softDeletes(string $column = 'deleted_at', int $precision = 0): ColumnDefinition
    {
        return $this->autoParams(__FUNCTION__, $column, [
            '@quote$column' => $column,
            '$precision' => $precision,
        ], $this);
    }

    /**
     * 与 Laravel Blueprint 保持一致
     *
     * @param  string  $column
     * @param  int     $precision
     *
     * @return ColumnDefinition
     */
    public function softDeletesTz(string $column = 'deleted_at', int $precision = 0): ColumnDefinition
    {
        return $this->autoParams(__FUNCTION__, $column, [
            '@quote$column' => $column,
            '$precision' => $precision,
        ], $this);
    }

    /**
     * 与 Laravel Blueprint 保持一致
     *
     * @param  string  $column
     * @param  int     $precision
     *
     * @return ColumnDefinition
     */
    public function timeTz(string $column, int $precision = 0): ColumnDefinition
    {
        return $this->autoParams(__FUNCTION__, $column, [
            '@quote$column' => $column,
            '$precision' => $precision,
        ], $this);
    }

    /**
     * 与 Laravel Blueprint 保持一致
     *
     * @param  string  $column
     * @param  int     $precision
     *
     * @return ColumnDefinition
     */
    public function time(string $column, int $precision = 0): ColumnDefinition
    {
        return $this->autoParams(__FUNCTION__, $column, [
            '@quote$column' => $column,
            '$precision' => $precision,
        ], $this);
    }

    /**
     * 与 Laravel Blueprint 保持一致
     *
     * @param  string  $column
     * @param  int     $precision
     *
     * @return ColumnDefinition
     */
    public function timestampTz(string $column, int $precision = 0): ColumnDefinition
    {
        return $this->autoParams(__FUNCTION__, $column, [
            '@quote$column' => $column,
            '$precision' => $precision,
        ], $this);
    }

    /**
     * 与 Laravel Blueprint 保持一致
     *
     * @param  string  $column
     * @param  int     $precision
     *
     * @return ColumnDefinition
     */
    public function timestamp(string $column, int $precision = 0): ColumnDefinition
    {
        return $this->autoParams(__FUNCTION__, $column, [
            '@quote$column' => $column,
            '$precision' => $precision,
        ], $this);
    }

    /**
     * 与 Laravel Blueprint 保持一致
     *
     * @param  string  $column
     *
     * @return ColumnDefinition
     */
    public function bigIncrements(string $column): ColumnDefinition
    {
        return $this->autoParams(__FUNCTION__, $column, [
            '@quote$column' => $column,
        ], $this);
    }

    /**
     * 与 Laravel Blueprint 保持一致
     *
     * @param  string  $column
     *
     * @return ColumnDefinition
     */
    public function boolean(string $column): ColumnDefinition
    {
        return $this->autoParams(__FUNCTION__, $column, [
            '@quote$column' => $column,
        ], $this);
    }

    /**
     * 与 Laravel Blueprint 保持一致
     *
     * @param  string  $column
     *
     * @return ColumnDefinition
     */
    public function date(string $column): ColumnDefinition
    {
        return $this->autoParams(__FUNCTION__, $column, [
            '@quote$column' => $column,
        ], $this);
    }

    /**
     * 与 Laravel Blueprint 保持一致
     *
     * @param  string  $column
     *
     * @return ColumnDefinition
     */
    public function double(string $column): ColumnDefinition
    {
        return $this->autoParams(__FUNCTION__, $column, [
            '@quote$column' => $column,
        ], $this);
    }

    /**
     * 与 Laravel Blueprint 保持一致
     *
     * @param  string  $column
     *
     * @return ColumnDefinition
     */
    public function foreignId(string $column): ColumnDefinition
    {
        return $this->autoParams(__FUNCTION__, $column, [
            '@quote$column' => $column,
        ], $this);
    }

    /**
     * 与 Laravel Blueprint 保持一致
     *
     * @param  string  $column
     *
     * @return ColumnDefinition
     */
    public function foreignUuid(string $column): ColumnDefinition
    {
        return $this->autoParams(__FUNCTION__, $column, [
            '@quote$column' => $column,
        ], $this);
    }

    /**
     * 与 Laravel Blueprint 保持一致
     *
     * @param  string  $column
     *
     * @return ColumnDefinition
     */
    public function id(string $column = 'id'): ColumnDefinition
    {
        return $this->autoParams(__FUNCTION__, $column, [
            '@quote$column' => $column,
        ], $this);
    }

    /**
     * 与 Laravel Blueprint 保持一致
     *
     * @param  string  $column
     *
     * @return ColumnDefinition
     */
    public function increments(string $column): ColumnDefinition
    {
        return $this->autoParams(__FUNCTION__, $column, [
            '@quote$column' => $column,
        ], $this);
    }

    /**
     * 与 Laravel Blueprint 保持一致
     *
     * @param  string  $column
     *
     * @return ColumnDefinition
     */
    public function ipAddress(string $column = 'ip_address'): ColumnDefinition
    {
        return $this->autoParams(__FUNCTION__, $column, [
            '@quote$column' => $column,
        ], $this);
    }

    /**
     * 与 Laravel Blueprint 保持一致
     *
     * @param  string  $column
     *
     * @return ColumnDefinition
     */
    public function json(string $column): ColumnDefinition
    {
        return $this->autoParams(__FUNCTION__, $column, [
            '@quote$column' => $column,
        ], $this);
    }

    /**
     * 与 Laravel Blueprint 保持一致
     *
     * @param  string  $column
     *
     * @return ColumnDefinition
     */
    public function jsonb(string $column): ColumnDefinition
    {
        return $this->autoParams(__FUNCTION__, $column, [
            '@quote$column' => $column,
        ], $this);
    }

    /**
     * 与 Laravel Blueprint 保持一致
     *
     * @param  string  $column
     *
     * @return ColumnDefinition
     */
    public function longText(string $column): ColumnDefinition
    {
        return $this->autoParams(__FUNCTION__, $column, [
            '@quote$column' => $column,
        ], $this);
    }

    /**
     * 与 Laravel Blueprint 保持一致
     *
     * @param  string  $column
     *
     * @return ColumnDefinition
     */
    public function macAddress(string $column = 'mac_address'): ColumnDefinition
    {
        return $this->autoParams(__FUNCTION__, $column, [
            '@quote$column' => $column,
        ], $this);
    }

    /**
     * 与 Laravel Blueprint 保持一致
     *
     * @param  string  $column
     *
     * @return ColumnDefinition
     */
    public function mediumIncrements(string $column): ColumnDefinition
    {
        return $this->autoParams(__FUNCTION__, $column, [
            '@quote$column' => $column,
        ], $this);
    }

    /**
     * 与 Laravel Blueprint 保持一致
     *
     * @param  string  $column
     *
     * @return ColumnDefinition
     */
    public function mediumText(string $column): ColumnDefinition
    {
        return $this->autoParams(__FUNCTION__, $column, [
            '@quote$column' => $column,
        ], $this);
    }

    /**
     * 与 Laravel Blueprint 保持一致
     *
     * @param  string  $column
     *
     * @return ColumnDefinition
     */
    public function smallIncrements(string $column): ColumnDefinition
    {
        return $this->autoParams(__FUNCTION__, $column, [
            '@quote$column' => $column,
        ], $this);
    }

    /**
     * 与 Laravel Blueprint 保持一致
     *
     * @param  string  $column
     *
     * @return ColumnDefinition
     */
    public function text(string $column): ColumnDefinition
    {
        return $this->autoParams(__FUNCTION__, $column, [
            '@quote$column' => $column,
        ], $this);
    }

    /**
     * 与 Laravel Blueprint 保持一致
     *
     * @param  string  $column
     *
     * @return ColumnDefinition
     */
    public function tinyIncrements(string $column): ColumnDefinition
    {
        return $this->autoParams(__FUNCTION__, $column, [
            '@quote$column' => $column,
        ], $this);
    }

    /**
     * 与 Laravel Blueprint 保持一致
     *
     * @param  string  $column
     *
     * @return ColumnDefinition
     */
    public function tinyText(string $column): ColumnDefinition
    {
        return $this->autoParams(__FUNCTION__, $column, [
            '@quote$column' => $column,
        ], $this);
    }

    /**
     * 与 Laravel Blueprint 保持一致
     *
     * @param  string  $column
     *
     * @return ColumnDefinition
     */
    public function uuid(string $column = 'uuid'): ColumnDefinition
    {
        return $this->autoParams(__FUNCTION__, $column, [
            '@quote$column' => $column,
        ], $this);
    }

    /**
     * 与 Laravel Blueprint 保持一致
     *
     * @param  string  $column
     *
     * @return ColumnDefinition
     */
    public function year(string $column): ColumnDefinition
    {
        return $this->autoParams(__FUNCTION__, $column, [
            '@quote$column' => $column,
        ], $this);
    }

    /**
     * 与 Laravel Blueprint 保持一致
     *
     * @param  string  $name
     * @param  null    $indexName
     *
     * @return ColumnDefinition
     */
    public function morphs(string $name, $indexName = null): ColumnDefinition
    {
        return $this->autoParams(__FUNCTION__, $name, [
            '@quote$name' => $name,
            '$indexName' => $indexName,
        ], $this);
    }

}