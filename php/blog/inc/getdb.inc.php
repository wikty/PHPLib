<?php
if($needDB===true)
{
    require_once'config/blog.cfg.php';
    $mysqli=new mysqli($cfg_db_host,$cfg_db_user,$cfg_db_password,$cfg_db_dbname);
    if($myslqi->errno)
    {
        throw new Exception('there is something wrong ,when construct mysqli');
    }
}
?>