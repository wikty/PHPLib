<?php
include_once"class.db_connect.inc.php";
 class Admin extends DB_Connect
 {
    private $_saltLength=7;
    public function __construct($db=null,$saltLength=null)
    {
        parent::__construct($db);
        if(is_int($saltLength))
        {
            $this->_saltLength=$saltLength;
        }
    }
    public function processLogInForm()
    {
        if($_POST['action']!="user_login")
        {
            return "Invalid action supplied for processedLoginForm";
        }
        $uname=htmlentities(strip_tags(trim($_POST['uname'])));
        $pword=htmlentities(strip_tags(trim($_POST['pword'])));
        
        $cmd="select user_id,user_name,user_pass,user_email from users
        where user_name=:uname";
        try
        {
            $ctrl=$this->db->prepare($cmd);
            $ctrl->bindParam(":uname",$uname,PDO::PARAM_STR);
            $ctrl->execute();
            $user=array_shift($ctrl->fetchAll(PDO::FETCH_ASSOC));
            $ctrl->closeCursor();
        }
        catch(Exception $e)
        {
            die($e->getMessage());
        }
        
        if(empty($user))
        {
            return "Unregister user can't login, please contract adminstrator";
        }
        
        $cpassword=$this->_getSaltedHash($pword,$user['user_pass']);
        if($cpassword!=$user['user_pass'])
        {
            return "you password incorrectly";
        }
        else
        {
            $_SESSION['user']=array(
            'id'=>$user['user_id'],
            'name'=>$user['user_name'],
            'email'=>$user['user_email']
            );
            return true;
        }
    }
    private function _getSaltedHash($string,$salt=null)
    {
        if(empty($salt))
        {
            $salt=substr(md5(time()),0,$this->_saltLength);
        }
        else
        {
            $salt=substr($salt,0,$this->_saltLength);
        }
        
        return $salt.sha1($salt.$string);
    }
   /* public function testSalt($string,$salt=null)
    {
        return $this->_getSaltedHash($string,$salt);
    }*/
    public function processLogOut()
    {
        if($_POST['action']!="user_logout")
        {
            return "you action is not user logout ";
        }
        session_destroy();
        return true;
    }
 }
 
 ?>