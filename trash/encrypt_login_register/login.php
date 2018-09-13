<?php
require_once'config/mysite.cfg.php';
session_start();
if(isset($_SESSION['authenicated']))
{
    header("Location:$cfg_sitedir");
    exit;
 }
$errors=array();
$registered=true;
$usersdata='usersdata/usersdata.txt';
$myform=array('submit'=>'login','username'=>'name','password'=>'pwd');
if(isset($_POST[$myform['submit']]))
{
	if(!empty($_POST[$myform['username']])&&!empty($_POST[$myform['password']]))
	{
        $username=$_POST[$myform['username']];
        $password=$_POST[$myform['password']];
        require_once'inc/authenicate.inc.php';
        if(empty($errors))
        {
                $registered=false;
        }
	}
	else
	{
	    $errors[]='please input username and password .';
	}
}

require_once'inc/header.inc.php';
        if(!$registered)
        {
            echo '<div class="error">you is not a regsited user,if you want to register,please 
	            <a href="register.php">Click Here</a></div>';	
        }
       if(!empty($errors))
	    {
	        echo '<ol>';
	        foreach($errors as $item)
	        {
	            echo "<li>$item</li>";
	        }
	        echo '</ol>';
	    }
if(isset($_GET[timeout]))
{
    echo '<p class="error">you leave too long ,so if you want goback to our site, please login again</p>';
}  
require_once'inc/login.inc.php';
	
require_once'inc/footer.inc.php';
?>

  