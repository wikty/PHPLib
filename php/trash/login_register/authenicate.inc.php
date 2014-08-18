<?php
//$users like: array(array('username'=>'xiao','password'=>'jk93l'), array()...)
function authenicate($users, $username, $password)
{
    foreach($users as $userinfo)
    {
        if($username==$userinfo['username']&&$password==$userinfo['password'])
        {
            return true;
        }
    }
    return false;
}
?>
