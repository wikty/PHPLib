<?php

define('APP_ROOT_DIR', 
	join(DIRECTORY_SEPARATOR, array(dirname($_SERVER['SCRIPT_FILENAME']))));

define('APP_ROOT_URL', 'http://localhost'.dirname($_SERVER['SCRIPT_NAME']));

define('APP_INC_DIR', 
	join(DIRECTORY_SEPARATOR, array(APP_ROOT_DIR,
									'inc',
									'')));

define('APP_RESOURCE_DIR',
	join(DIRECTORY_SEPARATOR, array(APP_ROOT_DIR,
									'resource',
									'')));

define('APP_RESOURCE_URL',
	join('/', array(APP_ROOT_URL,
					'resource',
					'')));

define('APP_ERROR_PAGE',
	join('/', array(APP_ROOT_URL, 
					'error.php')));

define('APP_DOWNLOAD_KEY', 'dnlditem');  // download link like: ?dnlditem=path-to-file/file.txt

define('APP_ERROR_PAGE_ACCESS_KEY', 'access_key');

define('APP_ERROR_PAGE_ERROR_KEY', 'error');

define('APP_ERROR_PAGE_REASON_KEY', 'reason');