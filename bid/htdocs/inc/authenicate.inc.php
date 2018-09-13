<?php
require_once(MYSQLI);
require_once'class/my_encrypt.class.php';
$sql='select password,timezone,user_id from users where username=?';
$dbc->autocommit(true);
$stmt=$dbc->stmt_init();
$stmt->prepare($sql);
$stmt->bind_param('s',$username);
$stmt->execute();
$stmt->bind_result($edpassword,$timezone,$userId);
$stmt->fetch();
if(!$edpassword)
{
    $errors['username']='this username is not register';
}
else
{
    $myencrypt=new my_encrypt($password);
    $myencrypt->setCheck($edpassword);
    $password=$myencrypt->getEncryptedData();
	if($password!=$edpassword)
    {
        $errors['password']='your typed password is not match';
    }
    else
    {
        $_SESSION[username]=$username;
        $_SESSION[timezone]=$timezone;
        $_SESSION[userId]=$userId;
        if(isset($_GET[frompage]))
        {
			$query=$_SERVER[QUERY_STRING];	
			header("Location:{$cfg_sitedir}{$_GET[frompage]}?{$query}");
			exit;
        }
        else
        {
			header("Location:$cfg_sitedir");
			exit;
		}
    }
}
?>