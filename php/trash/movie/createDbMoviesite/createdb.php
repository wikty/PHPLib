<?php
    include'author.php';
    $sv=mysql_connect($host,$user,$psd)or
    die('Unable to connect, please check you connection parameters.');
    $cmd='CREATE DATABASE IF NOT EXISTS moviesite';
    mysql_query($cmd,$sv)or die(mysql_error($sv));
     echo "moviesite database succfully created!";
?>