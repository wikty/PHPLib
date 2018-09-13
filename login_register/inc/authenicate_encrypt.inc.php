<?php
// Dependency:
// inc/slat_encrypt.class.inc.php
//
//$users like: array(array('username'=>'xiao','password'=>'jk93l'), array()...)
function authenicate($users, $username, $password)
{
	$check=new SlatEncrypt();
    foreach($users as $userinfo)
    {
        if($username==$userinfo['username'] &&  $check->validate($password, $userinfo['password']))
        {
            return true;
        }
    }
    return false;
}

function is_authenicated($authenicate_key)
{
	if(!isset($_SESSION))
	{
	    session_start();
	}
	if(isset($_SESSION[$authenicate_key]))
	{
		return true;
	}
	return false;
}
?>
