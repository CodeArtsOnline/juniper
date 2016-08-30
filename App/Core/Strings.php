<?php

namespace App\Core;

/**
 * Class Strings
 * @package App\Core
 *
 * Strings class
 */
class Strings extends Core
{
	/**
	 * Converts camelCase to under_score
	 *
	 * @param $camel
	 * @return mixed
	 */
	public function camelToUnderscore($camel)
	{
		$camel[0] = strtolower($camel[0]);
		$func = create_function('$c', 'return "_" . strtolower($c[1]);');
		return preg_replace_callback('/([A-Z])/', $func, $camel);
	}

	/**
	 * Converts camelCase to path/
	 *
	 * @param $camel
	 * @return mixed
	 */
	public function camelToPath($camel)
	{
		$camel[0] = strtolower($camel[0]);
		$func = create_function('$c', 'return "/" . strtolower($c[1]);');
		return preg_replace_callback('/([A-Z])/', $func, $camel);
	}
}