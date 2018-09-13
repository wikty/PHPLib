<?php
// NOTICE: who include this file, indicate that file in app root directory
// NOTICE: all directory path have endswith /, except APP_ROOT_DIR and APP_ROOT_URL
define('APP_ROOT_DIR', 
	join(DIRECTORY_SEPARATOR, array(dirname($_SERVER['SCRIPT_FILENAME']))));

define('APP_ROOT_URL', 
	join('', array('http://',
					$_SERVER['SERVER_NAME'], 
					':', 
					$_SERVER['SERVER_PORT'], 
					dirname($_SERVER['SCRIPT_NAME']))));

define('APP_INC_DIR',
	join(DIRECTORY_SEPARATOR, array(APP_ROOT_DIR, 
									'inc',
									'')));
define('APP_DATA_DIR',
	join(DIRECTORY_SEPARATOR, array(APP_ROOT_DIR, 
									'data',
									'')));
define('APP_STATIC_DIR', 
	join(DIRECTORY_SEPARATOR, array(APP_ROOT_DIR, 
									'static',
									'')));
define('APP_STATIC_URL', 
	join('/', array(APP_ROOT_URL, 
					'static',
					'')));

define('APP_SIGNIN_URL',
	join('/', array(APP_ROOT_URL,
					'signin.php')));

define('APP_SIGNOUT_URL', 
	join('/', array(APP_ROOT_URL,
					'signout.php')));

define('APP_SIGNUP_URL',
	join('/', array(APP_ROOT_URL,
					'signup.php')));

define('APP_AUTHENICATE_KEY', 'authenicated');

define('APP_SESSION_TIME_KEY', 'last_request_time');

define('APP_SESSION_TIMEOUT', 60*3); // timeout 3 mintues session break