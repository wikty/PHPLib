<?php
session_start();
require_once'config/mysite.cfg.php';
require_once'inc/connection.inc.php';
require_once'inc/utility.inc.php';
$mysqli=dbConnection('write','mysqli');
$sql='select status from orders where id='.$_SESSION[orderid];
$results=$mysqli->query($sql);
$row=$results->fetch_object();
if($row->status==1 && !isset($_GET[modify]))
{
	header("Location:$cfg_sitedir".'checkout-pay.php');
	exit;
}
elseif($row->status>=2)
{
	header("Location:$cfg_sitedir");
	exit;
}
$missing=array();
$errors=array();
$requiredFields=array('surname','name','addr1','postcode','phone');
if(isset($_POST[submit]))
{
	$missing=checkRFields($_POST,$requiredFields);
	if(empty($missing))
	{
		//should check surname name addr1 postcode phone is validate
		extract($_POST);
		if(!isset($addr2))
			$addr2='';
		if(!isset($addr3))
			$addr3='';
		if(!isset($email))
			$email='';
		if(!isset($_POST[modify]))
		{
			$sql='insert into delivery_addresses
					(surname,name,addr1,addr2,addr3,postcode,phone,email)
					values
					(?,?,?,?,?,?,?,?)';
			$stmt=$mysqli->stmt_init();
			$stmt->prepare($sql);
			$stmt->bind_param('ssssssss',$surname,$name,$addr1,$addr2,$addr3,$postcode,$phone,$email);
			$stmt->execute();
			if($stmt->affected_rows==1)
			{
				$deliveryid=$mysqli->insert_id;
				$sql='update orders set status=1,delivery_add_id='.$deliveryid.' where id='.$_SESSION[orderid];
				$mysqli->query($sql);
				if($mysqli->affected_rows==1)
				{
					header("Location:$cfg_sitedir".'checkout-pay.php');
					exit;
				}
			}
		}
		else
		{
			$sql='update delivery_addresses set surname=?,name=?,addr1=?,addr2=?,addr3=?,
						postcode=?,phone=?,email=?
						where id='.$deliveryid;
			$stmt=$mysqli->stmt_init();
			$stmt->prepare($sql);
			$stmt->bind_param('ssssssss',$surname,$name,$addr1,$addr2,$addr3,$postcode,$phone,$email);
			$stmt->execute();
			if($stmt->affected_rows==1 ||$stmt->affected_rows==0)
			{
				header("Location:$cfg_sitedir".'checkout-pay.php');
				exit;
			}
		}
		header("Location:$cfg_sitedir".'error.php?error=1');
		exit;			
	}
}
else
{
	if(isset($_GET[modify]))
	{
		$sql='select delivery_add_id from orders where id='.$_SESSION[orderid];
		$results=$mysqli->query($sql);
		$row=$results->fetch_object();
		$deliveryid=$row->delivery_add_id;
		$sql='select surname,name,addr1,addr2,addr3,postcode,phone 
				from delivery_addresses where id='.$deliveryid;
		$results=$mysqli->query($sql);
		$row=$results->fetch_assoc();
		extract($row);
	}
	elseif(isset($_SESSION[username]))
	{
		$sql='select surname,name,addr1,addr2,addr3,postcode,phone,email from customers where id='.$_SESSION[customerid];
		$results=$mysqli->query($sql);
		$row=$results->fetch_assoc();
		extract($row);
	}
}
require_once'inc/header.inc.php';
require_once'inc/address.inc.php';
require_once'inc/footer.inc.php';
?>