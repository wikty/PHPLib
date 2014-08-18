<?php
$needDB=true;
$mystr='';
require_once'config/mysite.cfg.php';
require_once'inc/getdb.inc.php';
////////////////////////////////////bulid a guid category=>forum=>topic
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
			$sqltwo='SELECT topics.subject,users.username,messages.*
					FROM topics,users,messages
					WHERE topics.id='.$myid.'
					AND messages.topic_id='.$myid.'
					AND topics.user_id=users.id
					AND topics.user_id!=messages.user_id';
			$results=$mysqli->query($sqlone);
			$row=$results->fetch_object();
			$mystr='<table class="postman">';
			$mystr.='<caption>发帖人：'.$row->username.'</caption>';
			$mystr.='<tr class="head"><th>主题</th><th>内容</th><th>发帖时间</th></tr>';
			$mystr.='<tr><td>'.$row->subject.'</td><td>'.$row->body.'</td><td>'.$row->dateposted.'</td></tr>';
			$mystr.='</table>';
			$results=$mysqli->query($sqltwo);
			$num_rows=$results->num_rows;
			if($num_rows)
			{
				while($row=$results->fetch_object())
				{
					$mystr.='<table class="followman">';
					$mystr.='<caption>跟帖人'.$row->username.'</caption>';
					$mystr.='<tr class="head"><th>内容</th><th>跟帖时间</th></tr>';
					$mystr.='<tr><td>'.$row->body.'</td><td>'.$row->dateposted.'</td></tr>';
					$mystr.='</table>';					
				}
			}
			else
			{
				$mystr.='<p class="error">暂时没有人跟帖</p>';
			}
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
						$mystr.='<caption>发帖人'.$row->username.'</caption>';
						$mystr.='<tr class="head"><th>主题</th><th>类型</th><th>发帖时间</th></tr>';
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
				$mystr='<p class="error">暂时没有帖子</p>';
			}
			break;
		default:
		header("Location:$cfg_sitedir");
		exit;
	}
	require_once'inc/header.inc.php';
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