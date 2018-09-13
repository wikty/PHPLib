<?php
$needDB=true;
require_once'config/mysite.cfg.php';
session_start();
if(isset($_SESSION[username]) && isset($_SESSION[password]))
{
    header("Location:$cfg_sitedir");
    exit;
}
if(isset($_GET[from]))
{
    $from=urldecode($_GET[from]);
    $query=$_SERVER[QUERY_STRING];
}
if($_POST[submit])
{
    $username=trim($_POST[username]);
    $password=trim($_POST[password]);
	if(empty($username) || empty($password))
	{
		$error='请输入用户名和密码';
	}
	else
	{
	//should be modified
		$sql='SELECT username,password
				FROM users
				WHERE username="'.$username.'"
				AND password="'.$password.'"
				AND active=1';
	//end modified
		require_once'inc/getdb.inc.php';
		$results=$mysqli->query($sql);
		$row=$results->fetch_object();
		$num_rows=$results->num_rows;
		if($num_rows==0)
		{
			$error='你不是注册用户，如果你想要注册请 <a href="register.php">单击这里</a>';
		}
		else
		{
			$_SESSION['username']=$_POST['username'];
			$_SESSION['password']=$_POST['password'];
			if(!isset($from))
			{
				header("Location:$cfg_sitedir");
			}
			else
		   {
			   header("Location:$cfg_sitedir".$from.'?'.$query);
		   }
			exit;
		}
	}
}


require_once'inc/header.inc.php';
if($error)
{
    echo $error;
}
require_once'inc/login.inc.php';
require_once'inc/footer.inc.php';
?>