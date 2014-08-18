<?php
include 'author.php';
$sv=mysql_connect($host,$user,$psd) or
die('unable to connect . check your connection parameters');
mysql_select_db('test',$sv) or die(mysql_error($sv));
?>