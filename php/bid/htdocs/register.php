<?php
session_start();
require_once'../mysite.cfg.php';
require_once'inc/utility.inc.php';
$errors=array();
$missing=array();
$usermin=8;
//should add input for timezone,but i cannot get timezone data table
//so assume utc is time+00:00 and user timezone is +08:00,differ 8 hours.
$requiredFields=array('username','password','rpassword','surname','name','addr1','postcode', 'phone');
$optionalFields=array('addr2','addr3','email');

if($_SERVER['REQUEST_METHOD'] == 'POST')
{
    $missing=checkRFields($_POST,$requiredFields);
	if(empty($missing))
	{
        extract($_POST);
        $timezone='+08:00';
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
                    require_once(MYSQLI);
                    //require_once 'MYSQLI';
                    $dbc->autocommit(false);
                    $sql='insert into delivery_addresses
								(surname,name,addr1,addr2,addr3,phone,postcode,email)
								values
								(?,?,?,?,?,?,?,?)';
					$stmt=$dbc->stmt_init(); 
					$stmt->prepare($sql);
					$stmt->bind_param('ssssssss',$surname,$name,$addr1,$addr2,$addr3,$phone,$postcode,$email);
                    $stmt->execute();
					$deliveryId=$stmt->insert_id;
                   // $stmt->close();
                    $sql='insert into users
								(username,password,delivery_address_id,timezone)
								values
								(?,?,'.$deliveryId.',?)';
                    $stmt->prepare($sql);
                    $stmt->bind_param('sss',$username,$password,$timezone);
                    $stmt->execute();
                    if($stmt->errno==1062)
                    {
						$dbc->rollback();
                        $error['username'][]='username is existed';
                    }
                    else
                    {
                       if($stmt->affected_rows)
                       {
							$dbc->commit();
                            echo '<div>you registering is successfully,if you want log in, <a href="login.php">please
                            click here</a>';
                            exit;
                       }
                       else
                       {	
							$dbc->rollback();
                            $errors['special'][]='there is something wrong with our site , please try later';
                       }
                    }
                    $dbc->close();
               }//end  password ok
        }//end basic check
     }//end if(empty($missing)
}
$page_title='Register';
$stylesheets=array('main.css');
$scripts=array('utility.js');
require_once'inc/header.inc.php';
require_once'inc/register.inc.php';
require_once'inc/footer.inc.php';
?>