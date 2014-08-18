<?php 
 if(isset($_GET['event_id']))
 {
    $id=preg_replace("/[^0-9]/","",$_GET['event_id']);
    if(empty($id))
    {
        header("Location:./");
        exit;
    }
 }
 else
 {
    header("Location:./");
    exit;
 }  
 include_once("../sys/core/init.inc.php");
 $page_title="Event View";
 $css_files=array("style.css","admin.css");
 include_once("asset/common/header.inc.php");
 ?>
 <div id="content">
 <?php
    $cal=new Calendar($db);
    echo $cal->displayEvent($id);
  ?>
  <a href="./" >&laquo; Back to the Calendar.</a>
 </div>
 <?php 
    include_once("asset/common/footer.inc.php");
  ?>