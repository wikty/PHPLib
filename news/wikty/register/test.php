<?php
include"my_checkpassword.class.php";
$check=new my_checkpassword('as');
if($check->check())
{
	echo 'ok';
	echo $check->test_getPasswordAndMinimumChars();
}
else
{
	
print_r($check->getMessage());
}
?>