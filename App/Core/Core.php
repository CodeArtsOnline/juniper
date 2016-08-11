<?php

namespace App\Core;

/**
 * Class Core
 * @package App\Core
 *
 * Base class for the core
 */
class Core
{
	public function __($text, $lang = null)
	{
		$this->singleton('core/translate')->__($text, $lang);
	}

	public function core($name, $args = array())
	{
		return \Juniper::core($name, $args);
	}

	public function singleton($name, $args = array())
	{
		return \Juniper::singleton($name, $args);
	}
}