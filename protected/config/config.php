<?php

// Check if we run in cli mode or not
// then verify out location

// Empty params
$connectionString = '';
$dbhost = 'localhost';
$dbdriver = 'mysql';
$dbname = '';
$dbuser = '';
$dbpass = '';
$dbextra = '';
$dbprefix = '';
$debugmode = false;

if(verifyLocation('yourlocalfoldername')) { // change yourlocalfoldername to the folder name on your local machine where this app is running on
	$dbname = 'atthevip';
	$dbextra = '';
	$connectionString = $dbdriver.':host='.$dbhost.';dbname=' . $dbname . $dbextra;
	$dbuser = '';
	$dbpass = '';
	$dbprefix = '';
	$debugmode = true;
} else {
	$dbname = 'atthevip';
	$dbhost = 'localhost';
	$connectionString = $dbdriver.':host='.$dbhost.';dbname=' . $dbname . $dbextra;
	$dbuser = '';
	$dbpass = '';
	$dbprefix = '';
	//$debugmode = true;
}

// Set params
define('CONNECTION_STRING', $connectionString);
define('DB_NAME', $dbname);
define('DB_HOST', $dbhost);
define('DB_DRIVER', $dbdriver);
define('DB_USER', $dbuser);
define('DB_PASS', $dbpass);
define('DB_EXTRA', $dbextra);
define('DB_PREFIX', $dbprefix);
define('DEBUG_MODE', $debugmode);

function isCli() {
     if(php_sapi_name() == 'cli' && empty($_SERVER['REMOTE_ADDR'])) {
          return true;
     } else {
          return false;
     }
}

function verifyLocation($key) {
	if(isCli()) {
		return (strpos($_SERVER['PWD'], $key) !== false);
	} else {
		return (strpos($_SERVER['DOCUMENT_ROOT'], $key) !== false);
	}
}