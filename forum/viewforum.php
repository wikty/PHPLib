<?php
$needDB=true;
require_once'config/mysite.cfg.php';
if(isset($_GET[id]) && is_numeric($_GET[id]))
{
	$forumid=abs($_GET[id]);
}
else
{
	header("Location:$cfg_sitedir");
	exit;
}
require_once'inc/header.inc.php';
$sql='SELECT * FROM categories';
$results=$mysqli->query($sql);
$forum='';
$mystr='<table class="maintable">';
while($row=$results->fetch_object())
{
    $mystr.='<tr class="head"><td colspan="2">'.$row->cat.'</td></tr>'."\n";
    $sql='SELECT *  FROM forums WHERE cat_id='.$row->id;
    $results_f=$mysqli->query($sql);
    $num_rows=$results_f->num_rows;
    if($num_rows)
    {
        while($row_f=$results_f->fetch_object())
        {
			if($row_f->id==$forumid)
			{
				$mystr.='<tr><td class="nowhere"><strong><a href="viewforum.php?id='.$row_f->id.
				'">'.$row_f->name.'</a></strong><p class="italic">'.$row_f->description.'</p></td></tr>'."\n";	
				$forum=$row_f->name;
			}
			else
			{
				$mystr.='<tr><td><strong><a href="viewforum.php?id='.$row_f->id.
				'">'.$row_f->name.'</a></strong><p class="italic">'.$row_f->description.'</p></td></tr>'."\n";
			}
        }
    }
    else
    {
        $mystr.='<tr><td><span class="italic">暂时没有话题</span></td></tr>'."\n";
    }
}
$mystr.='</table>'."\n";
$sql='SELECT topics.id,topics.subject,users.username,topics.user_id,
		COUNT(messages.id)-1 AS replies,topics.dateposted
		FROM topics,users,messages 
		WHERE topics.forum_id='.$forumid.'
		AND topics.user_id=users.id
		AND topics.id=messages.topic_id
		GROUP BY topics.id
		ORDER BY topics.dateposted DESC';
$results=$mysqli->query($sql);
$num_rows=$results->num_rows;
$mystr.='<div class="innerframe"><div><a href="addtopic.php?forumid='.$forumid.'">[发帖]</a></div>';
$mystr.='<table><caption>'.$forum.'</caption><th>话题</th><th>发帖人</th><th>回复</th><th>发帖时间</th>';
if($num_rows)
{
	while($row=$results->fetch_object())
	{
		$mystr.='<tr><td><a href="viewtopic.php?id='.$row->id.'&method=topic&topicid='.$row->id.'">'.$row->subject.'</a></td>
		<td><a href="viewtopic.php?id='.$row->user_id.'&method=user&topicid='.$row->id.'">
		'.$row->username.'</a></td><td>
		'.$row->replies.'</td><td>'.$row->dateposted.'
		</td></tr>';
	}
}
else
{
	$mystr.='<tr><td colspan="4">没有帖子</td></tr>';
}
$mystr.='</table></div>';
echo $mystr; 
require_once'inc/footer.inc.php';
?>