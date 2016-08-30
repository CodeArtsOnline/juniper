<?php

namespace App\Core;


/**
 * Class Config
 * @package App\Core
 */
class Config extends Core
{
	use Traits\Singleton;

	/**
	 * Stores the configuration
	 *
	 * @var array
	 */
	private $_configuration = array();

	/**
	 * Initialises the basic configuration
	 */
	public function init()
	{
		$base_path = \Juniper::registry('base_path');
		$base_config_path = $base_path."App/Config/Juniper.config.json";

		$this->loadFile($base_config_path, 'juniper');
	}

	/**
	 * Loads a file
	 *
	 * @param $path
	 * @param $scope
	 */
	public function loadFile($path, $scope)
	{
		$configuration = $this->core('json')->readJson($path);
		$this->addArray($configuration, $scope);
	}

	/**
	 * Adds an array to the configuration
	 *
	 * @param $config
	 * @param $scope
	 */
	public function addArray($config, $scope)
	{
		if(!is_array($config)){
			\Juniper::throwException('ConfigException', "Array expected");
		}

		if(!$this->scopeExists($scope)){
			$this->_configuration[$scope] = array();
		}

		$this->_configuration = array_merge($this->_configuration, $config);
	}

	/**
	 * Checks if a scope exists
	 *
	 * @param $scope
	 * @return bool
	 */
	public function scopeExists($scope)
	{
		return (isset($this->_configuration[$scope]));
	}

	/**
	 * Returns a value
	 *
	 * @param $name
	 * @return array|null
	 */
	public function get($name)
	{
		$name_split = explode("/", $name);
		$conf = $this->_configuration;
		foreach($name_split as $slug){
			if(!isset($conf[$slug])) {
				return null;
			}

			$conf = $conf[$slug];
		}

		return $conf;
	}

	/**
	 * Sets a value
	 *
	 * @param $name
	 * @param $value
	 * @return $this
	 */
	public function set($name, $value)
	{
		$name_split = explode("/", $name);
		$conf = &$this->_configuration;
		foreach($name_split as $slug){
			if(!isset($conf[$slug])) {
				$conf[$slug] = array();
			}

			$conf = &$conf[$slug];
		}

		$conf = $value;
		return $this;
	}

	/**
	 * Magic call function for get and set functions
	 *
	 * @param $name
	 * @param $args
	 * @return mixed
	 */
	public function __call($name, $args)
	{
		$func = substr($name, 0, 3);
		$name = str_replace(array("get", "set"), "", $name);
		$name = \Juniper::core("strings")->camelToPath($name);
		array_unshift($args, $name);

		return call_user_func_array(array($this, $func), $args);
	}
}