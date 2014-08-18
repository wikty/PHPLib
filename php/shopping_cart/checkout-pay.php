<?php
session_start();
require_once'config/mysite.cfg.php';
require_once'inc/connection.inc.php';
if(isset($_POST[submit]))
{
	$payment=$_POST[submit];
	if($payment=='PayWithCheque')
	{
		//should send pay information to the zhifubao or cheque
		$sql='update orders set status=2,payment_type=1 where id='.$_SESSION[orderid];
	}
	elseif($payment=='PayWithBao')
	{
		//should send pay information to the zhifubao or cheque
		$sql='update orders set status=2,payment_type=2 where id='.$_SESSION[orderid];
	}
	$mysqli=dbConnection('write','mysqli');
	$mysqli->query($sql);
	if($mysqli->affected_rows==1)
	{
		if(isset($_SESSION[username]))
		{
			$username=$_SESSION[username];
			$customerid=$_SESSION[customerid];
			session_unset();
			$_SESSION[username]=$username;
			$_SESSION[customerid]=$customerid;
		}
		else
		{
			session_unset();
			session_regenerate_id();
		}
		header("Location:$cfg_sitedir");
		exit;
	}
	header("Location:$cfg_sitedir".'error.php?error=1');
	exit;
}
require_once'inc/header.inc.php';
echo '<h2>Payment</h2>';
echo '<div><h3>Cart List</h3>';
require_once'inc/show_basket.inc.php';
echo '</div>';
echo '<br/><br/>';
$mysqli=dbConnection('read','mysqli');
$sql='select delivery_add_id from orders where id='.$_SESSION[orderid];
$results=$mysqli->query($sql);
$row=$results->fetch_object();
$deliveryid=$row->delivery_add_id;
$sql='select * from delivery_addresses where id='.$deliveryid;
$results=$mysqli->query($sql);
$row=$results->fetch_object();
$mystr='';
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
$mystr.='<tr><td colspan="4"><a href="checkout-address.php?modify=true">Modify-Address</a></td></tr>';
$mystr.='</table></div><br/><br/>';
$mystr.='<div><h3>Select Payment</h3>';
$mystr.='<form action="" method="post">';
$mystr.='<div><p><strong>Please Select A Payment Mehtod</strong></p>';
$mystr.='<p><strong>Cheque</strong><span>&nbsp;&nbsp;&nbsp;&nbsp;</span>';
$mystr.='<input type="submit" name="submit" value="PayWithCheque" /></p>';
$mystr.='<p><strong>ZhiFuBao</strong><span>&nbsp;&nbsp;&nbsp;&nbsp;</span>';
$mystr.='<input type="submit" name="submit" value="PayWithBao" /></p></div>';
$mystr.='</form></div>';
echo $mystr;
require_once'inc/footer.inc.php';
?>