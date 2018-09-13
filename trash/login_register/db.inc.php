<?php
define("USERDATAPATH", join(DIRECTORY_SEPARATOR, array('usersdata', 'usersdata.txt')));
function fetch_users()
{
    $usersdata=USERDATAPATH;
    $result = array();
    if(file_exists($usersdata)&&is_file($usersdata)&&is_readable($usersdata))
    {
        $usersinfo=file($usersdata);
        for($i=0;$i<count($usersinfo);$i++)
        {
    	    $user=explode(',',$usersinfo[$i]);
            // NOTICE: remove the space
            $result[] = array('username'=>trim($user[0]), 'password'=> trim($user[1]));
        }
    }
    return $result;
}
?>
