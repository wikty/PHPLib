<?php
require_once'config/mysite.cfg.php';
if(! $_SESSION)
{
    session_start();
}
$timenow=time();
if($_SESSION['time']+$cfg_sessionlifetime < $timenow)
{
    $_SESSION=array();
    if(isset($_COOKIE[session_name()]))
    {
        setcookie(session_name(),'',time()-86400,'/');
    }
    session_destroy();
    header("Location:{$cfg_sitedir}?sess_timeout=yes");
    //要将会话超时的信息反馈给用户，需要考虑index.php检测会话将用户重定向到longin页面的情况
    //超时重定向要与普通未登录重定向有所区别，所以gologin根据是否有sess_timeout来决定是否
    //向login页面传递一个会话超时标志
    exit;
}
else
{
    $_SESSION['time']=time();
}
?>