<?php
//////////////////////////////////////
//Instroduction:
//this page to collect mulit page form information
// to hold in session, if your form is so big that should be divided
//in to several pages, you can you this solution.
////////////////////////////////////
//Usage:
//you should define some var in every
//page which has divided form,Follow should be defined:
//$mpf_firstpage='multiple_01.php';
//$mpf_nextpage='nultiple_02.php';
//$mpf_required=array('name','address');
//$mpf_submit='submit';
//$mpf_missing=array();
//the prefix mpf_ (multiple page form)is avoid name conflict
//and you should in firstpage start session var $_SESSION['mpf_started']
/////////////////////////////////
//Additional:
//in firstpage should include this file in submit process section.
// if form require filed is not filled, you should show $mpf_missing;
/////////////////////////////////////


if(!$_SESSION)
{
    session_start();
}
$thisfile=basename($_SERVER[SCRIPT_NAME]);
$currenturl='http://'.$_SERVER[HTTP_HOST].$_SERVER[PHP_SELF];
$firstfileurl=str_replace($thisfile,$mpf_firstpage,$currenturl);
$nextfileurl=str_replace($thisfile,$mpf_nextpage,$currenturl);
if($thisfile!=$mpf_firstpage && !isset($_SESSION['mpf_started']))
{
    header("Location:$firstfileurl");
    exit;
}

if(isset($_POST[$mpf_submit]))
{
    if(!isset($mpf_required))
    {
        $mpf_required=array();
    }
    else
    {
        $mpf_required=(array)$mpf_required;
    }
    foreach($_POST as $key=>$value)
    {
        if($key==$mpf_submit)
            continue;
        $value=(is_array($value)? $value:trim($value));
        if(empty($value) && in_array($key,$mpf_required))
        {
            $mpf_missing[]=$key;
        }
        else
        {
            $_SESSION[$key]=$value;
        }
        
        if(empty($mpf_missing))
        {
            header("Location:$nextfileurl");
            exit;
        }
    }
}
?>