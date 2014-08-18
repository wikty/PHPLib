<?php
$loginpage='login.php';
if(!isset($_SESSION))
{
    session_start();
}
if(!isset($_SESSION['authenicated']))
{
	header("Location:$loginpage");
	exit;
}

?>