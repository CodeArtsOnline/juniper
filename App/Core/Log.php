<?php

namespace App\Core;

/**
 * Class Log
 * @package App\Core
 */
class Log extends Core
{
	use Traits\Singleton;

	/**
	 * No logging
	 */
	const LOG_LEVEL_NONE = 0;
	/**
	 * Normal logging
	 */
	const LOG_LEVEL_NORMAL = 1;
	/**
	 * Logging while in dev mode
	 */
	const LOG_LEVEL_ALL = 2;

	/**
	 * Stores all logs
	 *
	 * @var array
	 */
	private $_log = array();

	/**
	 * Adds a new log
	 *
	 * @param $msg
	 * @param $level
	 */
	public function log($msg, $level)
	{
		$this->_log[] = array(
			'level'     =>  $level,
			'message'   =>  $msg
		);
	}

	/**
	 * Prints the whole log
	 */
	public function printLog()
	{
		echo '<pre>';
		$counter = 0;
		foreach($this->_getLogs() as $log){
			if($this->_getLevel() >= $this->_getLogLevel($log)){
				echo "#".++$counter.": {$this->_getLogMessage($log)}\n";
			}
		}
		echo '</pre>';
	}

	/**
	 * Gets the general log level
	 *
	 * @return int
	 */
	private function _getLevel()
	{
		if(\Juniper::registry('dev'))
		{
			return self::LOG_LEVEL_ALL;
		}
		return self::LOG_LEVEL_NORMAL;
	}

	/**
	 * Gets a log
	 *
	 * @return array
	 */
	private function _getLogs()
	{
		return $this->_log;
	}

	/**
	 * Returns the level of a log
	 *
	 * @param $log
	 * @return mixed
	 */
	private function _getLogLevel($log)
	{
		return $log['level'];
	}

	/**
	 * Returns the message of a log
	 *
	 * @param $log
	 * @return mixed
	 */
	private function _getLogMessage($log)
	{
		return $log['message'];
	}
}