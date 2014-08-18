<?php
session_start();
require_once'config/mysite.cfg.php';
require_once'inc/connection.inc.php';
require_once'inc/utility.inc.php';

if(checkID($_GET[id]))
{
	$pdo=dbConnection('read','pdo');
	$sql='select id,name,description,image,price from products where id=:id';
	$stmt=$pdo->prepare($sql);
	$stmt->bindParam(':id',$_GET[id],PDO::PARAM_INT);
	$stmt->execute();
	$mystr='';
	$row=$stmt->fetchObject();
	if($row)
	{
		$mystr.='<div class="show">';
		$mystr.='<p><span class="title">description: </span>'.$row->description.'</p>';
		$mystr.='<p><img src="'.$cfg_rs_imagepath.$row->image.'"></img></p>';
		$mystr.='<p><span class="title">name: </span><strong>'.$row->name.'</strong></p>';
		$mystr.='<p><span class="title">price: </span><strong>'.$cfg_locale_money.$row->price.'</strong></p>';
		if(isset($_GET[from]) && !empty($_GET[from]))
		{
			$frompage=trim($_GET[from]).'?id='.$_GET[id];
		}
		else
		{
			$frompage='products.php?catid='.$_GET[catid];
		}
		$mystr.='<p><a href="'.$frompage.'"><strong>GoBack</strong></a>';
		$mystr.='<span>&nbsp;&nbsp;&nbsp;&nbsp;</span>';
		$mystr.='<a href="addtobasket.php?id='.$_GET[id].'"><strong>BuyIt</strong></a></p>';
		$mystr.='</div>';
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
require_once'inc/header.inc.php';
echo $mystr;
require_once'inc/footer.inc.php';

?>