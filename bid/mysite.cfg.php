<?php
/////////////////////////////
///error handle
function my_error_handler ($e_number, $e_message, $e_file, $e_line, $e_vars) {
	// Build the error message:
	$message = "An error occurred in script '$e_file' on line $e_line: $e_message\n";
	// Add the date and time:
	$message .= "Date/Time: " . date('n-j-Y H:i:s') . "\n";
	if (!$cfg_site_status) { 
	// Development (print the error).
		echo '<div class="error">' . nl2br($message);
		// Add the variables and a backtrace:
		echo '<pre>' . print_r ($e_vars, 1) . "\n";
		debug_print_backtrace();
		echo '</pre></div>';
	} else { // Don't show the error:
		// Send an email to the admin:
		$body = $message . "\n" . print_r ($e_vars, 1);
		mail($cfg_siteadmin_email, 'Site Error!', $body, 'From: email@example.com');
		// Only print an error message if the error isn't a notice:
		if ($e_number != E_NOTICE) {
			echo '<div class="error">A system error occurred. We apologize for the inconvenience.</div><br />';
		}
	}
}
//////////////////////////////
//////database information
define('MYSQLI', '../mysqli_connection.inc.php');
$cfg_db_host='localhost';
$cfg_db_r_user='root';
$cfg_db_w_user='root';
$cfg_db_r_password='123456789';
$cfg_db_w_password='123456789';
$cfg_db_dbname='mybid';
$cfg_db_charset='utf8';
///////////////////////////////////
///site base information
//incidate site is debug mode
$cfg_site_status=false;
$cfg_sessionlifetime=60*2;  //2 mins
$cfg_siteloginpage='login.php';
$cfg_sitepath=dirname($_SERVER[PHP_SELF]).'/';
$cfg_sitedir='http://'.$_SERVER[HTTP_HOST].$cfg_sitepath;
$cfg_sitename='Big Bid';
$cfg_siteauthor='xiaowenbin';
$cfg_siteadmin_name='xiaowenbin';
$cfg_siteadmin_email='xiaowenbin_999@163.com';
///////////////////////////////////////
////resource
//////////////////////////////////
////locale
$cfg_locale_money='$';
////////////////////////////////////
///Set
// Adjust the time zone for PHP 5.1 and greater:
date_default_timezone_set ('US/Eastern');
// set the error handler:
//set_error_handler ('my_error_handler');
?>