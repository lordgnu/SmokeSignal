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
		
		// Check for backup for today
		$backupFile = DATA_DIR . DS . date('YYYY-MM-DD') . '.backup.data.serial';
		if (!file_exists($backupFile)) {
			file_put_contents($backupFile, serialize($data));
		}
		
		// Check for status resets and the like
		foreach ($data['users'] as $i => $user) {
			// Check the index to make sure this isn't an empty row too...
			if ($i !== 0 && trim("{$i}") == '') {
				// Double check that this is an empty record
				if (!array_key_exists('hash', $user)) {
					unset($data['users'][$i]);
					continue;
				}
			}
			
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
	
	$save = array(
		'users'	=>	array()
	);
	
	// Double check all data
	foreach ($_DATA['users'] as $index => $user) {
		if (array_key_exists('hash', $user) && array_key_exists('name', $user) && !empty($user['name']) && !empty($user['hash'])) {
			$save['users'][$index] = $user;
		}
	}
	
	file_put_contents(DATA_DIR . DS . 'data.serial', serialize($save));
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
	
	$defaultMessage = "Your buddy " . $_DATA['users'][$userIndex]['name'] . " is going to smoke!";
	$buddyName = $_DATA['users'][$userIndex]['name'];
	
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
		
		foreach ($user['nmethods'] as $m) {
			// Setup Variable for this loop
			$message = $defaultMessage;
			$address = false;
			$headers = array(
					'From: SmokeBuddy <smoke@crouchingllama.org>'
			);
			$subject = '';
			
			if ($m['type'] == 'email') {
				// Set Headers
				$headers[] = 'MIME-Version: 1.0';
				$headers[] = 'Content-Type: text/html; charset=UTF-8';
				
				// Build HTML
				$message = <<<HTML
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
	<head>
		<meta content="text/html; charset=UTF-8" http-equiv="content-type" />
		<title>SmokeBuddy Notification</title>
		<meta content="Don Bauer" name="author" />
	</head>
	<body>
		<table style="text-align: left; width: 100%;">
			<tbody>
				<tr>
					<td style="width: 132px;" colspan="1" rowspan="2">
						<img style="width: 128px; height: 128px;" alt="SmokeBuddy" src="http://smoke.crouchingllama.org/images/webAppIcon.png" />
					</td>
					<td style="font-weight: bold;">
						<big><big><big>SmokeBuddy Notification</big></big></big>
					</td>
				</tr>
				<tr>
					<td>
						It's time for a break! Your buddy <span style="text-decoration: underline; font-style: italic;">{$buddyName}</span>	is going to smoke!
					</td>
				</tr>
				<tr align="center">
					<td colspan="2">
						<div style="color: rgb(153, 153, 153); font-style: italic; text-align: center;">
							<small>
								Message Sent Via SmokeBuddy Beta - By Don Bauer<br />
								A BauerBox Labs Production
							</small>
						</div>
					</td>
				</tr>
			</tbody>
		</table>
		<br />
	</body>
</html>
HTML;
				
				// Set Address
				$address = trim($m['address']);
				
				// Add subject
				$subject = 'SmokeBuddy Notification';
			} elseif ($m['type'] == 'att') {
				// Set Headers
				$headers[] = 'Content-Type: text/plain';
				
				// Set Address
				$address = trim($m['address']) . '@mms.att.net';
			} elseif ($m['type'] == 'verizon') {
				// Set Headers
				$headers[] = 'Content-Type: text/plain';
				
				// Set Address
				$address = trim($m['address']) . '@vzwpix.com';
			}
			
			// Send Message if address was set
			if ($address !== false) {
				$headers = implode(PHP_EOL, $headers);
				@mail($address, $subject, $message, $headers);
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