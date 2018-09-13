<?php
session_start();
require_once'../config/mysite.cfg.php';
require_once'../db/connection.inc.php';
require_once'inc/utility.inc.php';
if($_SERVER[REQUEST_METHOD]=='POST')
{
	$mysqli=dbConnection('write','mysqli');
	$rating=$_POST[rating];
	$storyId=$_POST[storyid];
	if(isset($_SESSION[userid]) && $_SESSION[userlevel] >0)
	{
		$sql='select * from stories where id='.$storyId.' and poster_id='.$_SESSION[userid];
		$results=$mysqli->query($sql);
		if($results->num_rows)
		{
			header("Location:$cfg_sitedir".'viewstory.php?id='.$storyId.'&error=selfvote');
			exit;
		}
	}
	$sql='insert into ratings
				(user_id,story_id,rating)
				values
				('.$_SESSION[userid].','.$storyId.','.$rating.')';
	$mysqli->query($sql);
	if($mysqli->errno)
	{
		if($mysqli->errno==1062)
		{
			header("Location:$cfg_sitedir".'viewstory.php?id='.$storyId.'&error=voted');
			exit;
		}
		header("Location:$cfg_sitedir".'viewstory.php?id='.$storyId.'&error=site');
		exit;
	}
	else
	{
		header("Location:$cfg_sitedir".'viewstory.php?id='.$storyId);
		exit;
	}
}
if(isset($_GET[id]) && checkID($_GET[id]))
{
	$sql='select stories.*,users.username,categories.category
				from stories,users,categories
				where stories.id='.$_GET[id].'
				and stories.cat_id=categories.id
				and stories.poster_id=users.id';
	$mysqli=dbConnection('read','mysqli');
	$results=$mysqli->query($sql);
	$row=$results->fetch_object();
	$mystr='';
	if(isset($_GET[error]))
	{
		switch($_GET[error])
		{
			case 'voted':
				$mystr='<p><strong style="color:#ff0000">You had voted,Cannot Vote Again.</strong></p>';
				break;
			case 'site':
				$mystr='<p><strong style="color:#ff0000">There is something wrong with our site.</strong></p>';
				break;
			case 'selfvote':
				$mystr='<p><strong style="color:#ff0000">Your Cannot Vote For Yourself.</strong></p>';
		}
	}
	$mystr.='<h3>Topic~'.$row->category.'</h3>';
	$mystr.='<p>'.$row->subject.'</p>';
	$mystr.='<p>'.nl2br($row->body).'</p>';
	$mystr.='<p><strong>Posted By </strong><em>'.$row->username;
	$mystr.=' - '.date('D jS F Y g.iA',strtotime($row->dateposted)).'</em></p>';
	$results->free();
	$sql='select count(id) as rating_num,avg(rating) as rating_avg
				from ratings 
				where story_id='.$_GET[id];
	$results=$mysqli->query($sql);
	$row=$results->fetch_object();
	$rating_num=$row->rating_num;
	$rating_avg=$row->rating_avg;
	$rating_avg=round(round($rating_avg*2)/2);
	$mystr.='<strong>Rating: '.$rating_avg.'</strong><div style="border:1px dotted #ccc;width:325px;">';
	if($rating_num==0)
	{
		$mystr.='<span style="color:#ccc">No Rating</span>';
	}
	else
	{
		while($rating_avg)
		{
			$rating_avg--;
			$mystr.='<img src="images/star.png" />';
		}
	}
	$mystr.='</div>';
	$results->free();
	if(isset($_SESSION[userid]))
	{
		$mystr.='<form action="" method="post">';
		$mystr.='<label>Your Rating:</label>';
		$mystr.='<select name="rating" id="rating">';
		for($i=0;$i<11;$i++)
		{
			$mystr.='<option value="'.$i.'">'.$i.'</option>';
		}
		$mystr.='</select>';
		$mystr.='<input type="hidden" value="'.$_GET[id].'" name="storyid" />';
		$mystr.='<input type="submit" name="submit" value="Rating" />';
		$mystr.='</form>';
	}
}
else
{
	include'inc/header.inc.php';
	echo '<strong>Your access this page method is error!</strong>';
	include'inc/footer.inc.php';
	exit;
}
require_once'inc/header.inc.php';
echo $mystr;
require_once'inc/footer.inc.php';
?>