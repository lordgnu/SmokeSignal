<?php

function loadINIdata() {
	return parse_ini_file(DATA_DIR . DS . 'data.ini');
}

function saveINIdata($filename, $data) {
	
}

function addUser($data) {
	global $_DATA;
	
	return "Adding users is not currently supported!";
}