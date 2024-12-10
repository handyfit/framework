<?php

namespace KanekiYuto\Handy\Support;

use DateTimeImmutable;

/**
 * Timestamp Builder
 *
 * @author KanekiYuto
 */
class Timestamp
{

	/**
	 * Second time stamp
	 *
	 * @return int
	 */
	public static function second(): int
	{
		return time();
	}

	/**
	 * Millisecond timestamp
	 *
	 * @return int
	 */
	public static function millisecond(): int
	{
		return (int) (microtime(true) * 1000);
	}

	/**
	 * Generate a valid timestamp
	 *
	 * @param  int  $timestamp
	 * @param  int  $second
	 *
	 * @return DateTimeImmutable
	 */
	public static function validity(int $timestamp, int $second): DateTimeImmutable
	{
		return (new DateTimeImmutable())
			->setTimestamp($timestamp + $second);
	}

}