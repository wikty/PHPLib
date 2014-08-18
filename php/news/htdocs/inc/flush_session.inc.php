<?php
require_once'../config/mysite.cfg.php';
if(! $_SESSION)
{
    session_start();
}
if(isset($_SESSION[time]))
{
	$timenow=time();
	if($_SESSION['time']+$cfg_sessionlifetime < $timenow)
	{
		$_SESSION=array();
		if(isset($_COOKIE[session_name()]))
		{
			setcookie(session_name(),'',time()-86400,'/');
		}
		session_destroy();
		header("Location:{$cfg_sitedir}?sess_timeout=yes");
		exit;
	}
	else
	{
		$_SESSION['time']=time();
	}
}
?>