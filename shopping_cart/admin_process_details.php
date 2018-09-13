<?php
session_start();
require_once'config/mysite.cfg.php';
if(!isset($_SESSION[admin]))
{
	header("Location:$cfg_sitedir");
	exit;
}
require_once'inc/connection.inc.php';
require_once'inc/utility.inc.php';
$mysqli=dbConnection('read','mysqli');
if(isset($_GET[id]) && checkID($_GET[id]))
{
	require_once'inc/header.inc.php';
	echo '<div><h3>Cart List</h3>';
	$sql='select * from orders where id='.$_GET[id];
	$results=$mysqli->query($sql);
	$num_rows=$results->num_rows;
	if($num_rows==0)
	{
		header("Location:admin_process_orders.php");
		exit;
	}
	$row=$results->fetch_object();
	$date=$row->date;
	$status=($row->status==2)?'confirm pay':'confirmed';
	$deliveryid=$row->delivery_add_id;
	$registered=($row->registered==0)?'Non-register Customer':'Registered Customer';
	$payment=($row->payment_type==1)?'Cheque':'zhifubao';
	$total=sprintf('%.2f',$row->total);
	$sql='select product_id,quantity from order_items where order_id='.$_GET[id];
	$results=$mysqli->query($sql);
	$num_rows=$results->num_rows;
	if($num_rows==0)
	{
		header("Location:admin_process_orders.php");
		exit;
	}
	$mystr='';
	$mystr='<table>';
	while($row=$results->fetch_object())
	{
		$productid=$row->product_id;
		$quantity=$row->quantity;
		$sql='select name,price from products where id='.$productid;
		$innerresults=$mysqli->query($sql);
		$innerrow=$innerresults->fetch_object();
		$proname=$innerrow->name;
		$proprice=$innerrow->price;
		$mystr.='<tr><td>'.$proname.'</td><td>'.$cfg_locale_money.$proprice.'</td>
				<td>'.$quantity.' x </td><td> is '.$cfg_locale_money.$quantity*$proprice.'</td></tr>';
	}
	$mystr.='<tr><td colspan="4">total is <strong>'.$cfg_locale_money.$total.'</strong></td></tr>';
	$mystr.='</table>';
	echo '</div>';
	$sql='select * from delivery_addresses where id='.$deliveryid;
	$results=$mysqli->query($sql);
	$row=$results->fetch_object();
	$mystr.='<div><h3>Address Information</h3><table><colgroup>
		<col style="font-weight: bold;" /><col/><col style="font-weight: bold" /><col/></colgroup>';
	$mystr.='<tr><td>Surname</td><td>'.$row->surname.'</td>';
	$mystr.='<td>Name</td><td>'.$row->name.'</td></tr>';
	$mystr.='<tr><td>Address</td><td>'.$row->addr1.'</td>';
	$mystr.='<td>Address2</td>';
	if(!empty($row->addr2))
	{
		$mystr.='<td>'.$row->addr2.'</td></tr>';
	}
	else
	{
		$mystr.='<td>no</td></tr>';
	}
	$mystr.='<tr><td>Address3</td>';
	if(!empty($row->addr3))
	{
		$mystr.='<td>'.$row->addr3.'</td>';
	}
	else
	{
		$mystr.='<td>no</td>';
	}
	$mystr.='<td>PostCode</td><td>'.$row->postcode.'</td></tr>';
	$mystr.='<tr><td>Phone</td><td>'.$row->phone.'</td>';
	$mystr.='<td>E-mail</td>';
	if(!empty($row->email))
	{
		$mystr.='<td>'.$row->email.'</td></tr>';
	}
	else
	{
		$mystr.='<td>no</td></tr>';
	}
	$mystr.='</table></div><br/><br/>';
	$mystr.='<div><h3>Others</h3>';
	$mystr.='<table>';
	$mystr.='<tr><td><strong>Payment Type</strong></td><td>'.$payment.'</td></tr>';
	$mystr.='<tr><td><strong>Registered</strong></td><td>'.$registered.'</td></tr>';
	$mystr.='<tr><td><strong>Status</strong></td><td>'.$status.'</td></tr>';
	$mystr.='</table></div>';
	$mystr.='<br/><div><a href="admin_process_orders.php">BackProcessOrders</a></div><br/>';
	echo $mystr;
	require_once'inc/footer.inc.php';	
}
else
{
	header("Location:admin_process_orders.php");
	exit;
}
?>