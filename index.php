<?php

// Helper Constants
defined('DS')	||	define('DS', DIRECTORY_SEPARATOR);
defined('NL')	||	define('NL', PHP_EOL);

// System Constants
defined('BASE_DIR')		||	define('BASE_DIR', dirname(__FILE__));
defined('DATA_DIR')		||	define('DATA_DIR', BASE_DIR . DS . 'data');
defined('USER_DIR')		||	define('USER_DIR', DATA_DIR . DS . 'users');
defined('RESOURCE_DIR')	||	define('RESOURCE_DIR', BASE_DIR . DS . 'resources');
defined('LIB_DIR')		||	define('LIB_DIR', RESOURCE_DIR . DS . 'libs');
defined('TPL_DIR')		||	define('TPL_DIR', RESOURCE_DIR . DS . 'templates');
defined('CACHE_DIR')	||	define('CACHE_DIR', DATA_DIR . DS . 'cache');

// Include Libraries
require_once LIB_DIR . DS . 'smarty' . DS . 'Smarty.class.php';

// Instance Smarty
$smarty = new Smarty();

// Set Smarty Directories
$smarty->setTemplateDir(TPL_DIR)
		->setCompileDir(CACHE_DIR)
		->setCacheDir(CACHE_DIR);

// Clear Smarty Cache
$smarty->clearAllCache();
$smarty->clearCompiledTemplate();

// Real Logic Goes Here

// Load the template
$smarty->display('main.tpl');

