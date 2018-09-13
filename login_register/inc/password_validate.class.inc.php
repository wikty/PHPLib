<?php
class PasswordValidate
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
?>
