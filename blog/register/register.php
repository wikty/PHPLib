<?php
require_once'../config/blog.cfg.php';
$error=array();
$homepage='../index.php';
$success="";
$mysqli=new mysqli($cfg_db_host,$cfg_db_user,$cfg_db_password,$cfg_db_dbname);
if(isset($_POST['submit']))
{
	if(!empty($_POST['username'])&&!empty($_POST['password'])&&!empty($_POST['rpassword']))
	{
	    if($_POST['password']==$_POST['rpassword'])
	    {
	        $username=$_POST['username'];
	        $password=$_POST['password'];
	        require_once"my_checkpassword.class.php";
            require_once"processuser.php";
            $result=checkUsername($mysqli,$username);
            $usernameOK=$result[0];
            $checkpwd=new my_checkpassword($password);
            //$checkpwd->allowSpaces();
            //$checkpwd->requireMixedCase();
            //$checkpwd->requireNumbers(3);
            //$checkpwd->requireSymbols();
            $pwdOK=$checkpwd->check();
            if($usernameOK && $pwdOK)
            {
                $OK=saveUser($mysqli,$username,$password);
                if($OK)
                {
                    //$success='you are already a register user.';
                    session_start();
                    $_SESSION['username']=$username;
                    $_SESSION['password']=$password;
                    header("Location:$homepage");
                    exit;
                }
                else
                {
                    $error[]='when save user information ,there is something wrong.';
                }
            }
            elseif(!$usernameOK && !$pwdOK)
            {
                $error[]=$result[1];
                $error=array_merge($error,$checkpwd->getMessage());
            }
            elseif(!$usernameOK)
            {
                $error[]=$result[1];
            }
            else
            {
                $error=array_merge($error,$checkpwd->getMessage());
            }
	    }
	    else
	    {
	        $error[]='retype password is not same to password';
	    }
	}
	else
	{
	    $error[]='please input username ,password and retype password';
	}	
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" >
    <head>
        <title>
            <?php echo $cfg_sitename; ?>
        </title>
        <link type='text/css' rel='stylesheet' href="
            <?php echo $cfg_sitedir.$cfg_css_path.'stylesheet.css'; ?>">
        </link>
    </head>
    <body>
        <div id='header'>
            <h1>
                <?php echo $cfg_sitename; ?>
            </h1>
        </div>
        <div id='menu'>
            <a href='../index.php'>Home</a>&bull;
            <a href='../viewcat.php?all=true'>Categories</a>&bull;
            <a href='../login.php'>Login</a>
        </div>
        <div id='container'>
            <div id='main'>
<?php
if(isset($error))
{
    echo "<ol>";
    foreach($error as $item)
    {
        echo "<li>$item</li>";
    }
    echo "</ol>";
}
?>
<form action='' method='post' class='myform'>
    <fieldset>
        <legend>Register&nbsp;:&nbsp;</legend>
        <label for='name'>Name:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
        <input type='text' name='username' id='username' /><br/><br/>
        <lable for='password'>Password:</label>
        <input type='password' name='password' id='password' /><br/><br/>
        <lable for='rpassword'>Retype&nbsp;Password:</label>
        <input type='password' name='rpassword' id='rpassword' /><br/><br/>
        <input type='submit' name='submit' value='Register' />
    </fieldset>
</form>
<?php
require_once'../inc/footer.inc.php';
?>