<?php
    include_once"../sys/cookie_data.php";
    define(TITLE,"Log Out");
    $mystr="";
    if(isset($_COOKIE[$cookie_name]))
    {
        setcookie($cookie_name,false,time()-100);
        $mystr="<h2>you had logged out</h2>";
    }
    include_once"templates/header.php";
    if(!empty($mystr))
    {
        echo $mystr;
    }
    else
    {
        echo "<p>you don't logged in , so you don't need log out!</p>";
    }

    include_once"templates/footer.php";
 ?>