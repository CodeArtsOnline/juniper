<?php

namespace App\Core\Traits;


/**
 * Class Singleton
 * @package App\Core
 */
trait Singleton
{
	/**
	 * Stores the instance
	 *
	 * @var mixed|null
	 */
	private static $_instance = null;

	/**
	 * Returns and if necessary creates the instance
	 *
	 * @return mixed|null
	 */
	public static function getInstance()
	{
		if(is_null(static::$_instance)) {
			static::$_instance = new static();
		}
		static::$_instance->init();

		return static::$_instance;
	}

	/**
	 * Turning construct private
	 */
	private function __construct(){}

	/**
	 * Initialises the class (replaces __construct)
	 */
	public function init(){}
}