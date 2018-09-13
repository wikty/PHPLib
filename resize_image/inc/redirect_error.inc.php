<?php
function redirect_error(
	$error, 
	$reason, 
	$error_page=APP_ERROR_PAGE, 
	$error_page_access_key=APP_ERROR_PAGE_ACCESS_KEY,
	$error_key=APP_ERROR_PAGE_ERROR_KEY,
	$error_reason_key=APP_ERROR_PAGE_REASON_KEY)
{
	if(!isset($_SESSION))
	{
		session_start();
	}

	if(!isset($reason))
	{
		$reason='';
	}
	if(!isset($error))
	{
		$error='Unknow Error';
		$reason='Unknow Reason';
	}

	$_SESSION[$error_page_access_key]=sha1(rand());

	header(join('', array('Location: ',
						  $error_page,
						  '?',
						  $error_page_access_key,
						  '=',
						  $_SESSION[$error_page_access_key],
						  '&',
						  $error_key,
						  '=',
						  $error,
						  '&',
						  $error_reason_key,
						  '=',
						  $reason)));
	exit;
}
