<?php
require_once'class/my_encrypt.class.php';
$encrypt=new my_encrypt($password);
if(file_exists($usersdata)&&is_file($usersdata)&&is_readable($usersdata))
{
    $usersinfo=file($usersdata);
    for($i=0;$i<count($usersinfo);$i++)
    {
	    $user=explode(',',$usersinfo[$i]);
	    $encrypt->setCheck(rtrim($user[1]));
	    $password=$encrypt->getEncryptedData();
	    if($username==trim($user[0])&&$password==rtrim($user[1]))
	    {
		    $_SESSION['authenicated']='ok';
		    $_SESSION['time']=time();
            header("Location:$cfg_sitedir");
	        exit;
	    }
    }
} 
else
{
    $errors[]='something wrong,please try agin later.';
}
?>