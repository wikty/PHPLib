<?php
session_start();

//loged go homepage
if(isset($_SESSION['username']))
{
    header("Location:$cfg_sitedir");
    exit;
 }
 
require_once'../mysite.cfg.php';
require_once'inc/utility.inc.php';

$errors=array();
$missing=array();
$requiredFields=array('username','password');

if($_SERVER['REQUEST_METHOD'] == 'POST')
{
    $missing=checkRFields($_POST,$requiredFields);
	if(empty($missing))
	{
        $username=trim($_POST['username']);
        $password=trim($_POST['password']);
        require_once'inc/authenicate.inc.php';
	}
}
$page_title='Login';
$stylesheets=array('main.css');
$scripts=array('utility.js');
require_once'inc/header.inc.php';
require_once'inc/login.inc.php';
require_once'inc/footer.inc.php';
?>

  