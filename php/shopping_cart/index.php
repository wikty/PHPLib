<?php
require_once'config/mysite.cfg.php';
require_once'inc/flush_session.inc.php';
require_once'inc/process_leave.inc.php';
require_once'inc/connection.inc.php';
require_once'inc/header.inc.php';
$pdo=dbConnection('read','pdo');
$sql='select id,name,description,image,price from products';
$stmt=$pdo->prepare($sql);
$stmt->execute();
$num=$stmt->rowCount();
$num=mt_rand(1,$num);
$mystr='';
while($row=$stmt->fetchObject())
{
	if($row->id == $num)
	{
		$mystr.='<div class="show">';
		$mystr.='<p><span class="title">description: </span>'.$row->description.'</p>';
		$mystr.='<p><a href="details.php?id='.$row->id.'&from=index.php"><img src="'.$cfg_rs_imagepath.$row->image.'" /></a></p>';
		$mystr.='<p><span class="title">name: </span><a href="details.php?id='.$row->id.'&from=index.php"><strong>'.$row->name.'</strong></a></p>';
		$mystr.='<p><span class="title">price: </span><strong>'.$cfg_locale_money.$row->price.'</strong></p>';
		$mystr.='</div>';
	}
}
echo $mystr;
require_once'inc/footer.inc.php';
?>