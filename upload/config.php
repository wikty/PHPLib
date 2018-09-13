<?php

define('APP_ROOT_DIR', dirname($_SERVER['SCRIPT_FILENAME']));

define('APP_ROOT_URL', 'http://localhost'.dirname($_SERVER['SCRIPT_NAME']));

define('APP_INC_DIR', 
	join(DIRECTORY_SEPARATOR, array(APP_ROOT_DIR,
									'inc',
									'')));

define('APP_RESOURCE_DIR', 
	join(DIRECTORY_SEPARATOR, array(APP_ROOT_DIR,
									'resource', 
									'')));

