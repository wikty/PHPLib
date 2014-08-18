<?php
session_start();
$needDB=true;
$mystr='';
require_once'config/mysite.cfg.php';
require_once'inc/getdb.inc.php';
///////////////////////////////////
//add topic
if(isset($_POST[submit]) && isset($_POST[topicid]))
{
	if(!isset($_SESSION[username]) || !isset($_SESSION[password]))
	{
		$comment=$_POST[comment];
		//$topicid=urlencode($_POST[topicid]);
		$from=basename($_SERVER[SCRIPT_NAME]);
		$query=$_SERVER[QUERY_STRING];
		$shouldlogin='�㻹û�е�¼����¼����ܸ���������<a href="login.php?'.$query.'
		&comment='.urlencode($comment).'&from='.$from.'">[��¼]</a>';
	}
	else
	{
		$comment=$_POST[comment];
		$myid=$_POST[topicid];
		$forumid=$_POST[forumid];
		if(empty($comment) || empty($myid))
		{
		    $error='';
		}
		else
		{
		    $sql='select id from users where username="'.$_SESSION[username].'"
			 and password="'.$_SESSION[password].'"';
		    $results=$mysqli->query($sql);
		    $row=$results->fetch_object();
		    $userid=$row->id;
		    $sql='insert into messages
			(topic_id,body,dateposted,user_id)
			values
			('.$myid.',"'.$comment.'",now(),'.$userid.')';
		    $results=$mysqli->query($sql);
                                    //add topic is successfully
		    header("Location:$cfg_sitedir".'viewforum.php?id='.$forumid);
		    exit;
		    
		}
	}
}
//////////////////////////////////////
//show topic
if(isset($_GET[id]) && isset($_GET[method]) && is_numeric($_GET[id]) && isset($_GET[topicid]))
{
	$myid=abs($_GET[id]);
	$topicid=abs($_GET[topicid]);
	$forumid=$mysqli->query('SELECT forum_id FROM topics WHERE id='.$topicid);
	$forumid=$forumid->fetch_object();
	$forumid=$forumid->forum_id;
	$forum=$mysqli->query('SELECT name,cat_id FROM forums WHERE id='.$forumid);
	$forum=$forum->fetch_object();
	$forumname=$forum->name;
	$catid=$forum->cat_id;
	$cat=$mysqli->query('SELECT cat FROM categories WHERE id='.$catid);
	$cat=$cat->fetch_object();
	$cat=$cat->cat;
	$guide='<strong><a href="index.php">'.$cat.'</a>&gt;&gt;'.'<a href="viewforum.php?id='.$forumid.'">'.$forumname.'
		</a></strong>';
	switch($_GET[method])
	{
		case 'topic':
			$sqlone='SELECT topics.subject,users.username,messages.*
					FROM topics,users,messages
					WHERE topics.id='.$myid.'
					AND messages.topic_id='.$myid.'
					AND topics.user_id=users.id
					AND topics.user_id=messages.user_id';
			$results=$mysqli->query($sqlone);
			$row=$results->fetch_object();
			$mystr.='<table class="postman">';
			$mystr.='<caption>�����ˣ�'.$row->username.'</caption>';
			$mystr.='<tr class="head"><th>����</th><th>����</th><th>����ʱ��</th></tr>';
			$mystr.='<tr><td>'.$row->subject.'</td><td>'.$row->body.'</td><td>'.$row->dateposted.'</td></tr>';
			$mystr.='</table>';
			$sqltwo='SELECT topics.subject,users.username,messages.*
					FROM topics,users,messages
					WHERE topics.id='.$myid.'
					AND messages.topic_id='.$myid.'
					AND messages.user_id=users.id
					AND topics.dateposted!=messages.dateposted';
			$results=$mysqli->query($sqltwo);
			$num_rows=$results->num_rows;
			if($num_rows)
			{
				while($row=$results->fetch_object())
				{
					$mystr.='<table class="followman">';
					$mystr.='<caption>������'.$row->username.'</caption>';
					$mystr.='<tr class="head"><th>����</th><th>����ʱ��</th></tr>';
					$mystr.='<tr><td>'.$row->body.'</td><td>'.$row->dateposted.'</td></tr>';
					$mystr.='</table>';					
				}
			}
			else
			{
				$mystr.='<p class="error">��ʱû���˸���</p>';
			}
			$mystr.='<br/><form action="" method="post">';
			$mystr.='<div><label for="comment"><strong>��Ҫ˵��</strong></label></div>';
			$mystr.='<div><textarea rows="15" cols="80" id="comment" name="comment">';
			if(isset($comment))
			{
				$mystr.=$comment;
			}
			elseif(isset($_GET[comment]))
			{
				$mystr.=$_GET[comment];
			}
			$mystr.='</textarea></div>';
			$mystr.='<input type="hidden" name="topicid" value="'.$myid.'" />';
			$mystr.='<input type="hidden" name="forumid" value="'.$forumid.'" />';
			$mystr.='<input type="submit" name="submit" value="����" />';
			$mystr.='</form>';
			break;
		case 'user':
			$sqlone='SELECT topics.*,users.username
					FROM users,topics
					WHERE topics.user_id='.$myid.'
					AND users.id=topics.user_id';
			$results=$mysqli->query($sqlone);
			$num_rows=$results->num_rows;
			$mystr.='<table>';
			$i=1;
			if($num_rows)
			{
				while($row=$results->fetch_object())
				{
					if($i==1)
					{
						$i++;
						$mystr.='<caption>������'.$row->username.'</caption>';
						$mystr.='<tr class="head"><th>����</th><th>����</th><th>����ʱ��</th></tr>';
					}
					$sqltwo='SELECT name FROM forums WHERE id='.$row->forum_id;
					$results_f=$mysqli->query($sqltwo);
					$row_f=$results_f->fetch_object();
					$mystr.='<tr><td><a href="viewtopic.php?id='.$row->id.'&method=topic&topicid='.$row->id.'">'.$row->subject.'</a></td><td>
					'.$row_f->name.'</td><td>'.$row->dateposted.'</td></tr>';
				}
			}
			else
			{
				$mystr='<p class="error">��ʱû������</p>';
			}
			break;
		default:
		header("Location:$cfg_sitedir");
		exit;
	}
	require_once'inc/header.inc.php';
		if(isset($shouldlogin))
			echo '<div class="notice">'.$shouldlogin.'</div>';
		echo $guide;
		echo $mystr;
	require_once'inc/footer.inc.php';
}
else
{
	header("Location:$cfg_sitedir");
	exit;
}
?>