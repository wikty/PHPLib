<?php
    include'author.php';
    $con=mysql_connect($host,$user,$psd)or
    die('Unable to connect, please check you connection parameters.');
    $cmd='CREATE DATABASE IF NOT EXISTS calendar';
    mysql_query($cmd,$con)or die(mysql_error($con));
     echo "calender database succfully created!";
?>