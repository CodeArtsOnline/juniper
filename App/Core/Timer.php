<?php

namespace App\Core;

/**
 * Class Timer
 * @package App\Core
 */
class Timer extends Core
{
	use Traits\Singleton;

	/**
	 * Stores all starting times
	 *
	 * @var array
	 */
	private $_times = array();

	/**
	 * Stores a starting time
	 *
	 * @param $name
	 */
	public function start($name)
	{
		$this->_times[$name] = microtime(true);
	}

	/**
	 * Returns time till start
	 *
	 * @param $name
	 */
	public function stop($name)
	{
		if($starttime = $this->_getTime($name)){
			$stoptime = microtime(true);
			$time = $stoptime - $starttime;
			return sprintf("%.3f", $time);
		}

		\Juniper::throwException('TimerException', "No timer with name {$name}");
	}

	/**
	 * Returns a starting time
	 *
	 * @param $name
	 * @return bool
	 */
	private function _getTime($name)
	{
		if(isset($this->_times[$name])){
			return $this->_times[$name];
		}
		return false;
	}

}