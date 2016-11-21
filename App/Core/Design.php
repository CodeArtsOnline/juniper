<?php

namespace App\Core;

/**
 * Class Design
 * @package App\Core
 *
 * Design class
 */
class Design extends Core
{
	use Traits\Singleton;

	private $_design = "";

	public function init()
	{
		$this->_design = $this->singleton('core/config')->getDesign();
	}
}