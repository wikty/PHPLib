<?php
$needDB=true;
require_once'inc/getdb.inc.php';
require'config/mysite.cfg.php';
session_start();
if(!isset($_SESSION[admin]))
{
    header("Location:$cfg_sitedir");
    exit;
}

if(!empty($_GET[action]))
{
	$action=$_GET[action];
	if($action=='logout')
	{
	    $_SESSION=array();
	    if(isset($_COOKIE[session_name()]))
	    {
   	         setcookie(session_name(),'',time()-86400,'/');
	    }
                    session_destroy();
	    header("Location:$cfg_sitedir");
	    exit;
	}
}
else
{
	header("Location:$cfg_sitedir");
	exit;
}
require_once'inc/header.inc.php';
$error='';
switch($action)
{
	case 'addcat':
	if(isset($_GET[error]) && $_GET[error]=='missing')
	{
	    if(isset($_GET[cat]))
	    {
	         $error.='�����������';
	     }
	     echo '<div class="error">'.$error.'</div>';
	}
		require_once'inc/addcat.inc.php';
	break;
	case 'addforum':
	if(isset($_GET[error]) && $_GET[error]=='missing')
	{
	    if(isset($_GET[cat]))
	    {
	        $error.='��ѡ��һ������'.'<br/>';
                    }
	    if(isset($_GET[name]))
	    {
	        $error.='����д�������'.'<br/>'; 
	    }
	    if(isset($_GET[desc]))
	    {
	         $error.='����д�԰�������'.'<br/>';
	    }
	    echo '<div class="error">'.$error.'</div>';
	}
		require_once'inc/addforum.inc.php';
	break;
}
require_once'inc/footer.inc.php';
?>