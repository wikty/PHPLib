<?php
require_once'inc/connection.inc.php';
$pdo=dbConnection('read','pdo');
$sql='select salt,password from users where user_name=:username';
$stmt=$pdo->prepare($sql);
$stmt->bindParam(':username',$username,PDO::PARAM_STR);
$stmt->bindColumn(1,$salt);
$stmt->bindColumn(2,$edpassword);
$stmt->execute();
$stmt->fetch();
if(sha1($salt.$password)==$edpassword)
{
    $_SESSION['authenicated']='ok';
    $_SESSION['time']=time();
    header("Location:$cfg_sitedir");
    exit;
}
else
{
    $errors[]='你不是注册用户';
}
?>