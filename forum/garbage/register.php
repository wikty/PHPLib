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
            $this->_errors[]="密码至少要有{$this->_minimumChars}个字符";
        }
        if(!($this->_allowSpaces))
        {
            $pattern='/\s/';
            if(preg_match($pattern,$password))
            {
                $this->_errors[]='密码中不能有空格';
            }
        }
        if($this->_mixedCase)
        {
            $pattern='/(?=.*[a-z])(?=.*[A-Z])/';
            if(!preg_match($pattern,$password))
            {
                $this->_errors[]='密码要同时包含有大小写字母';
            }
        }
        if($this->_minimumNumbers)
        {
            $pattern='/\d/';
            $found=preg_match_all($pattern,$password,$matches);
            if($found < $this->_minimumNumbers)
            {
                $this->_errors[]="密码中至少要有{$this->_minimumNumbers}个数字字符";
            }
        }
        if($this->_minimumSymbols)
        {
            $pattern='/[-!$%^&*(){}<>[\]\'".|#@:;,?+_=\/\~]/';
            $found=preg_match_all($pattern,$password,$matches);
            if($found < $this->_minimumSymbols)
            {
                $this->_errors[]="密码中至少要有{$this->_minimumSymbols}个特殊字符（即除数字字母之外的字符）";
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
//////////////////////////////////////////////////////////////////////////
//Define Function checkUsername,saveUser,
function checkUser($db,$sql)
{
    $results=$db->query($sql);
    $num_rows=$results->num_rows;
    $checkResult=array();
    if($num_rows)
    {  
        $checkResult[0]=false;
        $checkResult[1]='用户名已经被注册，请换一个用户名继续注册';
    }
    else
    {
        $checkResult[0]=true;
        $checkResult[1]=true;
    }
    return $checkResult;
}
function saveUser($db,$sql)
{
    if(isset($db))
    {
        $results=$db->query($sql);
        //should do something check
        return $db->insert_id;
    }
    else
    {
        return false;
    }
}
//End Define Function
/////////////////////////////////////////////////////////////////////////

$needDB=true;
require_once'inc/header.inc.php';
$error=array();
$homepage='index.php';
$success="";

if(isset($_POST['submit']))
{
//should be modified
	if(!empty($_POST['username'])&&!empty($_POST['password'])&&!empty($_POST['rpassword'])&&
	    !empty($_POST['email']))
	{
	    if($_POST['password']==$_POST['rpassword'])
	    {
	        $username=$_POST['username'];
	        $password=$_POST['password'];
	        $email=$_POST['email'];
	        $sql='SELECT username,email FROM users WHERE username="'.$username.'" 
	        AND email="'.$email.'"';
//end modified
            $result=checkUser($mysqli,$sql);
            $usernameOK=$result[0];
            $checkpwd=new my_checkpassword($password);
            //$checkpwd->allowSpaces();
            //$checkpwd->requireMixedCase();
            //$checkpwd->requireNumbers(3);
            //$checkpwd->requireSymbols();
            $pwdOK=$checkpwd->check();
            if($usernameOK && $pwdOK)
            {
                $verifystring='';
                $verifyurl=$cfg_sitedir.'verify.php';
                for($i=0;$i<16;$i++)
                {
                    $randomstring.=chr(mt_rand(32,126));
                }
                $verifystring=urlencode($randomstring);
                $useremail=urlencode($email);
                $sql='INSERT INTO users
                        (username,password,email,verifystring,active)
                        VALUES
                        ("'.$username.'","'.$password.'","'.addslashes($email).'","'.
                        addslashes($randomstring).'",0)';
                $OK=saveUser($mysqli,$sql);
                if($OK)
                {
                    $mail_body=<<<MYDOC
                    这是注册验证邮件，请按照下面的提示完成操作：
					马上就可以完成注册了，接下来您只需要点击以下链接就可以完成注册了，如果链接不能够点击
				请将链接复制到浏览器的地址栏中并访问网址也可以完成注册
                    $verifyurl?useremail=$useremail&verifystring=$verifystring
					
					
MYDOC;
                    mail($email,$cfg_sitename.' 注册验证邮件',$mail_body);
					$success='您已经填写完注册信息，接下来请到您的邮箱查看我们给您发送的注册验证邮件，
						按照上面的提示完成最好的注册验证';
                    echo $success;
					exit;
                }
                else
                {
                    $error[]='对不请，网站出来点问题，请稍后再进行注册';
                }
            }
            elseif(!$usernameOK && !$pwdOK)
            {
                $error[]=$result[1];
                $error=array_merge($error,$checkpwd->getMessage());
            }
            elseif(!$usernameOK)
            {
                $error[]=$result[1];
            }
            else
            {
                $error=array_merge($error,$checkpwd->getMessage());
            }
	    }
	    else
	    {
	        $error[]='两次输入的密码不一致';
	    }
	}
	else
	{
	    $error[]='请填写完整的注册信息';
	}	
}

if(isset($error))
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