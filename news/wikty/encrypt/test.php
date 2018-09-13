<?php
require_once'my_encrypt.class.php';
$password='asdfghjkl999';
$edpassword='iB+n9ce2b6ce0c565c2b918277eb695313f6df85f0e9';
$encrypt=new my_encrypt($password);
$encrypt->setCheck($edpassword);
$newpassword=$encrypt->getEncryptedData();
if($newpassword==$edpassword)
{
echo 'match';
}
else
{
echo 'not match';
}
?>