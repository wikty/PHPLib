<?php
session_start();
require_once'../config/mysite.cfg.php';
require_once'inc/utility.inc.php';
if(!isset($_SESSION[userlevel]) ||  $_SESSION[userlevel] !=10 || !isset($_GET[id]) || !checkID($_GET[id]))
{
	header("Location:$cfg_sitedir");
	exit;
}
require_once'../db/connection.inc.php';
$mysqli=dbConnection('read','mysqli');
if(isset($_GET[conf]) && $_GET[conf]=='isure')
{
	if(checkID($_GET[id]))
	{
		$sql='delete from categories where id='.$_GET[id];
		$mysqli->query($sql);
		header("Locaion:$cfg_sitedir");
		exit;
	}
	header("Location:$cfg_sitedir".'?error=site');
	exit;
}
$sql='select * from categories where id='.$_GET[id];
$results=$mysqli->query($sql);
if($results->num_rows != 1)
{
	header("Location:$cfg_sitedir".'?error=site');
	exit;
}
$row=$results->fetch_object();
$category=$row->category;
$mystr='';
$mystr.='<p style="text-align:left">';
$mystr.='<strong style="color:#ff0000">Are Your Sure <a href="deletecat.php?id='.$_GET[id];
$mystr.='&conf=isure">Delete</a> Category~'.$category.'</strong><br/>';
$isParent=$row->parent;
if($isParent==1)
{
	$sql='select categories.category
				from categories,cat_relate
				where cat_relate.child_id=categories.id
				and cat_relate.parent_id='.$_GET[id];
	$results=$mysqli->query($sql);
	if($results->num_rows)
	{
		$mystr.='<em>Include Child Categories:';
		while($row=$results->fetch_object())
		{
			$mystr.=$row->category.',';
		}
		$mystr.='</em></p>';
	}
	else
	{
		$mystr.='<em>This Category No Child Categories</em></p>';
	}
}
require_once'inc/header.inc.php';
echo $mystr;
require_once'inc/footer.inc.php';
?>