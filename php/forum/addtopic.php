<?php
/////check login
session_start();
require'config/mysite.cfg.php';
$needDB=true;
require'inc/getdb.inc.php';
if(!(isset($_SESSION['username']) && isset($_SESSION[password])))
{
    require'inc/header.inc.php';
    $curpage=basename($_SERVER[SCRIPT_NAME]);
    $query=$_SERVER[QUERY_STRING];
    echo '<div class="notice">��û�е�¼��������ʱ���ܷ�����
        <a href="login.php?from='.$curpage.'&'.$query.'">[��¼��������]</a>';
    echo '</div>';
    require'inc/footer.inc.php';
    exit;
}
//////////process submit
if(isset($_POST[submit]))
{
    if(empty($_POST[title]) || empty($_POST[content]) || empty($_POST[forumid]))
    {
        $error='�뽫��д����';
    }
    else
    {
        $subject=trim($_POST[title]);
        $message=trim($_POST[content]);
        $forumid=$_POST[forumid];
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
<?php
if(isset($_GET[forumid]))
{
    echo '<input type="hidden" name="forumid" value="'.$_GET[forumid].'" />';
}
else
{
    $sql='select id,name from forums';
    $results=$mysqli->query($sql);
    echo '<label for="forumid">ѡ��һ�����</label>';
    echo '<select name="forumid" id="forumid">';
    echo '<option value="">ѡ��һ�����----</option>';
    while($row=$results->fetch_object())
    {
        echo '<option value="'.$row->id.'">'.$row->name.'</option>';
    }
    echo '</select>';
}
?>
</div>
<div>
    <label for='title'>���⣺</label>
    <input type='text' name='title' id='title' />
</div>
<div>
    <div><label for='content'>���ݣ�</label></div>
    <div><textarea rows='15' cols='70' name='content' id='content'>
    </textarea></div>
</div>
<div>
    <input type='submit' name='submit' value='����' />
</div>
</form>
<?php
require'inc/footer.inc.php';
?>