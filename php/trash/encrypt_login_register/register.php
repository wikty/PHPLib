<?php
///////////////////////////////////////////////////////////////////////////
/////////////////define class my_checkpassword
class my_checkpassword
{
    protected $_password;
    protected $_minimumChars;
    protected $_mixedCase=false;
    protected $_allowSpaces=false;
    protected $_minimumNumbers=0;
    protected $_minimumSymbols=0;
    protected $_errors=array();
    
    public function __construct($password,$numChars=8)
    {
        if(!isset($password))
        {
            throw new Exception('my_checkpassword class constrcut should have password arg.');
        }
        
        $this->_password=$password;
        $this->_minimumChars=$numChars;
    }
    public function allowSpaces()
    {
        $this->_allowSpaces=true;
    }
    public function requireMixedCase()
    {
        $this->_mixedCase=true;
    }
    public function requireNumbers($num=1)
    {
        if(is_numeric($num) && $num>0)
        {
            $this->_minimumNumbers=(int)$num;
        }
        else
        {
            $this->_errors[]='requireNumbers arg must be a positive integer.';
        }
    }
    public function requireSymbols($num=1)
    {
        if(is_numeric($num) && $num>0)
        {
            $this->_minimumSymbols=(int)$num;
        }
        else
        {
            $this->_errors[]='requireSymbols arg must be a positive integer.';
        }
    }
    public function check()
    {
        $password=$this->_password;
        if(strlen($password)<$this->_minimumChars)
        {
            $this->_errors[]="Password must be at least {$this->_minimumChars} characters.";
        }
        if(!($this->_allowSpaces))
        {
            $pattern='/\s/';
            if(preg_match($pattern,$password))
            {
                $this->_errors[]='Password cannot contain spaces';
            }
        }
        if($this->_mixedCase)
        {
            $pattern='/(?=.*[a-z])(?=.*[A-Z])/';
            if(!preg_match($pattern,$password))
            {
                $this->_errors[]='Password must be include uppercase and lowercase.';
            }
        }
        if($this->_minimumNumbers)
        {
            $pattern='/\d/';
            $found=preg_match_all($pattern,$password,$matches);
            if($found < $this->_minimumNumbers)
            {
                $this->_errors[]="Password must be at least include $this->_minimumNumbers number(s).";
            }
        }
        if($this->_minimumSymbols)
        {
            $pattern='/[-!$%^&*(){}<>[\]\'".|#@:;,?+_=\/\~]/';
            $found=preg_match_all($pattern,$password,$matches);
            if($found < $this->_minimumSymbols)
            {
                $this->_errors[]="Password must be at least include $this->_minimumSymbols symbol(s).";
            }
        }
         return $this->_errors ? false:true;
    }
    public function getMessage()
    {
        return $this->_errors;
    }
}
//////////////////////////////////////////////////////
//////////////end of define class my_checkpassword
///////////////////////////////////////////////////////////////
///////////////define function checkUser  saveUser
function checkUser($dataPath,$username)
{
    $checkResult=array();
    $existed=false;
    if(is_file($dataPath)&&is_readable($dataPath))
    {
        $usersinfo=file($dataPath);
        for($i=0;$i<count($usersinfo);$i++)
        {
            $user=explode(',',$usersinfo[$i]);
            if(trim($user[0])==$username)
            {   
                $existed=true;
                $checkResult[0]=false;
                $checkResult[1]='username existed.';
                break;
            }
        }
        if($existed===false)
        {
            $checkResult[0]=true;
            $checkResult[1]=true;
        }
        
    }
    else
    {
        $checkResult[0]=false;
        $checkResult[1]='userdata file cannot be read.';
    }
    return $checkResult;
}
function saveUser($dataPath,$username,$password)
{
    if(is_file($dataPath) && is_writable($dataPath))
    {
        if(empty($username)||empty($password))
        {
            return false;
        }
        else
        {
            $mystr=PHP_EOL.$username.','.$password;
            $hf=fopen($dataPath,'a+');
            fwrite($hf,$mystr);
            fclose($hf);
            return true;
        }
    }
    else
    {
        return false;
    }
}
////////////////////////////////////////////////////////
///////////end of define functions checkUser and saveUser
require_once'config/mysite.cfg.php';
$error=array();
$usernameminimum='8';
$usersdata=realpath('usersdata/usersdata.txt');
$myform=array('username'=>'name','password'=>'pwd','rpassword'=>'rpwd','submit'=>'reg');
if(isset($_POST[$myform['submit']]))
{
	if(!empty($_POST[$myform['username']])&&!empty($_POST[$myform['password']])
	    &&!empty($_POST[$myform['rpassword']]))
	{
	    $username=$_POST[$myform['username']];
	    $password=$_POST[$myform['password']];
	    if(strlen($username)<$usernameminimum)
        {
             $error[]="username length at least be $usernameminimum.";
        }
        if(preg_match('/\s/',$username))
        {
            $error[]='username cannot include spaces.';
        }
        if($_POST[$myform['password']]!=$_POST[$myform['rpassword']])
        {
            $error[]='retype password is not same with password.';
        }
//base information check end here 
        if(empty($error))
        {
            $checkUser=checkUser($usersdata,$username);
            if($checkUser[0])
            {
                $checkpwd=new my_checkpassword($password);
                 //$checkpwd->allowSpaces();
                 //$checkpwd->requireMixedCase();
                 //$checkpwd->requireNumbers(3);
                 //$checkpwd->requireSymbols();
                $pwdOK=$checkpwd->check();
                if($pwdOK)
                {
                    require_once'class/my_encrypt.class.php';
                    $encrypt=new my_encrypt($password);
                    $password=$encrypt->getEncryptedData();
                    $OK=saveUser($usersdata,$username,$password);
                    if($OK)
                    {
                        $success='you register successfully';
                    }
                    else
                    {
                        $error[]='there is something wrong with our site , please try later.';
                    }
                }
                else
                {
                    $error=$checkpwd->getMessages();
                }
            }
            else
            {
                $error[]=$checkUser[1];
            }
        }
     }
	else
	{
	    $error[]='please completable information.';
	}	
}

require_once'inc/header.inc.php';
    if($success)
    {
        echo $success.'now to login<a href="login.php">LogIn</a>';
    }
    else
    {
        echo "<ol>";
        foreach($error as $item)
        {
            echo "<li>$item</li>";
        }
        echo "</ol>";
    }
    require_once'inc/register.inc.php';
    require_once'inc/footer.inc.php';
?>