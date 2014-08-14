<?php

// function _encrypt_function($original_data, $encrypted_data)
// {
// 	if($original_data==$encrypted_data)
// 	{
// 		return true;
// 	}
// 	return false;
// }

//$users like: array(array('username'=>'xiao','password'=>'jk93l'), array()...)
function authenicate($users, $username, $password)
{
    foreach($users as $userinfo)
    {
        if($username==$userinfo['username'] && $password==$userinfo['password'])
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
