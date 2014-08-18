<?php
require_once'inc/connection.inc.php';
$pdo=dbConnection('read','pdo');
$sql='select user_name from users2ways where user_name=:username 
        and password=aes_encrypt(:password,:key)';
$stmt=$pdo->prepare($sql);
$stmt->bindParam(':username',$username,PDO::PARAM_STR);
$stmt->bindParam(':password',$password,PDO::PARAM_STR);
$stmt->bindParam(':key',$cfg_db_key,PDO::PARAM_STR);
$stmt->execute();
if($stmt->rowCount()==1)
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