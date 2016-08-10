<?php

/**
 * Class Autoloader
 */
class Autoloader
{
	/**
	 * Register the autoloader
	 */
	public static function register()
	{
		spl_autoload_extensions(".php");
		spl_autoload_register();
	}
}

Autoloader::register();