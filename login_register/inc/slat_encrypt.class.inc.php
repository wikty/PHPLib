<?php
// // validate encrypted data
// $check=new SlatEncrypt('original-password');
// if($check->validateEncryptedData('encrypted-data-a83jj09j3l2390jl'))
// {
//     // validate success
// }
// // or 
// $check->validate($original_data, $encrypted_data);
//
//
// // generate encrypt data
// $check->setOriginalData('original-password');
// $encrypted_data=$check->getEncryptedData();

class SlatEncrypt
{
protected $_slatASCIIStart=65;
protected $_slatASCIIEnd=120;
protected $_slat;
protected $_slatLen;
protected $_randStrLen=50;
protected $_originalData;
protected $_encryptedData;
protected $_checkEncrypted=false;

public function __construct($data='')
{
    $this->_originalData=$data;
}

public function setSlatLen($slatLen)
{
    if(is_numeric($slatLen) && $slatLen>0)
    {
        $this->_slatLen=(int)$slatLen;
        return true;
    }
    return false;
}

public function setOriginalData($originalData)
{
    $this->_originalData=$originalData;
}

public function getOriginalData()
{
    return $this->_originalData;
}

public function getEncryptedData()
{
    $this->_generateSlat();
    $this->_encryptedData=$this->_slat.sha1($this->_slat.$this->_originalData);
    return $this->_encryptedData;
}

public function validateEncryptedData($encrypted_data)
{
    if($encrypted_data)
    {
        $this->_generateSlat($encrypted_data);
        if($encrypted_data==$this->_slat.sha1($this->_slat.$this->_originalData))
        {
            return true;
        }
    }
    return false;
}

public function validate($original_data, $encrypted_data)
{
    if($original_data && $encrypted_data)
    {
        $this->_generateSlat($encrypted_data);
        if($encrypted_data==$this->_slat.sha1($this->_slat.$original_data))
        {
            return true;    
        }
    }
    return false;
}

protected function _generateSlat($encrypted_data='')
{
    if(!$encrypted_data)
    {
        $randStr='';
        $start=0;
        for($i=0;$i<($this->_randStrLen);$i++)
        {
            $randStr.=chr(mt_rand($this->_slatASCIIStart,$this->_slatASCIIEnd));
        }
        $start=mt_rand(0,$this->_randStrLen-$this->_slatLen);
        $this->_slat=substr($randStr,$start,$this->_slatLen);
    }
    else
    {
        $this->_slat=substr($encrypted_data, 0, $this->_slatLen);
    }
}
}
?>