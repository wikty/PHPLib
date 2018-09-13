<?php
$dbc = new mysqli ($cfg_db_host,$cfg_db_w_user,$cfg_db_w_password,$cfg_db_dbname);
if (!$dbc) {
	trigger_error ('Could not connect to MySQL: ' . $dbc->error() );
} else {
	$dbc->set_charset($cfg_db_charset);
}