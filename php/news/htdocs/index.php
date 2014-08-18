<?php
session_start();
require_once'../config/mysite.cfg.php';
require_once'inc/flush_session.inc.php';
require_once'inc/process_leave.inc.php';
require_once'../db/connection.inc.php';
require_once'inc/utility.inc.php';
if(isset($_GET[parentcat]) && isset($_GET[childcat]) 
	&& checkID($_GET[parentcat]) && checkID($_GET[childcat]))
{
	$_SESSION[parentcat]=$_GET[parentcat];
	$_SESSION[childcat]=$_GET[childcat];
	$sql='select stories.*,users.username,categories.category 
				from stories,users,categories
				where stories.cat_id=categories.id
					and stories.poster_id=users.id
					and stories.cat_id='.$_GET[childcat];		   
}
elseif(isset($_GET[parentcat]) && checkID($_GET[parentcat]))
{
	$_SESSION[parentcat]=$_GET[parentcat];
	$sql='select stories.*,users.username,categories.category 
				from stories,users,categories
				where stories.cat_id='.$_GET[parentcat].'
					and users.id=stories.poster_id
					and categories.id=stories.cat_id
			 union
			 select stories.*,users.username,categories.category 
				from stories,cat_relate,users,categories
				where cat_relate.parent_id='.$_GET[parentcat].'
					and stories.cat_id=cat_relate.child_id
					and users.id=stories.poster_id
					and categories.id=stories.cat_id';
}
else
{
	$sql='select stories.*,users.username,categories.category 
				from stories,categories,users 
				where stories.poster_id=users.id
					and stories.cat_id=categories.id
				order by dateposted desc limit 5';
}
$mysqli=dbConnection('read','mysqli');
$results=$mysqli->query($sql);
$num_rows=$results->num_rows;
$mystr='';
if($num_rows==0)
{
	$mystr.='<p><strong>No Stories</strong></p>';
}
else
{
	while($row=$results->fetch_object())
	{
		$mystr.='<h3>Topic~'.$row->category;
		if(isset($_SESSION[userlevel]) && $_SESSION[userlevel]==10)
		{
			$mystr.='[<a href="deletestory.php?id='.$row->id.'">X</a>]';
		}
		$mystr.='</h3>';
		$mystr.='<p><a href="viewstory.php?id='.$row->id.'">'.$row->subject.'</a></p>';
		$mystr.='<p>'.first50chars($row->body).'<a href="viewstory.php?id='.$row->id.'">...More</a></p>';
		$mystr.='<p><strong>Posted by </strong><em>'.$row->username;
		$mystr.=' - '.date('D jS F Y g.iA',strtotime($row->dateposted)).'</em></p>';
	}
}
require_once'inc/header.inc.php';
echo $mystr;
require_once'inc/footer.inc.php';
?>