<?php

/**
 * Class Juniper
 */
class Juniper
{
	use App\Core\Traits\Singleton;

	/**
	 * Contains the registry
	 *
	 * @var array
	 */
	private static $_registry = array();

	/**
	 * Contains all events that can be dispatched
	 *
	 * @var array
	 */
	private $_events = array();

	/**
	 * Triggers the _run function
	 *
	 * @param $options
	 */
	public static function run($options)
	{
		self::register('dev', $options['developer_mode']);
		self::getInstance()->_run($options);
	}

	/**
	 * Execute the script
	 *
	 * @param $options
	 */
	private function _run($options)
	{
		self::getEvent('A')->addTask("test", array(__CLASS__, "test"));
		self::dispatchEvent('A');
		self::singleton("core/log")->printLog();
	}

	/**
	 * Test function
	 */
	public static function test()
	{
		for($i = 0; $i < 1000000; $i++){
			$test = rand(1, 4000);
		}
	}

	/**
	 * Registers a new registry entry
	 *
	 * @param string $name
	 * @param mixed $value
	 */
	public static function register($name, $value)
	{
		if(is_null(self::registry($name))){
			self::$_registry[$name] = $value;
		}
	}

	/**
	 * Unregisters a registry entry
	 *
	 * @param $name
	 */
	public static function unregister($name)
	{
		if(!is_null(self::registry($name))){
			unset(self::$_registry[$name]);
		}
	}

	/**
	 * Returns a registry entry
	 *
	 * @param $name
	 * @return mixed|null
	 */
	public static function registry($name)
	{
		return (isset(self::$_registry[$name])) ? self::$_registry[$name] : null;
	}

	/**
	 * Throws an exception
	 *
	 * @param $exception
	 * @param $msg
	 */
	public static function throwException($exception, $msg)
	{
		$exception_handler = 'App\\Core\\Exception\\'.$exception;
		throw new $exception_handler($msg);
	}

	/**
	 * Adds a new event
	 *
	 * @param $name
	 */
	public static function addEvent($name)
	{
		if(self::getInstance()->_existsEvent($name)){
			self::throwException('CoreException', "Event already exists");
		}
		self::getInstance()->_events[$name] = new App\Core\Event($name);
	}

	/**
	 * Returns an event
	 *
	 * @param $name
	 * @return mixed
	 */
	public static function getEvent($name)
	{
		if(!self::getInstance()->_existsEvent($name)){
			self::getInstance()->addEvent($name);
		}
		return self::getInstance()->_events[$name];
	}

	/**
	 * Dispatches an event
	 *
	 * @param $name
	 */
	public static function dispatchEvent($name)
	{
		if(!self::getInstance()->_existsEvent($name)){
			self::throwException('CoreException', "Event does not exists");
		}
		self::getInstance()->getEvent($name)->dispatch();
	}

	/**
	 * Checks if an event exists
	 *
	 * @param $name
	 * @return bool
	 */
	private function _existsEvent($name)
	{
		if(!isset($this->_events[$name])){
			return false;
		}
		return true;
	}

	/**
	 * Logs a message
	 *
	 * @param $message
	 * @param int $level
	 */
	public static function log($message, $level = App\Core\Log::LOG_LEVEL_NORMAL)
	{
		$log = self::singleton('core/log');
		$log->log($message, $level);
	}

	/**
	 * Get the singleton of a class
	 *
	 * @param $name
	 * @param array $args
	 * @return mixed
	 */
	public static function singleton($name, $args = array())
	{
		$name_split = explode("/", $name);
		$name_split = array_map('ucfirst', $name_split);
		$name_glued = implode("\\", $name_split);

		$class = 'App\\'.$name_glued;
		return call_user_func_array(array($class, 'getInstance'), $args);
	}

	/**
	 * Gets a core class
	 *
	 * @param $name
	 * @return mixed
	 */
	public static function core($name)
	{
		$name_split = explode("/", $name);
		$name_split = array_map('ucfirst', $name_split);
		$name_glued = implode("\\", $name_split);

		$class = 'App\\Core\\'.$name_glued;

		return new $class();
	}
}