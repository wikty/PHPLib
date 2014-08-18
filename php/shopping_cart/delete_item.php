<?php
session_start();
require_once'config/mysite.cfg.php';
require_once'inc/connection.inc.php';
require_once'inc/utility.inc.php';
if(isset($_POST[submit]))
{
	$productid=$_POST[productid];
	$quantity=$_POST[quantity];
	if(is_numeric($quantity) && is_numeric($productid) && $quantity>=0 && $productid>0)
	{
		$mysqli=dbConnection('write','mysqli');
		$sql='select order_items.quantity,products.price
				from order_items,products
				where order_items.order_id='.$_SESSION[orderid].'
				and order_items.product_id='.$productid.'
				and order_items.product_id=products.id';
		$results=$mysqli->query($sql);
		$row=$results->fetch_object();
		$orgquantity=$row->quantity;
		if($orgquantity==$quantity)
		{
			header("Location:$cfg_sitedir".'showbasket.php');
			exit;
		}
		$price=$row->price;
		$remove=($orgquantity-$quantity)*$price;
		if($quantity==0)
		{
			$sql='delete from order_items
					where order_id='.$_SESSION[orderid].'
					and product_id='.$productid;
			$mysqli->query($sql);
		}
		else
		{
			$sql='update order_items 
				set quantity='.$quantity.' 
				where product_id='.$productid.'
				and order_id='.$_SESSION[orderid];
			$mysqli->query($sql);
		}
		
		if($mysqli->affected_rows==1)
		{
			$sql='update orders set total=total-'.$remove.' where id='.$_SESSION[orderid];
			$mysqli->query($sql);
			if($mysqli->affected_rows==1)
			{
				header("Location:$cfg_sitedir".'showbasket.php');
				exit;
			}
		}
	}
	
	header("Location:$cfg_sitedir".'error.php?error=1');
	exit;
}
elseif(checkID($_GET[id]))
{
	$productid=(int)trim($_GET[id]);
	$sql='select order_items.quantity,products.id,products.name,products.price,products.image
		from order_items,products
		where order_items.order_id='.$_SESSION[orderid].'
		and order_items.product_id='.$productid.'
		and order_items.product_id=products.id';
	$mysqli=dbConnection('read','mysqli');
	$results=$mysqli->query($sql);
	$num_rows=$results->num_rows;
	if($num_rows==1)
	{
		$row=$results->fetch_object();
		$mystr='';
		$mystr.='<form action="" method="post">';
		$mystr.='<div><a href="details.php?id='.$productid.'&from=delete_item.php">';
		if(trim($row->image))
		{
			$mystr.='<img width="400" height="300" src="'.$cfg_rs_imagepath.$row->image.'" /></a>';
		}
		else
		{
			$mystr.='<img width="400" height="300" src="'.$cfg_rs_imagepath.'default.jpg" /></a>';
		}
		$mystr.='<span><a href="details.php?id='.$productid.'&from=delete_item.php">';
		$mystr.='<strong>'.$row->name.'</strong></a></span>';
		$mystr.='</div><div>';
		$mystr.='<span><strong>'.$cfg_locale_money.sprintf('%.2f',$row->price).'/per</strong></span>';
		$mystr.='</div><div>';
		$mystr.='<label for="quantity">Delete to Quantity:</label>';
		$mystr.='<select id="quantity" name="quantity">';
		$count=$row->quantity;
		$mystr.='<option value="'.$count.'" selected="true">'.$count.'</option>';
		for($i=$count-1;$i>=0;$i--)
		{
			$mystr.='<option value="'.$i.'">'.$i.'</option>';
		}
		$mystr.='</select>';
		$mystr.='</div><br/><div>';
		$mystr.='<input type="hidden" name="productid" value="'.$productid.'" />';
		$mystr.='<input type="submit" name="submit" id="submit" value="DeleteTo" />';
		$mystr.='</div>';
		$mystr.='</form>';
		$mystr.='<div><a href="showbasket.php"><strong>GoBackCart</strong></a></div>';
		
		require_once'inc/header.inc.php';
		echo $mystr;
		require_once'inc/footer.inc.php';
		
	}
	else
	{
		header("Location:$cfg_sitedir");
		exit;
	}
}
else
{
	header("Location:$cfg_sitedir");
	exit;
}
?>