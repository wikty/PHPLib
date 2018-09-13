<?php
session_start();
include('config.php');

if(isset($_GET[APP_ERROR_PAGE_ACCESS_KEY]))
{
	if($_GET[APP_ERROR_PAGE_ACCESS_KEY]==$_SESSION[APP_ERROR_PAGE_ACCESS_KEY])
	{
		// allow access error
		echo 'Error: '.$_GET[APP_ERROR_PAGE_ERROR_KEY];
		echo '<br/>';
		echo 'Reason: '.$_GET[APP_ERROR_PAGE_REASON_KEY];
		


		// reset access value
		$_SESSION[APP_ERROR_PAGE_ACCESS_KEY]=sha1(rand());
		exit;
	}
}

echo '<h2>You cannot access error page directly</h2>';
