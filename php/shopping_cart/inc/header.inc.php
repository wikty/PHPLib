<?php
require_once'config/mysite.cfg.php';
require_once'inc/connection.inc.php';
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset='utf-8' />
        <title>
            <?php
            $currentpage=basename($_SERVER[SCRIPT_NAME],'.php');
            if($currentpage=='index')
                $currentpage='home';
            echo ucfirst($currentpage);
            ?>
        </title>
        <link href="css/admin.css" rel="stylesheet" type="text/css"></link>
        <style type="text/css">
        </style>
    </head>
   <body>
   
    <div id='header'>
        <h1>极速购物</h1>
    </div>
    
    <div id='menu'>
    <ul>
        <li><a href="<?php echo $cfg_sitedir; ?>">首页</a></li>
        <li><a href="showbasket.php">我的购物车</a></li>
        <?php
        if(!isset($_SESSION[username]))
        {
            echo '<li><a href="'.$cfg_sitedir.'login.php'.'">登录</a></li>';
        }
        else
        {
            echo '<li><a href="'.$cfg_sitedir.'logout.php'.'">退出</a></li>';
        }
        ?>
        <li><a href="<?php echo $cfg_sitedir.'register.php'; ?>">注册</a></li>
     </ul>
    </div>
    
    <div id='container'>
    
        <div id='bar'>
        <?php require"inc/bar.inc.php"; ?>
        </div>
        
        <div id='main'>