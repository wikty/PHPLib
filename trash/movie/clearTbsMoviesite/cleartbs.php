<?php
    include'author.php';
    $sv=mysql_connect($host,$user,$psd)or
    die('Unable to connect database, please check you input parameters.');
    mysql_select_db('moviesite',$sv)or die(mysql_error($sv));
    $cmd='DELETE FROM movie';
    mysql_query($cmd,$sv)or die(mysql_error($sv));
    $cmd='DELETE FROM movietype';
    mysql_query($cmd,$sv)or die(mysql_error($sv));
    $cmd='DELETE FROM moviepeople';
    mysql_query($cmd,$sv)or die(mysql_error($sv));
    $cmd='delete from reviews';
    mysql_query($cmd,$sv) or die(mysql_error($sv));
    echo 'clear all tables.';
?>