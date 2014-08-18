<?php
require_once'inc/connection.inc.php';
require_once'class/my_encrypt.class.php';
$pdo=dbConnection('read','pdo');
$sql='select password from users where username=:username';
$stmt=$pdo->prepare($sql);
$stmt->bindParam(':username',$username,PDO::PARAM_STR);
$stmt->execute();
$edpassword=$stmt->fetchColumn();
$stmt->closeCursor();
if(!$edpassword)
{
    $errors['username']='this username is not register';
}
else
{
    $myencrypt=new my_encrypt($password);
    $myencrypt->setCheck($edpassword);
    $password=$myencrypt->getEncryptedData();
    $sql='select username,customer_id from users where username=:username and password=:password';
    $stmt=$pdo->prepare($sql);
    $stmt->bindParam(':username',$username,PDO::PARAM_STR);
    $stmt->bindParam(':password',$password,PDO::PARAM_STR);
    $stmt->execute();
    if($stmt->rowCount()!=1)
    {
        $errors['password']='your typed password is not match';
    }
    else
    {
        $row=$stmt->fetchObject();
        $_SESSION[username]=$row->username;
        $_SESSION[customerid]=$row->customer_id;
        $sql='select id from orders where status<2';
        $results=$pdo->query($sql);
        if($results->rowCount()==1)
        {
			$row=$results->fetch();
			$_SESSION[orderid]=$row[id];
        }
        header("Location:$cfg_sitedir");
        exit;
    }
}
?>