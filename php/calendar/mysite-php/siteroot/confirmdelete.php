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
 //此行须在页头之前执行，因为该函数里面有可能会调用header，但是里面的内容却一定要写在页头的后面，所以先将其存在变量中
 
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