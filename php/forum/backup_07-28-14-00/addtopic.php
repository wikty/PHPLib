<?php
/////check login
session_start();
require'config/mysite.cfg.php';
if(!(isset($_SESSION['username']) && isset($_SESSION[password])))
{
    require'inc/header.inc.php';
    $curpage=basename($_SERVER[SCRIPT_NAME]);
    $query=$_SERVER[QUERY_STRING];
    echo '<div class="notice">你没有登录，所以暂时不能发帖，
        <a href="login.php?from='.$curpage.'&'.$query.'">[登录请点击这里]</a>';
    echo '</div>';
    require'inc/footer.inc.php';
    exit;
}
//////////process submit
if(isset($_POST[submit]))
{
    if(empty($_POST[title]) || empty($_POST[content]))
    {
        $error='请将主题和内容填写完整';
    }
    else
    {
        $subject=trim($_POST[title]);
        $message=trim($_POST[content]);
        $forumid=$_POST[forumid];
        $needDB=true;
        require'inc/getdb.inc.php';
        $sql='select id from users where username="'.$_SESSION[username].'" 
                    and password="'.$_SESSION[password].'"';
        $results=$mysqli->query($sql);
        $row=$results->fetch_object();
        $userid=$row->id;
        
        $sql='insert into topics
                (forum_id,dateposted,subject,user_id)
                values
                ('.$forumid.',now(),"'.$subject.'",'.$userid.')';
        $results=$mysqli->query($sql);
        $topicid=$mysqli->insert_id;
        $sql='insert into messages
                (topic_id,body,dateposted,user_id)
                values
                ('.$topicid.',"'.$message.'",now(),'.$userid.')';
        $results=$mysqli->query($sql);
        header("Location:$cfg_sitedir".'viewforum.php?id='.$forumid);
        exit;
        
    }
}
//////////////////////
require'inc/header.inc.php';
if($error)
{
    echo '<div class="error">'.$error.'</div>';
}
?>
<form action='' method='post'>
<div>
    <label for='title'>主题：</label>
    <input type='text' name='title' id='title' />
</div>
<div>
    <div><label for='content'>内容：</label></div>
    <div><textarea rows='15' cols='70' name='content' id='content'>
    </textarea></div>
</div>
<div>
    <input type='hidden' name='forumid' value='<?php echo $_GET[forumid]; ?>' />
    <input type='submit' name='submit' value='发帖' />
</div>
</form>
<?php
require'inc/footer.inc.php';
?>