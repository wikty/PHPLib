<?php
$mystr='';
$mystr.='<table id="showbasket"><tr><th>Name</th><th>Image</th><th>Price</th>
				<th>Quantity</th><th>Remove</th><th>Price*Quantity</th></tr>';
if(isset($_SESSION[username]))
{
	$sql='select id from orders where customer_id='.$_SESSION[customerid].' and status<2';
	$mysqli=dbConnection('read','mysqli');
	$results=$mysqli->query($sql);
	$num_rows=$results->num_rows;
	if($num_rows==0)
	{
		$mystr.='<tr><td colspan="6">no items</td></tr>';
	}
	else
	{
		$row=$results->fetch_object();
		$orderid=$row->id;
		$sql='select sum(order_items.quantity) as proquantity,products.id,products.name,products.price,products.image
				from order_items,products
				where order_items.order_id='.$orderid.'
				and order_items.product_id=products.id
				group by order_items.product_id';
		$results=$mysqli->query($sql);
		$num_rows=$results->num_rows;
		if($num_rows==0)
		{
			$mystr.='<tr><td colspan="6">no items</td></tr>';
		}
		else
		{
			$total=0.00;
			while($row=$results->fetch_object())
			{
				$total+=$row->proquantity*$row->price;
				$mystr.='<tr><td><a href="details.php?id='.$row->id.'&from=showbasket.php">'.$row->name.'</a></td>';
				$mystr.='<td><a href="details.php?id='.$row->id.'&from=showbasket.php"><img width="100" height="75" src="'.$cfg_rs_imagepath.$row->image.'" />';
				$mystr.='</a></td><td>'.$cfg_locale_money.$row->price.'</td><td>'.$row->proquantity.'</td>';
				$mystr.='<td><a href="delete_item.php?id='.$row->id.'">X</a></td>';
				$mystr.='<td>'.sprintf('%.2f',$row->price*$row->proquantity).'</td></tr>';
			}
			$mystr.='<tr><td><strong>Total</strong></td><td colspan="5">'.$cfg_locale_money.sprintf('%.2f',$total).'</td></tr>';
			$mystr.='</table>';
			if(basename($_SERVER[PHP_SELF])=='showbasket.php')
			{
				$mystr.='<br/><div><a href="checkout-address.php"><strong>Check-Out</strong></a></div>';
			}
		}
	}
	
}
else
{
	$sql='select id from orders where session_id="'.session_id().'" and status<2';
	$mysqli=dbConnection('read','mysqli');
	$results=$mysqli->query($sql);
	$num_rows=$results->num_rows;
	if($num_rows==0)
	{
		$mystr.='<tr><td colspan="6">no items</td></tr>';
	}
	else
	{
		$row=$results->fetch_object();
		$orderid=$row->id;
		$sql='select sum(order_items.quantity) as proquantity,products.id,products.name,products.price,products.image
				from order_items,products
				where order_items.order_id='.$orderid.'
				and order_items.product_id=products.id
				group by order_items.product_id';
		$results=$mysqli->query($sql);
		$num_rows=$results->num_rows;
		if($num_rows==0)
		{
			$mystr.='<tr><td colspan="6">no items</td></tr>';
		}
		else
		{
			$total=0.00;
			while($row=$results->fetch_object())
			{
				$total+=$row->price*$row->proquantity;
				$mystr.='<tr><td><a href="details.php?id='.$row->id.'&from=showbasket.php">'.$row->name.'</a></td>';
				$mystr.='<td><a href="details.php?id='.$row->id.'&from=showbasket.php"><img width="100" height="75" src="'.$cfg_rs_imagepath.$row->image.'" />';
				$mystr.='</a></td><td>'.$cfg_locale_money.$row->price.'</td><td>'.$row->proquantity.'</td>';
				$mystr.='<td><a href="delete_item.php?id='.$row->id.'">X</a></td>';
				$mystr.='<td>'.sprintf('%.2f',$row->price*$row->proquantity).'</td></tr>';
			}
			$mystr.='<tr><td><strong>Total</strong></td><td colspan="5">'.$cfg_locale_money.sprintf('%.2f',$total).'</td></tr>';
			$mystr.='</table>';
			if(basename($_SERVER[PHP_SELF])=='showbasket.php')
			{
				$mystr.='<br/><div><a href="checkout-address.php"><strong>Check-Out</strong></a></div>';
			}
		}
	}
}
echo $mystr;
?>
