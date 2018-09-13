<?php
//////////////////////////////
//////database information
$cfg_db_host='localhost';
$cfg_db_r_user='psread';
$cfg_db_w_user='pswrite';
$cfg_db_r_password='psread';
$cfg_db_w_password='pswrite';
$cfg_db_dbname='phpsols';
///////////////////////////////////
///site base information
$cfg_sessionlifetime=60*2;  //2 mins
$cfg_siteloginpage='login.php';
$cfg_sitedir='http://'.$_SERVER[HTTP_HOST].dirname($_SERVER[PHP_SELF]);
?>