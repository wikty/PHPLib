<?php
function checkUsername($dataPath,$username)
{
    $checkResult=array();
    $existed=false;
    if(is_file($dataPath)&&is_readable($dataPath))
    {
        $usersinfo=file($dataPath);
        for($i=0;$i<count($usersinfo);$i++)
        {
            $user=explode(',',$usersinfo[$i]);
            if(trim($user[0])==$username)
            {   
                $existed=true;
                $checkResult[0]=false;
                $checkResult[1]='username existed.';
                break;
            }
        }
        if($existed===false)
        {
            $checkResult[0]=true;
            $checkResult[1]=true;
        }
        
    }
    else
    {
        $checkResult[0]=false;
        $checkResult[1]='userdata file cannot be read.';
    }
    return $checkResult;
}
function saveUser($dataPath,$username,$password)
{
    if(is_file($dataPath) && is_writable($dataPath))
    {
        if(empty($username)||empty($password))
        {
            return false;
        }
        else
        {
            $mystr=PHP_EOL.$username.','.$password;
            $hf=fopen($dataPath,'a+');
            fwrite($hf,$mystr);
            fclose($hf);
            return true;
        }
    }
    else
    {
        return false;
    }
}
?>