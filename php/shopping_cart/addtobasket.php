<?php
session_start();
require_once'config/mysite.cfg.php';
require_once'inc/connection.inc.php';
require_once'inc/utility.inc.php';
if(checkID($_GET[id]))
{
	$productid=trim($_GET[id]);
}
else
{
	header("Location:$cfg_sitedir");
	exit;
}

if($_POST[submit])
{
	$productid=$_POST[productid];
	$quantity=$_POST[quantity];
	$sql='select price from products where id='.$productid;
	$mysqli=dbConnection('read','mysqli');
	$results=$mysqli->query($sql);
	$row=$results->fetch_object();
	$proprice=$row->price*$quantity;
	if(isset($_SESSION[username]))
	{
		if(isset($_SESSION[orderid]))
		{
			$orderid=$_SESSION[orderid];
			$sql='select product_id from order_items 
			where order_id='.$_SESSION[orderid].'
			and product_id='.$productid;
			$results=$mysqli->query($sql);
			if($results->num_rows>0)
			{
				$sql='update order_items set quantity=quantity+'.$quantity.' where product_id='.$productid;
				$mysqli->query($sql);
			}
			else
			{
				$sql='insert into order_items
					(product_id,order_id,quantity)
					values
					('.$productid.','.$orderid.','.$quantity.')';
				$mysqli->query($sql);
			}
			if($mysqli->affected_rows==1)
			{
				$sql='update orders set total=total+'.$proprice.' where id='.$_SESSION[orderid];
				$mysqli->query($sql);
				header("Location:$cfg_sitedir".'showbasket.php');
				exit;
			}
			else
			{
				header("Location:$cfg_sitedir".'error.php?error=1');
				exit;
			}
		}
		else
		{
			if(!isset($_SESSION[orderid]))
			{
				$sql='insert into orders
						(registered,customer_id,status,date,total)
						values
						(1,'.$_SESSION[customerid].',0,now(),0.00)';
				$mysqli->query($sql);
				$orderid=$mysqli->insert_id;
				$_SESSION[orderid]=$orderid;
			}
			$sql='select product_id from order_items 
			where order_id='.$_SESSION[orderid].'
			and product_id='.$productid;
			$results=$mysqli->query($sql);
			if($results->num_rows>0)
			{
				$sql='update order_items set quantity=quantity+'.$quantity.' where product_id='.$productid;
				$mysqli->query($sql);	
			}
			else
			{
				$sql='insert into order_items
					(product_id,order_id,quantity)
					values
					('.$productid.','.$_SESSION[orderid].','.$quantity.')';
				$mysqli->query($sql);
			}
			if($mysqli->affected_rows==1)
			{
				$sql='update orders set total=total+'.$proprice.' where id='.$_SESSION[orderid];
				$mysqli->query($sql);
				header("Location:$cfg_sitedir".'showbasket.php');
				exit;
			}
			else
			{
				header("Location:$cfg_sitedir".'error.php?error=1');
				exit;
			}
		}
	}
	else
	{
		if(!isset($_SESSION[orderid]))
		{
			$sessionid=session_id();
			$sql='insert into orders
					(registered,session_id,status,date,total)
					values
					(0,"'.$sessionid.'",0,now(),0.00)';
			$mysqli->query($sql);
			$orderid=$mysqli->insert_id;
			$_SESSION[orderid]=$orderid;
		}
		$sql='select product_id from order_items 
					where order_id='.$_SESSION[orderid].'
					and product_id='.$productid;
		$results=$mysqli->query($sql);
		if($results->num_rows>0)
		{
			$sql='update order_items set quantity=quantity+'.$quantity.' where product_id='.$productid;
			$mysqli->query($sql);
		}
		else
		{
			$sql='insert into order_items
				(product_id,order_id,quantity)
				values
				('.$productid.','.$_SESSION[orderid].','.$quantity.')';
			$mysqli->query($sql);
		}
		if($mysqli->affected_rows==1)
		{
			$sql='update orders set total=total+'.$proprice.' where id='.$_SESSION[orderid];
			$mysqli->query($sql);
			header("Location:$cfg_sitedir".'showbasket.php');
			exit;
		}
		else
		{
			header("Location:$cfg_sitedir".'error.php?error=1');
			exit;
		}
	}
}
else
{
	$mystr='';
	$sql='select name,image,price from products where id=?';
	$mysqli=dbConnection('read','mysqli');
	$stmt=$mysqli->stmt_init();
	$stmt->prepare($sql);
	$stmt->bind_param('i',$productid);
	$stmt->execute();
	$stmt->store_result();
	$stmt->bind_result($pro_name,$pro_image,$pro_price);
	$num_rows=$stmt->num_rows();
	if($num_rows==1)
	{
		$stmt->fetch();
		$mystr.='<form action="" method="post">';
		$mystr.='<div><a href="details.php?id='.$productid.'&from=addtobasket.php">';
		if(trim($pro_image))
		{
			$mystr.='<img width="400" height="300" src="'.$cfg_rs_imagepath.$pro_image.'" /></a>';
		}
		else
		{
			$mystr.='<img width="400" height="300" src="'.$cfg_rs_imagepath.'default.jpg" /></a>';
		}
		$mystr.='<span><a href="details.php?id='.$productid.'&from=addtobasket.php">';
		$mystr.='<strong>'.$pro_name.'</strong></a></span>';
		$mystr.='</div><div>';
		$mystr.='<span><strong>'.$cfg_locale_money.sprintf('%.2f',$pro_price).'/per</strong></span>';
		$mystr.='</div><div>';
		$mystr.='<label for="quantity">Quantity:</label>';
		$mystr.='<select id="quantity" name="quantity">';
		$mystr.='<option value="1">1</option>';
		for($i=2;$i<100;$i++)
		{
			$mystr.="<option value=$i>$i</option>";
		}
		$mystr.='</select>';
		$mystr.='</div><br/><div>';
		$mystr.='<input type="hidden" name="productid" value="'.$productid.'" />';
		$mystr.='<input type="submit" name="submit" id="submit" value="AddToBasket" />';
		$mystr.='</div>';
		$mystr.='</form>';
	}
	else
	{
		header("Location:$cfg_sitedir");
		exit;
	}

	require_once'inc/header.inc.php';
		echo $mystr;
	require_once'inc/footer.inc.php';
}
?>