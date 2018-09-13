<?php
require_once'../config/mysite.cfg.php';
require_once'inc/utility.inc.php';
session_start();

//loged go homepage
if(isset($_SESSION['username']))
{
    header("Location:$cfg_sitedir");
    exit;
 }
 
$errors=array();
$missing=array();
$requiredFields=array('username','password');

if(isset($_POST[submit]))
{
    $missing=checkRFields($_POST,$requiredFields);
	if(empty($missing))
	{
        $username=trim($_POST['username']);
        $password=trim($_POST['password']);
        require_once'inc/authenicate.inc.php';
	}
}

require_once'inc/header.inc.php';

if(isset($_GET[timeout]))
{
    if(isset($_SERVER[QUERY_STRING]))
        $query=$_SERVER[QUERY_STRING];
    echo '<p class="error">you leave so long that auto log out, if you want log in again,<a href="login.php">
        please click here</a></p>';
}  
require_once'inc/login.inc.php';
	
require_once'inc/footer.inc.php';
?>

  