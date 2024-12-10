<?php

namespace KanekiYuto\Handy\Support;

/**
 * Ignore unnecessary warnings from the IDE
 *
 * @author KanekiYuto
 */
class IdeIgnore
{

	/**
	 * Ignore unused parameters
	 *
	 * @param  mixed  $field
	 */
	public static function noUseParam(mixed ...$field): void
	{
		// ...
	}

}