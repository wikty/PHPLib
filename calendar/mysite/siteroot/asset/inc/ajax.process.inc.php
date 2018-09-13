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
    "event_view"=>array(
                    "object"=>"Calendar",
                    "method"=>"displayEvent"
                    ),
    "event_create"=>array(
                    "object"=>"Calendar",
                    "method"=>"displayForm"
                  ),
    "event_edit"=>array(
                    "object"=>"Calendar",
                    "method"=>"processForm"
                  ),
     "event_delete"=>array(
                    "object"=>"Calendar",
                    "method"=>"confirmDelete"
                    )
 );
 if(isset($actions[$_POST['action']]))
 {
    $tool_box=$actions[$_POST['action']];
    $obj=new $tool_box["object"]($db);
    $method=$tool_box["method"];
    if(isset($_POST['event_id']))
    {
        $id=(int)$_POST['event_id'];
    }else
    {
        $id=null;
    }
    echo $obj->$method($id);
    
}
else
{
   echo "you method is not event_view, can not access";
}
 ?>