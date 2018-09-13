<?php
$loginpage='login.php';
session_start();
if(!(isset($_SESSION['username']) && isset($_SESSION[password])))
{
	header("Location:$loginpage");
	exit;
}

?>