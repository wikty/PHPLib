<?php
session_start();
require_once'config/mysite.cfg.php';
require_once'inc/utility.inc.php';
$errors=array();
$missing=array();
$usermin=8;
$requiredFields=array('username','password','rpassword','surname','name','addr1','postcode', 'phone');
$optionalFields=array('addr2','addr3','email');

if(isset($_POST[submit]))
{
    $missing=checkRFields($_POST,$requiredFields);
	if(empty($missing))
	{
        extract($_POST);
        if(!isset($addr2))
            $addr2='';
        if(!isset($addr3))
            $addr3='';
        if(!isset($email))
            $email='';
	    if(mb_strlen($username,'utf-8')<$usermin)
        {
             $errors['username'][]="username length at least $usermin";
        }
        if(preg_match('/\s/',$username))
        {
            $errors['username'][]='username cannot include spaces';
        }
        if($password!=$rpassword)
        {
            $errors['rpassword'][]='retype password is not same with password';
        }
//basic check end here 
        if(empty($errors))
        {
                require_once'class/my_checkpassword.class.php';
                $checkpwd=new my_checkpassword($password);
                 //$checkpwd->allowSpaces();
                 //$checkpwd->requireMixedCase();
                 //$checkpwd->requireNumbers(3);
                 //$checkpwd->requireSymbols();
                $pwdOK=$checkpwd->check();
                if(!$pwdOK)
                {
                    if(!isset($errors['password']))
                    {
                        $errors['password']=array();
                    }
                    $errors['password']=array_merge($errors['password'],$checkpwd->getMessage());
                }
                else
                {
                    require_once'class/my_encrypt.class.php';
                    $encrypt=new my_encrypt($password);
                    $password=$encrypt->getEncryptedData();
                    require_once'inc/connection.inc.php';
                    $pdo=dbConnection('write','pdo');
                    $sql='select count(id) from users where username=:username';
                    $stmt=$pdo->prepare($sql);
                    $stmt->bindParam(':username',$username,PDO::PARAM_STR);
                    $stmt->execute();
                    $num_row=$stmt->fetchColumn();
                    if($num_row!=0)
                    {
                        $error['username'][]='username is existed';
                    }
                    else
                    {
                        $sql='insert into customers
                                (surname,name,addr1,addr2,addr3,postcode,phone,email)
                                values
                                (:surname,:name,:addr1,:addr2,:addr3,:postcode,:phone,:email)';
                        $stmt=$pdo->prepare($sql);
                        $stmt->bindParam(':surname',$surname,PDO::PARAM_STR);
                        $stmt->bindParam(':name',$name,PDO::PARAM_STR);
                        $stmt->bindParam(':addr1',$addr1,PDO::PARAM_STR);
                        $stmt->bindParam(':addr2',$addr2,PDO::PARAM_STR);
                        $stmt->bindParam(':addr3',$addr3,PDO::PARAM_STR);
                        $stmt->bindParam(':postcode',$postcode,PDO::PARAM_STR);
                        $stmt->bindParam(':phone',$phone,PDO::PARAM_STR);
                        $stmt->bindParam(':email',$email,PDO::PARAM_STR);
                        $stmt->execute();
                        $customerid=$pdo->lastInsertId();
                        $sql='insert into users
                                (username,password,customer_id)
                                values
                                (:username,:password,'.$customerid.')';
                       $stmt=$pdo->prepare($sql);
                       $stmt->bindParam(':username',$username,PDO::PARAM_STR);
                       $stmt->bindParam(':password',$password,PDO::PARAM_STR);
                       $stmt->execute();
                       if($stmt->rowCount()==1)
                       {
                            echo '<div>you registering is successfully,if you want log in, <a href="login.php">please
                            click here</a>';
                            exit;
                       }
                       else
                       {
                            $errors['special'][]='there is something wrong with our site , please try later';
                       }
                    }
               }//end  password ok
        }//end basic check
     }//end if(empty($missing)
}

require_once'inc/header.inc.php';

require_once'inc/register.inc.php';

require_once'inc/footer.inc.php';
?>