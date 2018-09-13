<?php
    session_start();
    if(!isset($_SESSION['token']))
    {
        $_SESSION['token']=sha1(uniqid(mt_rand(),true));
    }
    include_once"../sys/config/db_params.inc.php";
    include_once"../sys/class/class.calendar.inc.php";
    include_once"../sys/class/class.admin.inc.php";
    //init parameters for db connection.
    foreach($params as $key=>$value)
    {
        define($key,$value);
    }
    //create a pdo object for use.
    $dns="mysql:host=".DB_HOST.";dbname=".DB_NAME;
    $db=new PDO($dns,DB_USER,DB_PASS);
    //creat auot load class file
    function __autoload($class)
    {
        $filename="../sys/class/class.".strtolower($class)."inc.php";
        if(file_exists($filename))
        {
            include_once $filename;
        }
    }
    //spl_autoload_register("my__autoload");
 ?>