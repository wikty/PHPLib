<?php
$needDB=true;
require_once'config/mysite.cfg.php';
require_once'inc/getdb.inc.php';
if(isset($_GET['useremail']) && isset($_GET['verifystring']))
{
    $email=addslashes(urldecode($_GET['useremail']));
    $verifystring=addslashes(urldecode($_GET['verifystring']));
    $sql='SELECT email,verifystring,id 
        FROM users
        WHERE email="'.$email.'" 
        AND verifystring="'.$verifystring.'"';
    $results=$mysqli->query($sql);
    $num_rows=$results->num_rows;
    if($num_rows)
    {
        $row=$results->fetch_object();
        $sql='UPDATE users SET active=1 WHERE id='.$row->id;
        $results=$mysqli->query($sql);
        $affected_rows=$results->affected_rows;
        echo '�����˻��Ѿ�ע��ɹ�����Ҫ��¼�� '.'[<a href="login.php">��¼</a>]';
    }
    else
    {
        echo '���������֤����������������';
    }
}
else
{
    echo '��������ҳ��ķ�������ȷ';
}
?>