<?php

define('APP_ROOT_DIR', dirname($_SERVER['SCRIPT_FILENAME']));

define('APP_INC_DIR',
	join(DIRECTORY_SEPARATOR, array(APP_ROOT_DIR,
									'inc',
									'')));

// MPF is multiple page form
define('APP_MPF_ACCESS_KEY', 'access_key');
define('APP_MPF_FORM_KEY', 'mfp_form');