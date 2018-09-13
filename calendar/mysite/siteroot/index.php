<?php 
    include_once "../sys/core/init.inc.php";
    //got pdo-object and autoload-function
    $page_title="Events Calendar";
    $css_files=array("style.css","admin.css","ajax.css");
    include_once "asset/common/header.inc.php";
    
 ?>
<div id="content">
<?php
    $cal=new Calendar($db,"2010-01-01 12:00:00");
    echo $cal->buildCalendar();
 ?>
</div>
<p>
<?php 
if(isset($_SESSION['user']))
echo "Log In";
else
echo "Log Out";
?>
</p>
<?php 
 include_once "asset/common/footer.inc.php";
 
 ?>