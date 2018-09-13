<?php
include('config.php');
//include(APP_INC_DIR.'authenicate.inc.php');
include(APP_INC_DIR.'authenicate_encrypt.inc.php');

if(is_authenicated(APP_AUTHENICATE_KEY))
{
    header("Location:".APP_ROOT_URL);
    exit;
}

$fields = array(
    'submit'=>'login',
    'username'=>'name',
    'password'=>'pwd',
    'from_url'=>'fromurl'
);

if(isset($_POST[$fields['submit']]))
{
    $error='';
	if(!empty($_POST[$fields['username']])&&!empty($_POST[$fields['password']]))
	{
        $username=trim($_POST[$fields['username']]);
        $password=trim($_POST[$fields['password']]);

        require_once(APP_INC_DIR."db.inc.php");
        //require_once(APP_INC_DIR."authenicate.inc.php");
        require_once(APP_INC_DIR.'slat_encrypt.class.inc.php');
        require_once(APP_INC_DIR.'authenicate_encrypt.inc.php');
        
        $usersinfo = fetch_users();
        if(authenicate($usersinfo, $username, $password))
        {
            if(!isset($_SESSION))
            {
                session_start();
            }
            // Authenicate key
            $_SESSION[APP_AUTHENICATE_KEY]='ok';
            // Session time
            $_SESSION[APP_SESSION_TIME_KEY]=time();
            // Username
            $_SESSION['username']=$username;
            if(isset($_POST[$fields['from_url']]))
            {
                header("Location:".$_POST[$fields['from_url']]);
                exit;
            }
            header("Location:".APP_ROOT_URL);
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
        if(isset($error))
	    {
	        echo "<div class='error'>$error</div>";
	    }

        if(isset($_GET['session_timeout']))	
        {
            echo '<div class="error">session timeout, so you should sign in again.</div>';
        }
    ?>
        <form action='' method='post'>
            <label for='name'>Name:</label>
            <input type='text' name='<?php echo $fields["username"]; ?>' id='name' />
            <label for='pwd'>Password:</label>
            <input type='password' name='<?php echo $fields["password"]; ?>' id='pwd' />
            <input type='submit' value='Log In' name='<?php echo $fields["submit"]; ?>' id='login' />
            <?php
            if(isset($_GET['from_url']))
            {
                echo '<input type="hidden" name="'. $fields['from_url'] .'" value="'.$_GET['from_url'].'"/>';
            }
            ?>
        </form>
        <p>If you are unregister,please <a href='<?php echo APP_SIGNUP_URL; ?>'>click here.</a></p>
    </body>
</html>