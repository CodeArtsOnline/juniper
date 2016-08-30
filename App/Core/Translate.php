<?php

namespace App\Core;


/**
 * Class Translate
 * @package App\Core
 */
class Translate extends Core
{
	use Traits\Singleton;

	/**
	 * Stores the now used language
	 *
	 * @var bool
	 */
	private $_language = false;

	/**
	 * Stores all translations
	 *
	 * @var array
	 */
	private $_dictionary = array();

	/**
	 * Prepares and executes the translation
	 *
	 * @param $text
	 * @param null $lang
	 * @return mixed
	 */
	public function __($text, $lang = null)
	{
		$lang = $this->getLanguage($lang);

		if(!isset($this->_dictionary[$lang])){
			$this->_loadLanguage($lang);
		}

		$translation = $this->_translate($text, $lang);

		return $translation;
	}

	/**
	 * Loads a dictionary of a new language
	 *
	 * @param $language
	 */
	private function _loadLanguage($language)
	{
		$base_dir = \Juniper::registry('base_dir');
		$language_dir = "{$base_dir}/App/Locale/{$language}/";

		if(!is_dir($language_dir)){
			\Juniper::throwException('LanguageException', "No language with name {$language} found");
			return;
		}

		foreach(new \DirectoryIterator($language_dir) as $file){
			if($file->isDot()){
				continue;
			}

			$dictionary = $this->core('json')->readJson($language_dir.$file->getFilename());

			if(!isset($this->_dictionary[$language])) {
				$this->_dictionary[$language] = array();
			}
			$this->_dictionary[$language] = array_merge($this->_dictionary[$language], $dictionary);
		}
	}

	/**
	 * Determines the language to use
	 *
	 * @param null $lang
	 * @return string
	 */
	public function getLanguage($lang = null)
	{
		if(!is_null($lang)){
			return $lang;
		}
		elseif($this->_language){
			return $this->_language;
		}
		elseif(!is_null($this->core('param')->param('lang'))){
			$language = $this->core('param')->param('lang');
		}
		elseif(!is_null($this->core('param')->session('lang'))){
			$language = $this->core('param')->session('lang');
		}
		elseif(!is_null($this->core('param')->cookie('lang'))){
			$language = $this->core('param')->cookie('lang');
		}
		else{
			$language = $this->singleton('config')->getLanguage();
		}

		$this->_language = $language;

		return $language;
	}

	/**
	 * Translate the string
	 *
	 * @param $text
	 * @param $language
	 * @return mixed
	 */
	private function _translate($text, $language)
	{
		if(isset($this->_dictionary[$language][$text])){
			return $this->_dictionary[$language][$text];
		}

		return $text;
	}
}