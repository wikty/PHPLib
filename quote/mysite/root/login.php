<?php
    include_once"../sys/admin_data.php";
    include_once"../sys/cookie_data.php";
    $loggedin=false;
    $error=false;
    if($_SERVER[REQUEST_METHOD]=="POST")
    {
        if(!empty($_POST['email'])&&!empty($_POST['password']))
        {
            $email=strtolower(trim(stripslashes($_POST['email'])));
            $password=strtolower(trim(stripslashes($_POST['password'])));
            if(($email==$admin_email)&&($password==$admin_password))
            {
                setcookie($cookie_name,$cookie_value,time()+3600);
                $loggedin=true;
            }
            else
            {
                $error="please input correctly email and password";
            }
        }
        else
        {
            $error="please input email and password!";
        }
    }
    define(TITLE,"Log In");
    include_once"templates/header.php";
    if($error)
    {
        echo "<p>".$error."</p>";
    }
    if($loggedin)
    {
        echo "<h2>you had logged in !</h2>";
    }
    $myemail="";
    if(isset($_POST['email']))
    {
        $myemail=$_POST['email'];
    }
    $mystr="";
    $mystr.="<form action='login.php' method='post'>";
    $mystr.="<p><label>E-mail:</label><input type='text' name='email' value='".$myemail."' /></p>";
    $mystr.="<p><label>Password:</label><input type='password' name='password' value='' /></p>";
    $mystr.="<p><input type='submit' value='".TITLE."' /></p>";
    echo $mystr;
    include_once"templates/footer.php";
 ?>