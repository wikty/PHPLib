<?php
require_once'../db/connection.inc.php';
$mysqli=dbConnection('read','mysqli');
$sql='select * from users where username=?';
$stmt=$mysqli->stmt_init();
$stmt->prepare($sql);
$stmt->bind_param('s',$username);
$stmt->execute();
$stmt->bind_result($fetch_id,$fetch_name,$fetch_pwd,$fetch_level);
$stmt->fetch();
if(!$fetch_id)
{
    $errors['username']='this username is not register';
}
else
{
    if($fetch_pwd!=md5($password))
    {
		$errors['password']='your typed password is not match';
    }
    else
    {
        $_SESSION[username]=$fetch_name;
        $_SESSION[userid]=$fetch_id;
        $_SESSION[userlevel]=$fetch_level;
        header("Location:$cfg_sitedir");
        exit;
    }
}
?>