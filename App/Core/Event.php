<?php

namespace App\Core;


/**
 * Class Event
 * @package App\Core
 */
class Event extends Core
{

	/**
	 * Name of the event
	 *
	 * @var string
	 */
	private $_name = "";

	/**
	 * All hooks stored
	 *
	 * @var array
	 */
	private $_tasks = array();

	/**
	 * Constructor
	 *
	 * @param string $name
	 */
	public function __construct($name)
	{
		$this->_name = $name;
	}


	/**
	 * Adds a task
	 *
	 * @param $name
	 * @param $function
	 * @param array $args
	 * @return bool
	 */
	public function addTask($name, $function, $args = array())
	{
		if($this->_existsTask($name))
		{
			\Juniper::throwException('EventException', "Task {$name} already exists in event {$this->getName()}");
			return false;
		}
		$this->_tasks[$name] = array(
			'function'  =>  $function,
			'args'      =>  $args
		);

		return true;
	}

	/**
	 * Dispatches all tasks
	 */
	public function dispatch()
	{
		foreach($this->_getTasks() as $name => $task){
			// Debugging
			if(\Juniper::registry('dev')){
				$timer = \Juniper::singleton('core/timer');
				$timer->start("dispatch");
			}

			call_user_func_array($this->_getFunction($task), $this->_getArgs($task));

			// Debugging
			if(\Juniper::registry('dev')) {
				$timing = $timer->stop("dispatch");
				\Juniper::log("Event {$this->getName()} dispatched {$name} in {$timing}", Log::LOG_LEVEL_ALL);
			}
		}
	}

	/**
	 * Checks if a task exists
	 *
	 * @param $name
	 * @return bool
	 */
	private function _existsTask($name)
	{
		if(isset($this->_tasks[$name]))
		{
			return true;
		}
		return false;
	}
	/**
	 * Returns the function of a task
	 *
	 * @param $task
	 * @return mixed
	 */
	private function _getFunction($task)
	{
		return $task['function'];
	}

	/**
	 * Returns the arguments of a task
	 *
	 * @param $task
	 * @return mixed
	 */
	private function _getArgs($task)
	{
		return $task['args'];
	}

	/**
	 * Get all tasks
	 *
	 * @return array
	 */
	private function _getTasks()
	{
		return $this->_tasks;
	}

	/**
	 * Get the name of the event
	 *
	 * @return string
	 */
	public function getName()
	{
		return $this->_name;
	}
}