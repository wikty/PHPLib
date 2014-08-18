<?php 
include_once"../sys/core/init.inc.php";
$test=new Admin($db);
echo $test->testSalt("123456789"),"<br/>";
sleep(2);
echo $my=$test->testSalt("xiao"),"<br/>";
sleep(1);
echo $test->testSalt("xiao",$my);

 
 ?>