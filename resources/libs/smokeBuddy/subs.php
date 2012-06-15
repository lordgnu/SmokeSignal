<?php

function jump($url = '/') {
	header('Location: ' . $url);
}

function loadSerialData() {
	if (file_exists(DATA_DIR . DS . 'data.serial')) {
		return unserialize(file_get_contents(DATA_DAR . DS . 'data.serial'));
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
	
	$data['index'] = $index;
	$sbData = $data;
	
	return true;
}