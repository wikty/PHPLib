<?php
session_start();
 if(!isset($_POST['event_id'])||!isset($_SESSION['user']))
 {
    header("Location:./");
    exit;
 }
 else
 {
    $id=(int)$_POST['event_id'];
 }
 include_once"../sys/core/init.inc.php";
 $cal=new Calendar($db);
 $temp=$cal->confirmDelete($id);
 //��������ҳͷ֮ǰִ�У���Ϊ�ú��������п��ܻ����header���������������ȴһ��Ҫд��ҳͷ�ĺ��棬�����Ƚ�����ڱ�����
 
 $page_title="Confirm Delete";
 $css_files=array("style.css","admin.css");
 include_once"asset/common/header.inc.php";
 ?>
 <div id="content">
 <?php echo $temp; ?>
 </div>
 <?php
 include_once"asset/common/footer.inc.php";
 ?>