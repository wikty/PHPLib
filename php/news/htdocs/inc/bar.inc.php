<h2>Topics</h2>
<ul>
<?php
require_once'../db/connection.inc.php';
$bar_mysqli=dbConnection('read','mysqli');
$bar_sql='select * from categories where parent=1';
$bar_results=$bar_mysqli->query($bar_sql);
$bar_num_rows=$bar_results->num_rows;
$bar_mystr='';
if($bar_num_rows==0)
{
	echo '<li><strong>No Categories</strong></li>';
}
else
{
	while($bar_row=$bar_results->fetch_object())
	{
		$bar_mystr.='<li><a href="index.php?parentcat='.$bar_row->id.'">'.$bar_row->category.'</a>';
		if(isset($_SESSION[userlevel]) && $_SESSION[userlevel]==10)
		{
			$bar_mystr.='[<a href="deletecat.php?id='.$bar_row->id.'">X</a>]';
		}
		if(isset($_SESSION[parentcat]) && $_SESSION[parentcat] == $bar_row->id)
		{
			$bar_mystr.='<ul>';
			$bar_sql='select categories.id,category
						from categories left join cat_relate
							on categories.id=cat_relate.child_id
						where cat_relate.parent_id='.$_SESSION[parentcat];
			$sub_results=$bar_mysqli->query($bar_sql);
			$sub_num_rows=$sub_results->num_rows;
			if($sub_num_rows==0)
			{
				$bar_mystr.='<li><strong>No Sub-Categories</strong></li>';
			}
			else
			{
				while($sub_row=$sub_results->fetch_object())
				{
					$bar_mystr.='<li><a href="index.php?parentcat='.$bar_row->id.'&childcat='.$sub_row->id;
					$bar_mystr.='">'.$sub_row->category.'</a>';
					if(isset($_SESSION[userlevel]) && $_SESSION[userlevel]==10)
					{
						$bar_mystr.='[<a href="deletecat.php?id='.$sub_row->id.'">X</a>]';
					}
					$bar_mystr.='</li>';
				}
			}
			$bar_mystr.='</ul>';
		}
		$bar_mystr.='</li>';
	}
	$bar_mystr.='</ul>';
	echo $bar_mystr;
	$bar_mysqli->close();
}
?>