<?php
 include"inc/functions.php";
 include"../sys/cookie_data.php";
 if(is_administrator())
 {
    echo "you logged in";
 }
 else
 {
    echo $_COOKIE[$cookie_name];
 }
 
 ?>