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
$_DATA = loadSerialData();

/*
 * $templateFile = Template File to Include
 * $headerText = Header Text
 * $footerText = Footer Text
 * */
$templateFile = 'dashboard.tpl';
$headerText = 'Smoke Buddy';
$footerText = '';
$jump = false;
$loginError = false;
$clearCookie = false;

$smarty->assignByRef('templateFile', $templateFile);
$smarty->assignByRef('headerText', $headerText);
$smarty->assignByRef('footerText', $footerText);
$smarty->assignByRef('DATA', $_DATA);
$smarty->assign('error', false);

// Check for login cookie
$sbData = array();
if (array_key_exists('sb', $_COOKIE)) {
	// SmokeBuddy Cookie found!
	$sbData = unserialize($_COOKIE['sb']);
}

// Check user cookie data
if (!array_key_exists('index', $sbData) || $sbData['index'] < 0) {
	if ($action != 'login' && $action != 'debug') {
		$action = 'register';
	}
} else {
	$smarty->assign('myIndex', $sbData['index']);
	$myIndex = $sbData['index'];
}

// Switch on Action
switch ($action) {
	case 'settings':
		if ($switch == 'submit') {
			$address = $_POST['address'];
			$type = $_POST['type'];
			
			$_DATA['users'][$myIndex]['nmethods'][] = array(
				'address'	=>	$address,
				'type'	=>	$type
			);
			
			$smarty->assign('msg', 'Notification method added!');
			
			$templateFile = 'settings.tpl';
		} else {
			// Check for notification method count
			$c = array();
			if (count($_DATA['users'][$myIndex]['nmethods'])) {
				$c['top'] = 'false';
				$c['bottom'] = 'true';
			} else {
				$c['top'] = 'true';
				$c['bottom'] = 'false';
			}
			
			// Assign Count Data
			$smarty->assign('c', $c);
			
			$templateFile = 'settings.tpl';
			$headerText = 'Notifications';
		}
		break;
	case 'login':
		$name = $_POST['login-name'];
		$pin = $_POST['login-pin'];
		
		// Loop through the users and find name
		foreach ($_DATA['users'] as $user) {
			if ($user['name'] == $name) {
				// Found user!  Check Pin
				if ($user['pin'] == $pin) {
					$sbData = $user;
					$jump = true;
					break;
				}
			}
		}
		
		if ($jump !== true) {
			$loginError = 'Name and PIN do not match';
			$templateFile = 'register.tpl';
		}
		break;
	case 'register':
		$smarty->assign('loginError', false);
		
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
				$jump = true;
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
	case 'status':
		// Changing status
		switch ($switch) {
			case 'away':
			case 'smoking':
			case 'not-smoking':
				changeUserStatus($myIndex, $switch);
				
				if ($switch != 'not-smoking') {
					// Send to notification disabled time page
					if ($switch == 'smoking') {
						$smarty->assign('status', 'Smoking');
					} else {
						$smarty->assign('status', 'Away');
					}
					
					$templateFile = 'expire.tpl';
				} else {
					// Send back to dashboard
					jump();
				}
				break;
			default:
				$templateFile = 'status.tpl';
				break;
		}
		break;
	case 'expire':
		if ($switch == 'submit') {
			$minutes = 0;
			$hours = 0;
			$days = 0;
			
			if ($_POST['status'] == 'Smoking') {
				// Just Minutes
				$minutes = (int) $_POST['minutes'];
			} else {
				// Hours and Days
				$hours = (int) $_POST['hours'];
				$days = (int) $_POST['days'];
			}
			
			// Update Expire Time
			$expire = time() + (($minutes * 60) + ($hours * 3600) + ($days * (3600 * 24)));
			changeUserExpire($myIndex, $expire);
			
			// Send to dashboard
			jump();
		} else {
			if ($_DATA['users'][$myIndex]['status'] == 'smoking') {
				$smarty->assign('status', 'Smoking');
			} elseif ($_DATA['users'][$myIndex]['status'] == 'away') {
				$smarty->assign('status', 'Away');
			} else {
				jump();
			}
			$templateFile = 'expire.tpl';
		}
		break;
	case 'debug':
		$templateFile = 'debug.tpl';
		$headerText = 'Debug Dump';
		
		if ($switch == 'clear') {
			$_DATA = array();
			$clearCookie = true;
		}
		break;
	default:
		$templateFile = 'dashboard.tpl';
		break;
}

// Save Serial Data
saveSerialData();

// Update Cookie
if ($clearCookie === true) {
	setcookie('sb', '', strtotime('-1 year'), '/');
} else {
	setcookie('sb', serialize($sbData), strtotime('+1 year'), '/');
}

if ($templateFile == 'dashboard.tpl' && $action != 'default') {
	jump();
}

if ($jump === false) {
	// Load the template
	if ($action != 'settings' && $action != 'register') {
		$smarty->assign('showSettings', true);
	} else {
		$smarty->assign('showSettings', false);
	}
	
	if ($templateFile != 'dashboard.tpl' && $action != 'register') {
		$smarty->assign('showHome', true);
	} else {
		$smarty->assign('showHome', false);
	}
	
	// Assign Smarty Helper Data
	if ($action != 'login' && $action != 'register') {
		setUserSmartyData();
	}
	$smarty->assign('idMod', str_replace(' ','-',microtime(false)));
	$smarty->display('main.tpl');
} elseif ($jump === true) {
	jump();
} else {
	jump($jump);
}