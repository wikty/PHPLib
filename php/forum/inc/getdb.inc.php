<?php
//if page need database,please define var $needD=true before include getdb.inc.php.
if($needDB===true)
{
    require'config/mysite.cfg.php';
    $mysqli=new mysqli($cfg_db_host,$cfg_db_user,$cfg_db_password,$cfg_db_dbname);
    $mysqli->query('set names "'.$cfg_db_charset.'"');
    if($myslqi->errno)
    {
        throw new Exception('there is something wrong ,when construct mysqli');
    }
}
?>