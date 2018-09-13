<?php
session_start();
require_once'../config/mysite.cfg.php';
require_once'../db/connection.inc.php';
require_once'inc/utility.inc.php';
if(!isset($_SESSION[userlevel]) || $_SESSION[userlevel]<1)
{
	header("Location:$cfg_sitedir".'error=denied');
	exit;
}
if(!checkID($_GET[id]))
{
	header("Location:$cfg_sitedir".'error=method');
	exit;
}
else
{
	if(isset($_GET[conf]) && $_GET[conf]=='isure')
	{
		$sql='delete from stories where id='.$_GET[id];
		$mysqli->query($sql);
		header("Location:$cfg_sitedir);
		exit;
	}
	else
	{
		$sql='select stories.*,users.username,categories.category 
					from stories,categories,users 
					where stories.poster_id=users.id
						and stories.cat_id=categories.id
						and stories.id='.$_GET[id];
		$mysqli=dbConnection('read','mysqli');
		$results=$mysqli->query($sql);
		if($results->num_rows != 1)
		{
			header("Location:$cfg_sitedir".'?error=site');
			exit;
		}
		$row=$results->fetch_object();
		$mystr='';
		$mystr.='<p style="color:#ff0000">Are You Sure <a href="deletestory.php?id='.$_GET[id].'&conf=isure">';
		$mystr.='Delete</a> <h3>Topic~'.$row->category;
		$mystr.='</h3></p>';
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