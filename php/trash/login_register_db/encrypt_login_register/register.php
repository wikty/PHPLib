<?php
header("charset:utf-8");
require_once'inc/connection.inc.php';
require_once'class/my_checkpassword.class.php';
require_once'config/mysite.cfg.php';
$errors=array();
$usermin='2';
$myform=array('username'=>'name','password'=>'pwd','rpassword'=>'rpwd','submit'=>'reg');
if(isset($_POST[$myform['submit']]))
{
	if(!empty($_POST[$myform['username']])&&!empty($_POST[$myform['password']])
	    &&!empty($_POST[$myform['rpassword']]))
	{
	    $username=trim($_POST[$myform['username']]);
	    $password=trim($_POST[$myform['password']]);
	    if(mb_strlen($username,'utf-8')<$usermin)
        {
            $errors[0][]="用户名至少有{$usermin}个字符";
        }
        if(preg_match('/\s/',$username))
        {
            $errors[0][]='用户名不能有空格';
        }
        if($_POST[$myform['password']]!=$_POST[$myform['rpassword']])
        {
            $errors[1][]='两次输入的密码不一致';
        }
        $checkpwd=new my_checkpassword($password);
         //$checkpwd->allowSpaces();
         //$checkpwd->requireMixedCase();
         //$checkpwd->requireNumbers(3);
         //$checkpwd->requireSymbols();
        $pwdOK=$checkpwd->check();
        if(! $pwdOK)
        {
            if(!is_array($errors[1]))
            {
                $errors[1]=array();
            }
            $errors[1]=array_merge($errors[1],$checkpwd->getMessage());
        }
//base information check end here 
        if(empty($errors))
        {
                    $salt=time();
                    $password=sha1($salt.$password);
                    $sql='insert into users
                            (user_name,salt,password)
                            values
                            (:username,:salt,:password)';
                     $pdo=dbConnection('write','pdo');
                     $stmt=$pdo->prepare($sql);
                     $stmt->bindParam(':username',$username,PDO::PARAM_STR);
                     $stmt->bindParam(':salt',$salt,PDO::PARAM_INT);
                     $stmt->bindParam(':password',$password,PDO::PARAM_STR);
                     $stmt->execute();
                     if($stmt->rowCount()==1)
                     {
                        $success='你已经注册成功！<a href="login.php">点击这里进行登录</a>';
                     }
                     elseif($stmt->errorCode()==23000)
                     {
                        $errors[0][]=$username.'-该用户名已经存在，请换一个用户名注册';
                     }
                     else
                     {
                        $errors[3][]='对不起！网站数据库有点问题，请稍后再试！';
                     }
         }
     }
	else
	{
	    $errors[2][]='请将注册信息填写完整';
	}	
}

require_once'inc/header.inc.php';
    if($success)
    {
        echo $success;
        exit;
    }
    require_once'inc/register.inc.php';
    
    require_once'inc/footer.inc.php';
?>