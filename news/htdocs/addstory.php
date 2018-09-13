<?php
function process_submit($values)
{
	$catId=$values['cat_id'];
	$subject=$values['subject'];
	$body=$values['body'];
	$sql='insert into stories
				(cat_id,poster_id,subject,body)
				values
				(?,?,?,?)';
	global $mysqli;
	global $cfg_sitedir;
	$stmt=$mysqli->stmt_init();
	$stmt->prepare($sql);
	$stmt->bind_param('iiss',$catId,$_SESSION[userid],$subject,$body);
	$stmt->execute();
	$stmt->store_result();
	if($stmt->affected_rows==1)
	{
		$lastId=$mysqli->insert_id;
		header("Location:$cfg_sitedir".'viewstory.php?id='.$lastId);
		exit;
	}
	else
	{
		header("Location:$cfg_sitedir".'addstory.php?error=site');
		exit;
	}
}
session_start();
require_once'../config/mysite.cfg.php';
if(!isset($_SESSION[userlevel]) || $_SESSION[userlevel] <1)
{
	header("Location:$cfg_sitedir");
	exit;
}
require_once'../db/connection.inc.php';
require_once'html/quickform.php';
$form=new HTML_QuickForm('addstory');
$mysqli=dbConnection('read','mysqli');
$sql='select * from categories';
$results=$mysqli->query($sql);
while($row=$results->fetch_object())
{
	$mycats[$row->id]=$row->category;
}
$element=$form->createElement('select','cat_id','Category');
$element->loadArray($mycats);
$form->addElement($element);
$form->addElement('text','subject','Subject',array('size'=>50,'maxlength'=>255));
$form->addElement('textarea','body','Body',array('size'=>50,'maxlength'=>255,'rows'=>20,'cols'=>80));
$form->addElement('submit','submit','Submit');
$form->addRule('subject','Please Enter A Subject','required',null,'client');
$form->addRule('body','Please Enter A Body','required',null,'client');
if($form->validate())
{
	$form->freeze();
	$form->process('process_submit',false);
}
else
{
	require_once'inc/header.inc.php';
	if(isset($_GET[error]) && $_GET[error]=='site')
	{
		echo '<p><strong style="color:#ff0000">There is something wrong with our site.</strong></p>';
	}
	$form->display();
	require_once'inc/footer.inc.php';
}
?>