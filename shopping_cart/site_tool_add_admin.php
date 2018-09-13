<?php
require_once'config/mysite.cfg.php';
require_once'inc/connection.inc.php';
require_once'inc/utility.inc.php';
require_once'class/my_encrypt.class.php';
require_once'class/my_checkpassword.class.php';
$missing=array();
$errors=array();
$usermin=8;
$requiredFields=array('username','password','rpassword');
if(isset($_POST[submit]))
{
	$missing=checkRFields($_POST,$requiredFields);
	if(empty($missing))
	{
		$password=$_POST[password];
		$rpassword=$_POST[rpassword];
		$username=$_POST[username];
		if(mb_strlen($username,'utf-8')<$usermin)
		{
			$errors['username'][]='username must least be '.$usermin;
		}
		if($password!=$rpassword)
		{
			$errors['password'][]='retype is not the same with password';
		}
		if(empty($errors))
		{
			$checkpwd=new my_checkpassword($password);
			if(!($checkpwd->check()))
			{
				if(!is_array($errors['password']))
				{
					$errors['password']=array();
				}
				$errors['password']=array_merge($errors['password'],$checkpwd->getMessage());
			}
			$sql='select password from admins where username=?';
			$mysqli=dbConnection('read','mysqli');
			$stmt=$mysqli->stmt_init();
			$stmt->prepare($sql);
			$stmt->bind_param('s',$username);
			$stmt->execute();
			$stmt->store_result();
			if($stmt->num_rows==0)
			{
				$myencrypt=new my_encrypt($password);
				$password=$myencrypt->getEncryptedData();
				$sql='insert into admins
						(username,password)
						values
						(?,?)';
				$stmt->prepare($sql);
				$stmt->bind_param('ss',$username,$password);
				$stmt->execute();
				$stmt->store_result();
				if($stmt->affected_rows==1)
				{
					echo 'add admin is successfully!';
					exit;
				}
				else
				{
					echo 'database is something wrong';
				}
			}
			else
			{
				$errors['username'][]='username is existed';
			}
		}
	}
}

?>
<!DOCTYPE html>
<html lang='en'>
<head>
<meta charset="utf-8" />
<title>
website admin
</title>
<style type="text/css">
.error{
color:Red;
}
label{
display:block;
}
</style>
</head>
<body>
<form action="" method="post">
            <div>
                <label for='username'>
                    <span class="error">*</span>Username:
                
<?php
        if($_POST && $missing && in_array('username',$missing))
        {
            echo '<span class="error">Plesae Enter Username</span>';
        }
        elseif($_POST && $errors && array_key_exists('username',$errors))
        {
            foreach($errors['username'] as $item)
            {
                echo '<span class="error">'.$item.'</span>';
            }
        }
?>
                </label>
                <input type='text' name='username' id='username' value='<?php
if($_POST && ($errors || $missing) && isset($_POST[username]))
    echo $_POST[username]; 

?>' />
            </div>
            <div>
                <label for='password'>
                    <span class="error">*</span>Password:
                
<?php
        if($_POST && $missing && in_array('password',$missing))
        {
            echo '<span class="error">Please Enter Password</span>';
        }
        elseif($_POST && $errors && array_key_exists('password',$errors))
        {
            foreach($errors['password'] as $item)
            {
                echo '<span class="error">'.$item.'</span>';
            }
        }
?>
                </label>
                <input type='password' name='password' id='password'  />
            </div>
            <div>
                <label for='rpassword'>
                    <span class="error">*</span>Retype Password:
                
<?php
        if($_POST && $missing && in_array('password',$missing))
        {
            echo '<span class="error">Please Retype Password</span>';
        }
        elseif($_POST && $errors && array_key_exists('rpassword',$errors))
        {
            foreach($errors['rpassword'] as $item)
            {
                echo '<span class="error">'.$item.'</span>';
            }
        }
?>
                </label>
                <input type='password' name='rpassword' id='rpassword' />
            </div>
            <div>
            <input type="submit" name="submit" value="submit" />
            </div>
            </form>
            </body></html>