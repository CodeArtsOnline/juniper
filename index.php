<?php

/**
 * Project: Juniper
 * Author: Sidia
 */


/** collect basic information */

/* set the base path */
$settings['base_dir'] = dirname(__FILE__);

/* set developer mode */
$developer_flag = "dev_flag";
$settings['developer_mode'] = (file_exists($settings['base_dir'].'/'.$developer_flag) || isset($_GET['dev']) || isset($_COOKIE['dev']));

/** Load autolaoder */
$autoloader = "App/Autoloader.php";
include_once($autoloader);

/** Run it */
Juniper::run($settings);