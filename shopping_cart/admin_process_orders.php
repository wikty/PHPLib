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
if(isset($_GET[conf]))
{
	if(checkID($_GET[id]))
	{
		$sql='update orders set status=10 where id='.$_GET[id];
		$mysqli->query($sql);
	}
	else
	{
		header('Location:http://'.$_SERVER[HTTP_HOST].$_SERVER[PHP_SELF]);
		exit;
	}
}
$sql='select id,date,status,payment_type,total,registered from orders 
		where status>=2 
		and date>=adddate(now(),interval -1 month)
		order by date';
$results=$mysqli->query($sql);
$mystr='<table>';
while($row=$results->fetch_object())
{
	$payment=($row->payment_type==1)?'cheque':'zhifubao';
	$registered=($row->registered==0)?'Non-registered Customer':'Reigstered Customer';
	$status=($row->status==2)?'confirm pay':'confirmed';
	$mystr.='<tr><td><a href="admin_process_details.php?id='.$row->id.'">[View]</a></td>';
	$mystr.='<td>'.$row->date.'</td>'.'<td>'.$registered.'</td>';
	$mystr.='<td>'.$cfg_locale_money.sprintf('%.2f',$row->total).'</td>';
	$mystr.='<td>'.$payment.'</td>';
	if($status=='confirmed')
	{
		$mystr.='<td>'.$status.'</td>';
	}
	else
	{
		$mystr.='<td><a href="admin_process_orders.php?conf=true&id='.$row->id.'">'.$status.'</a></td>';
	}
	$mystr.='</tr>';
}
$mystr.='</table>';
require_once'inc/header.inc.php';

echo $mystr;

require_once'inc/footer.inc.php';
?>