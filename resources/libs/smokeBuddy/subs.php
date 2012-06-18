<?php

function jump($url = '/') {
	header('Location: ' . $url);
}

function getStatusTheme($status) {
	switch ($status) {
		case 'smoking':
			return 'c';
		case 'not-smoking':
			return 'e';
		default:
			return 'b';
	}
}

function loadSerialData() {
	if (file_exists(DATA_DIR . DS . 'data.serial')) {
		$data = unserialize(file_get_contents(DATA_DIR . DS . 'data.serial'));
		
		// Check for status resets and the like
		foreach ($data['users'] as $i => $user) {
			if (array_key_exists('status', $user)) {
				// Check for smoking and away statuses
				if ($user['status'] == 'smoking' || $user['status'] == 'away') {
					// Check to make sure that we have not passed the expire time
					if ($user['statusExpire'] != -1 && $user['statusExpire'] < time()) {
						// Status has expired
						$data['users'][$i]['status'] = 'not-smoking';
						$data['users'][$i]['statusTime'] = $user['statusExpire'];
						$data['users'][$i]['statusExpire'] = -1;
					}
				}
			} else {
				// Set default status of not smoking
				$data['users'][$i]['status'] = 'not-smoking';
				$data['users'][$i]['statusTime'] = time();
				$data['users'][$i]['statusExpire'] = -1;
			}
			
			// Set status theme
			$data['users'][$i]['statusTheme'] = getStatusTheme($data['users'][$i]['status']);
			
		}
		
		// Return Data
		return $data;
	} else {
		return array(
			'control'	=>	array(),
			'users'	=>	array()
		);
	}
}

function saveSerialData() {
	global $_DATA;
	file_put_contents(DATA_DIR . DS . 'data.serial', serialize($_DATA));
}

function addUser($data) {
	global $_DATA, $sbData;
	
	// Check for this user's full name
	foreach ($_DATA['users'] as $user) {
		if ($user['name'] == $data['name']) {
			return 'It seems you are already registered';
		}
	}
	
	// Add User to Index
	$data['hash'] = sha1($data['name'] . $data['pin']);
	
	$index = count($_DATA['users']);
	$_DATA['users'][$index] = $data;
	
	$_DATA['users'][$index]['status'] = 'not-smoking';
	$_DATA['users'][$index]['statusTime'] = time();
	
	$data['index'] = $index;
	$sbData = $data;
	
	return true;
}

function changeUserStatus($userIndex, $status) {
	global $_DATA;
	
	$time = time();
	$expire = $time + ($_DATA['users'][$userIndex]['timer'] * 60);
	
	// Set the status in the main array for user
	switch ($status) {
		case 'smoking':
			$_DATA['users'][$userIndex]['status'] = 'smoking';
			$_DATA['users'][$userIndex]['statusTime'] = $time;
			$_DATA['users'][$userIndex]['statusExpire'] = $expire;
			sendSmokingNotification($userIndex);
			break;
		case 'not-smoking':
			$_DATA['users'][$userIndex]['status'] = 'not-smoking';
			$_DATA['users'][$userIndex]['statusTime'] = $time;
			$_DATA['users'][$userIndex]['statusExpire'] = -1;
			break;
		case 'away':
			$_DATA['users'][$userIndex]['status'] = 'away';
			$_DATA['users'][$userIndex]['statusTime'] = $time;
			$_DATA['users'][$userIndex]['statusExpire'] = -1;
			break;
	}
	
	$_DATA['users'][$userIndex]['statusTheme'] = getStatusTheme($status);
}

function changeUserExpire($userIndex, $expire = -1) {
	global $_DATA;
	
	$_DATA['users'][$userIndex]['statusExpire'] = time() + $expire;
	
	// Check for expire timer default on user profile
	if ($_DATA['users'][$userIndex]['status'] == 'smoking') {
		if ($_DATA['users'][$userIndex]['timer'] * 60 != $expire) {
			$_DATA['users'][$userIndex]['timer'] = (int) ($expire / 60);
		}
	}
}

function sendSmokingNotification($userIndex) {
	global $_DATA;
	
	$cutOff = strtotime('-10 minutes');
	
	$message = "Your buddy " . $_DATA['users'][$userIndex]['name'] . " is going to smoke!";
	
	// Loop through users and send notification if they have not recieved one in the last 10 minutes
	foreach ($_DATA['users'] as $i => $user) {
		// Check if this is the user sending the notification
		if ($i == $userIndex) {
			$_DATA['users'][$i]['lastNotify'] = time();
			continue;
		}
		
		// Check if they are smoking already
		if ($user['status'] == 'smoking') {
			// Aready smoking
			// continue;
		}
		
		// Check if they are away
		if ($user['status'] == 'away') {
			// They are away
			continue;
		}
		
		// Check for last notification time
		if (array_key_exists('lastNotify', $user)) {
			if ($user['lastNotify'] > $cutOff) {
				// Already Been Notified in last 10 minutes
				// continue;
			}
		}
		
		// Send notifications
		$_DATA['users'][$i]['lastNotify'] = time();
		
		$header = "Content-type: text/plain\r\nFrom: SmokeBuddy <smoke@crouchingllama.org>";
		
		foreach ($user['nmethods'] as $m) {
			if ($m['type'] == 'email') {
				$html = "<html><head></head><body><h3>Smoke Buddy Notification</h3><p>{$message}</p></body></html>";
				$header = "Content-type: text/html\r\nFrom: SmokeBuddy <smoke@crouchingllama.org>";
				mail($m['address'], 'SmokeBuddy Notification', $html, $header);
			} elseif ($m['type'] == 'att') {
				mail(trim($m['address']) . '@mms.att.net', '', $message, $header);
			} elseif ($m['type'] == 'verizon') {
				mail(trim($m['address']) . '@vzwpix.com', '', $message, $header);
			}
		}
	}
}

function setUserSmartyData() {
	global $_DATA, $sbData, $smarty;
	
	$smarty->assignByRef('myName', $_DATA['users'][$sbData['index']]['name']);
	$smarty->assignByRef('myStatus', $_DATA['users'][$sbData['index']]['status']);
	$smarty->assignByRef('myTheme', $_DATA['users'][$sbData['index']]['statusTheme']);
	$smarty->assignByRef('myData', $_DATA['users'][$sbData['index']]);
	
}