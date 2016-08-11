<?php

namespace App\Core;

/**
 * Class Json
 * @package App\Core
 *
 * Json class
 */
class Json extends Core
{
	/**
	 * Reads a given file and outputs a decoded json array
	 *
	 * @param $path
	 * @return bool|mixed
	 */
	public function readJson($path)
	{
		if(!is_file($path)){
			\Juniper::throwException('JsonException', "File {$path} is missing");
			return false;
		}

		$json = file_get_contents($path);
		$decoded_json = json_decode($json, true);

		if(json_last_error() != JSON_ERROR_NONE){
			\Juniper::throwException('JsonException', "File {$path} does not contains invalid json");
			return false;
		}

		return $decoded_json;
	}
}