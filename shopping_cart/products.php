<?php
session_start();
require_once'inc/utility.inc.php';
require_once'inc/connection.inc.php';
require_once'config/mysite.cfg.php';
$sql='select id,name,image,price from products';
if(isset($_GET[catid]))
{
	if(checkID($_GET[catid]))
	{
		$catid=trim($_GET[catid]);
		$sql.=' where cat_id='.$catid;
	}
}
$mysqli=dbConnection('read','mysqli');
$results=$mysqli->query($sql);
$num_rows=$results->num_rows;

require_once'inc/header.inc.php';
$mystr='';
$mystr.='<table id="product-list">';
if($num_rows==0)
	$mystr.='<tr><td colspan="4">No Products</td></tr>';
else
{
	while($row=$results->fetch_object())
	{
		$mystr.='<tr><td>';
		if(trim($row->image))
		{
			$mystr.='<a href="details.php?id='.$row->id.'&catid='.$catid.'"><img src="'.$cfg_rs_imagepath.$row->image.'" /></a></td>';
		}
		else
		{
			$mystr.='<a href="details.php?id='.$row->id.'&catid='.$catid.'"><img src="'.$cfg_rs_imagepath.'default.jpg" /></a></td>';
		}
		$mystr.='<td><a href="details.php?id='.$row->id.'&catid='.$catid.'">'.$row->name.'</a></td>';
		$mystr.='<td>'.$cfg_locale_money.''.$row->price.'</td>';
		$mystr.='<td>[<a href="addtobasket.php?id='.$row->id.'">AddToBasket</a>]</td></tr>';
	}
}
$mystr.='</table>';
echo $mystr;
require_once'inc/footer.inc.php';
?>