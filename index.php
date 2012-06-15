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

// Include Subs
require_once LIB_DIR . DS . 'smokeBuddy' . DS . 'subs.php';

// Instance Smarty
$smarty = new Smarty();

// Set Smarty Directories
$smarty->setTemplateDir(TPL_DIR)
		->setCompileDir(CACHE_DIR)
		->setCacheDir(CACHE_DIR);

// Clear Smarty Cache
$smarty->clearAllCache();
$smarty->clearCompiledTemplate();

// Set dispatch variables
$action = array_key_exists('action', $_GET) ? $_GET['action'] : 'default';
$switch = array_key_exists('switch', $_GET) ? $_GET['switch'] : 'default';

// Load Data
$_DATA = loadINIdata();

/*
 * $templateFile = Template File to Include
 * $headerText = Header Text
 * $footerText = Footer Text
 * */
$templateFile = 'dashboard.tpl';
$headerText = 'Smoke Buddy';
$footerText = '';

$smarty->assignByRef('templateFile', $templateFile);
$smarty->assignByRef('headerText', $headerText);
$smarty->assignByRef('footerText', $footerText);


// Check for login cookie
if (array_key_exists('sbData', $_COOKIE)) {
	// SmokeBuddy Cookie found!
	$sbData = unserialize($_COOKIE['sbData']);
} else {
	$sbData = array(
		'INI'	=>	'',
		'Name'	=>	'',
		'Hash'	=>	''
	);
}

// Perform Requested Action
if ($sbData['Name'] == '') {
	// User needs to register or login
	$action = 'register';
}

// Switch on Action
switch ($action) {
	case 'register':
		if ($switch == 'submit') {
			// Get Post Data
			$user = array(
				'name'			=>	$_POST['name'],
				//'organization'	=>	$_POST['organization'],
				'pin'			=>	$_POST['pin'],
				'timer'			=>	(int) $_POST['timer']
			);
			
			// Add User
			$userAdded = addUser($user);
			if ($userAdded === true) {
				// User added successfully!
				$templateFile = 'dashboard.tpl';
			} else {
				// There was an error
				$smarty->assign('error', $userAdded);
				$templateFile = 'register.tpl';
			}
		} else {
			// Show the form
			$templateFile = 'register.tpl';
		}
		break;
	default:
		$templateFile = 'dashboard.tpl';
		break;
}

// Update Cookie
setcookie('sbData', serialize($sbData), strtotime('+1 year'));

// Load the template
$smarty->display('main.tpl');