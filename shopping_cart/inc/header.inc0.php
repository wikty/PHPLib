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
        <h1><?php echo $cfg_sitename; ?></h1>
    </div>
    
    <div id='menu'>
    <ul>
        <li><a href="<?php echo $cfg_sitedir; ?>">Home</a></li>
        <li><a href="showbasket.php">MyCart</a></li>
        <?php
        if(!isset($_SESSION[username]))
        {
            echo '<li><a href="'.$cfg_sitedir.'login.php'.'">LogIn</a></li>';
        }
        else
        {
            echo '<li><a href="'.$cfg_sitedir.'logout.php'.'">LogOut</a></li>';
        }
        ?>
        <li><a href="<?php echo $cfg_sitedir.'register.php'; ?>">Register</a></li>
     </ul>
    </div>
    
    <div id='container'>
    
        <div id='bar'>
        <?php require"inc/bar.inc.php"; ?>
        </div>
        
        <div id='main'>