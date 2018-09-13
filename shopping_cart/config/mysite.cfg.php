<?php
//////////////////////////////
//////database information
$cfg_db_host='localhost';
$cfg_db_r_user='root';
$cfg_db_w_user='root';
$cfg_db_r_password='123456789';
$cfg_db_w_password='123456789';
$cfg_db_dbname='mycart';
///////////////////////////////////
///site base information
$cfg_sessionlifetime=60*2;  //2 mins
$cfg_siteloginpage='login.php';
$cfg_sitepath=dirname($_SERVER[PHP_SELF]).'/';
$cfg_sitedir='http://'.$_SERVER[HTTP_HOST].$cfg_sitepath;
$cfg_sitename='Speed Cart';
$cfg_siteauthor='xiaowenbin';
$cfg_siteadmin='xiaowenbin';
$cfg_siteadminemail='xiaowenbin_999@163.com';
///////////////////////////////////////
////resource
$cfg_rs_imagepath='images/';
//////////////////////////////////
////locale
$cfg_locale_money='$';
?>