<?php
 session_start();
 include_once "../../../sys/config/db_params.inc.php";
 include_once "../../../sys/class/class.calendar.inc.php";
 include_once "../../../sys/class/class.admin.inc.php";
 //include_once "../../../sys/class/class.event.inc.php";
 //include_once "../../../sys/class/class.db_connect.inc.php";
 foreach($params as $key=>$value)
 {
    define($key,$value);
 }
 $dns="mysql:host=".DB_HOST.";dbname=".DB_NAME;
 $db=new PDO($dns,DB_USER,DB_PASS);
 $actions=array(
    "event_edit"=>array(
                    "object"=>"Calendar",
                    "method"=>"processForm",
                    "header"=>"Location:../../"),
    "user_login"=>array(
                    "object"=>"Admin",
                    "method"=>"processLogInForm",
                    "header"=>"Location:../../"),
    "user_logout"=>array(
                    "object"=>"Admin",
                    "method"=>"processLogOut",
                    "header"=>"Location:../../"
    )
 );
 if($_POST['token']==$_SESSION['token']&&isset($actions[$_POST['action']]))
 {
    $tool_box=$actions[$_POST['action']];
    $obj=new $tool_box["object"]($db);
    $method=$tool_box["method"];
    if(true===($msg=$obj->$method()))
    {
        header($tool_box['header']);
    }
    else
    {
        die($msg);
    }
 }
 else
 {
    header("Location:./");
    exit;
 }
 ?>