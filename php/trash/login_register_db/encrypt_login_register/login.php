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
$myform=array('submit'=>'login','username'=>'name','password'=>'pwd');
if(isset($_POST[$myform['submit']]))
{
	if(!empty($_POST[$myform['username']])&&!empty($_POST[$myform['password']]))
	{
        $username=trim($_POST[$myform['username']]);
        $password=trim($_POST[$myform['password']]);
        require_once'inc/authenicate.inc.php';
        if(empty($errors))
        {
                $registered=false;
        }
	}
	else
	{
	    $errors[]='请输入用户名和密码';
	}
}

require_once'inc/header.inc.php';
        if(!$registered)
        {
            echo '<div class="error">你不是注册用户，如果您现在要注册 
	            <a href="register.php">请点击这里</a></div>';	
        }
       if(!empty($errors))
	    {
	        echo '<ul>';
	        foreach($errors as $item)
	        {
	            echo "<li>$item</li>";
	        }
	        echo '</ul>';
	    }
if(isset($_GET[timeout]))
{
//添加用户离开时的状态值
    echo '<p class="error">你离开本站的时间太长了，如果你要重新登陆<a href="login.php">请单击这里
        </a></p>';
}  
require_once'inc/login.inc.php';
	
require_once'inc/footer.inc.php';
?>

  