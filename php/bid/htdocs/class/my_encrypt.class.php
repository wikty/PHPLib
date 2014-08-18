<?php
class my_encrypt
{
protected $_slatASCIIStart=65;
protected $_slatASCIIEnd=120;
protected $_slat;
protected $_slatLen;
protected $_randStrLen=50;
protected $_originalData;
protected $_encryptedData;
protected $_checkEncrypted=false;
public function __construct($data='',$slatLen=4)
{
    $this->_originalData=$data;
    $this->_slatLen=$slatLen;
}
public function getEncryptedData()
{
    $this->generateSlat();
    $this->_encryptedData=$this->_slat.sha1($this->_slat.$this->_originalData);
    return $this->_encryptedData;
}
public function setCheck($encryptedData)
{
    $this->_encryptedData=$encryptedData;
    $this->_checkEncrypted=true;
}
public function closeCheck()
{
    $this->_checkEncrypted=false;
}
public function setOriginalData($originalData)
{
    $this->_originalData=$originalData;
}
protected function generateSlat()
{
    if($this->_checkEncrypted===false)
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
        $this->_slat=substr($this->_encryptedData,0,$this->_slatLen);
    }
}
}
?>