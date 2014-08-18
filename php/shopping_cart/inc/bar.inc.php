<h2>Products Categories</h2>
<ul>
	<li>
		<a href="products.php">View All</a>
	</li>
<?php
$pdo=dbConnection('read','pdo');
$sql='select id,cat from categories';
$stmt=$pdo->prepare($sql);
$stmt->execute();
$barmystr='';
while($row=$stmt->fetchObject())
{
    $barmystr.='<li><a href="products.php?catid='.$row->id.'">'.ucwords($row->cat).'</a></li>';
}
echo $barmystr;
?>
</ul>