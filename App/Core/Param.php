<?php

namespace App\Core;

/**
 * Class Param
 * @package App\Core
 *
 * Param class
 */
class Param extends Core
{
	/**
	 * Returns a get parameter
	 *
	 * @param $name
	 * @return null
	 */
	public function get($name)
	{
		if(isset($_GET[$name]))
		{
			return $_GET[$name];
		}

		return null;
	}

	/**
	 * Returns a post parameter
	 *
	 * @param $name
	 * @return null
	 */
	public function post($name)
	{
		if(isset($_POST[$name]))
		{
			return $_POST[$name];
		}

		return null;
	}

	/**
	 * Returns a cookie
	 *
	 * @param $name
	 * @return null
	 */
	public function cookie($name)
	{
		if(isset($_COOKIE[$name]))
		{
			return $_COOKIE[$name];
		}

		return null;
	}

	/**
	 * Returns a session
	 *
	 * @param $name
	 * @return null
	 */
	public function session($name)
	{
		//TODO: Session class
		if(isset($_SESSION[$name]))
		{
			return $_SESSION[$name];
		}

		return null;
	}

	/**
	 * Returns post or get
	 *
	 * @param $name
	 * @return null
	 */
	public function param($name)
	{
		if(isset($_POST[$name]))
		{
			return $_POST[$name];
		}
		if(isset($_GET[$name]))
		{
			return $_GET[$name];
		}

		return null;
	}
}