<?php
require_once'config/mysite.cfg.php';
//if page need database,please define var $needD=true before include header.inc.php.
require_once'inc/getdb.inc.php';
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" 
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" >
<head>
<meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=gb2312" />
    <title><?php echo $cfg_sitename; ?></title>
    <link type='text/css' rel='stylesheet' href="<?php echo $cfg_css_path.'stylesheet.css'; ?>">
    </link>
</head>
<body>
    <div id='header'>
        <h1><?php echo $cfg_sitename; ?></h1>
    </div>
    <div id='menu'>
    <a href='index.php'>[Home]&nbsp;</a>
    <?php
    if(isset($_SESSION[username]) && isset($_SESSION[password]))
    {
        echo '<a href="logout.php">[LogOut]</a>';
    }
    else
    {
        echo "<a href='login.php'>[LogIn]&nbsp;</a>";
        echo "<a href='register.php'>[Register]&nbsp;</a>";
        echo "<a href='addtopic.php'>[NewTopic]</a>";
    }
    ?>
    
    </div>
    <div id='container'>
        <div id='main'>
    