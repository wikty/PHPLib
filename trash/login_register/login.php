<?php
$error='';
$homepage='index.php';
$registerurl="register/register.php";

// if logged in, redirect to home page
if(isset($_SESSION['authenicated']))
{
    header("Location:$homepage");
    exit;
}

if(isset($_POST['login']))
{
	if(!empty($_POST['name'])&&!empty($_POST['pwd']))
	{
        $username=trim($_POST['name']);
        $password=trim($_POST['pwd']);
        require_once"db.inc.php";
        require_once"authenicate.inc.php";
        $users = fetch_users();
        if(authenicate($users, $username, $password))
        {
            if(!isset($_SESSION))
            {
                session_start();
            }
            $_SESSION['authenicated']='ok';
            $_SESSION['username']=$username;
            header("Location:$homepage");
            exit;
        }
        else
        {
            $error='username or password is invalid.';
        }
	}
	else
	{
	    $error='please input username and password.';
	}
}

?>
<html>
    <head>
        <title>
            Log In
        </title>
        <style type="text/css">
            .error{
            color:red;
            }
        </style>
    </head>
    <body>
    <?php 
        if($error)
	    {
	        echo "<div class='error'>$error</div>";
	    }	
    ?>
        <form action='' method='post'>
            <label for='name'>Name:</label>
            <input type='text' name='name' id='name' />
            <label for='pwd'>Password:</label>
            <input type='password' name='pwd' id='pwd' />
            <input type='submit' value='Log In' name='login' id='login' />
        </form>
        <p>If you are unregister,please <a href='<?php echo $registerurl; ?>'>click here.</a></p>
    </body>
</html>
