<?php
define("USERDATAPATH", APP_DATA_DIR.'usersdata.txt');

function fetch_users($dataPath=USERDATAPATH)
{
    $result = array();
    if(file_exists($dataPath)&&is_file($dataPath)&&is_readable($dataPath))
    {
        $usersinfo=file($dataPath);
        for($i=0;$i<count($usersinfo);$i++)
        {
    	    $user=explode(',',$usersinfo[$i]);
    	    //NOTICE: You must remove newline
            $result[] = array('username'=>trim($user[0]), 'password'=> trim($user[1]));
        }
    }
    return $result;
}

function user_existed($username, $dataPath=USERDATAPATH)
{
    if(!file_exists($dataPath))
    {
        touch($dataPath);
        return false;
    }

    if(is_file($dataPath)&&is_readable($dataPath))
    {
        $usersinfo=file($dataPath);
        for($i=0;$i<count($usersinfo);$i++)
        {
            $user=explode(',',$usersinfo[$i]);
            if(trim($user[0])==$username)
            {   
                return true;
            }
        }
        return false;
    }
    else
    {
        throw new Exception("$dataPath is not readable");
    }
}

function user_save($username,$password,$dataPath=USERDATAPATH)
{
    if(!file_exists($dataPath))
    {
        touch($dataPath);
    }
    
    if(is_file($dataPath) && is_writable($dataPath))
    {
        if(empty($username)||empty($password))
        {
            return false;
        }
        else
        {
            $userinfo=$username.','.$password.PHP_EOL;
            $hf=fopen($dataPath,'a+');
            fwrite($hf,$userinfo);
            fclose($hf);
            return true;
        }
    }
    else
    {
        throw new Exception("$dataPath is not writable");
    }
}
?>
