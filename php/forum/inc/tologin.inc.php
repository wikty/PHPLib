<?php
$loginpage='login.php';
if(!$_SESSION)
    session_start();
if(!(isset($_SESSION['username']) && isset($_SESSION[password])))
{
	header("Location:$loginpage");
	exit;
}
?>