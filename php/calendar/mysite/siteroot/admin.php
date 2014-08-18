<?php
session_start();
   if(!isset($_SESSION['user']))
    {
        header("Location:./");
        exit;
    }
 include_once"../sys/core/init.inc.php";
 $page_title="Add | Edit Event";
 $css_files=array("style.css","admin.css");
 include_once"asset/common/header.inc.php";
 ?>
 <div id="content">
 <?php 
    $cal=new Calendar($db);
    echo ($cal->displayForm());
  ?>
 </div>
 <?php 
  include_once"asset/common/footer.inc.php";
  ?>