<?php
function dbConnection($userType,$conType='mysqli')
{
    $userType=strtolower($userType);
    $conType=strtolower($conType);
    require'config/mysite.cfg.php';

    if($userType=='write')
    {
        $user=$cfg_db_w_user;
        $password=$cfg_db_w_password;
    }
    elseif($userType=='read')
    {
        $user=$cfg_db_r_user;
        $password=$cfg_db_r_password;
    }
    else
    {
        die("database conncetion failed, please check connecting arg");
    }
    if($conType=='mysqli')
    {
        return new mysqli($cfg_db_host,$user,$password,$cfg_db_dbname);
    }
    elseif($conType=='pdo')
    {
        try
        {
            return new PDO("mysql:host=$cfg_db_host;dbname=$cfg_db_dbname",$user,$password);
        }
        catch(PDOException $e)
        {
            header('Location:error.php?error=1');
            exit;
        }
    }
    else
    {
        die("database conncetion failed, please check connecting arg");
    }
}
?>