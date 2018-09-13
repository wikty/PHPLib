<?php
include('config.php');
//include(APP_INC_DIR.'authenicate.inc.php');
include(APP_INC_DIR.'authenicate_encrypt.inc.php');

$fields = array('submit'=>'logout');

if(is_authenicated(APP_AUTHENICATE_KEY))
{
	if(isset($_POST[$fields['submit']]))
	{
		$_SESSION=array();
		if(isset($_COOKIE[session_name()]))
		{
			setcookie(session_name(),'',time()-86400,'/');
			session_destroy();
		}			
	}
}

header("Location:".APP_ROOT_URL);
exit;
?>