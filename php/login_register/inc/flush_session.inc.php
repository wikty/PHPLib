<?php
// Usage: only invoke by authenicated page
// Reference:
// 	APP_SESSION_TIME_KEY
// 	APP_SESSION_TIMEOUT
//	APP_INC_DIR
// 	APP_SIGNIN_URL
function flush_session($session_time_key=APP_SESSION_TIME_KEY, $session_timeout=APP_SESSION_TIMEOUT)
{
	if(!isset($_SESSION))
	{
		session_start();
	}
	$timenow=time();
	if($_SESSION[$session_time_key]+$session_timeout < $timenow)
	{
		$_SESSION = array();
		if(isset($_COOKIE[session_name()]))
		{
			setcookie(session_name(), '', time()-86400, '/');
		}
		session_destroy();
		// signin page will identify session timeout logout information
		// by argument ?session_timeout=1, and the from_url can login back
		require_once(APP_INC_DIR.'current_url.inc.php');
		header('Location:'.APP_SIGNIN_URL.'?session_timeout=1&from_url='.current_url());
		exit;
	}
	else
	{
		$_SESSION[$session_time_key]=$timenow;
	}
}