<?php
include('config.php');
//include(APP_INC_DIR.'authenicate.inc.php');
include(APP_INC_DIR.'authenicate_encrypt.inc.php');

if(is_authenicated(APP_AUTHENICATE_KEY))
{
    header("Location:".APP_ROOT_URL);
    exit;
}

$fields = array('username'=>'name','password'=>'pwd','rpassword'=>'rpwd','submit'=>'reg');

if(isset($_POST[$fields['submit']]))
{
    $error=array();
    $usernameminimum=8;
	
    if(!empty($_POST[$fields['username']])&&
	   !empty($_POST[$fields['password']])&&
	   !empty($_POST[$fields['rpassword']]))
	{
	    $username=trim($_POST[$fields['username']]);
	    $password=trim($_POST[$fields['password']]);
	    $rpassword=trim($_POST[$fields['rpassword']]);

	    // check username syntax
	    if(strlen($username)<$usernameminimum)
        {
             $error[]="username length at least be $usernameminimum";
        }
        if(preg_match('/\s/',$username))
        {
            $error[]='username cannot include spaces.';
        }
        // check password
        if($password!=$rpassword)
        {
            $error[]='retype password is not same with password.';
        }
        
        // check user and password depth
        if(empty($error))
        {
            require_once(APP_INC_DIR.'db.inc.php');
            if(user_existed($username))
            {
                $error[]="username $username is existed, please pick another one";
            }
            else
            {
                require_once(APP_INC_DIR.'password_validate.class.inc.php');
                $checkpwd=new PasswordValidate($password);
                //$checkpwd->allowSpaces();
                //$checkpwd->requireMixedCase();
                //$checkpwd->requireNumbers(3);
                //$checkpwd->requireSymbols();
                $pwdOK=$checkpwd->check();
                if(!$pwdOK)
                {
                    $error=$checkpwd->getMessages();
                }
                else
                {
                    // encrypt password
                    require_once(APP_INC_DIR.'slat_encrypt.class.inc.php');
                    $my_encrypt=new SlatEncrypt($password);
                    $password=$my_encrypt->getEncryptedData();

                    if(!user_save($username, $password))
                    {
                        $error[]='there is something wrong with our site , please try later.';   
                    }
                    else
                    {
                        $success="you register successfully, <p>please <a href='";
                        $success.=APP_SIGNIN_URL."'>Click Here</a> to log in.</p>";
                    }
                }
            }
        }
     }
	else
	{
	    $error[]='please completable information.';
	    if(empty($_POST[$fields['username']]))
	    {
	        $error[]='please fill username';
	    }
	    if(empty($_POST[$fields['password']]))
	    {
	        $error[]='please fill password';
	    }
	    if(empty($_POST[$fields['username']]))
	    {
	        $error[]='please fill retype password';
	    }
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
    if(isset($success))
    {
        echo $success;
    }
    else if(isset($error))
    {
        echo "<ol class='error'>";
        foreach($error as $item)
        {
            echo "<li>$item</li>";
        }
        echo "</ol>";
    }
    ?>
        <form action='' method='post'>
        <label for='name'>Name:</label>
        <input type='text' name='<?php echo $fields["username"]; ?>' id='name' />
        <label for='pwd'>Password:</label>
        <input type='password' name='<?php echo $fields["password"]; ?>' id='pwd' />
        <label for='rpwd'>Retype Password:</label>
        <input type='password' name='<?php echo $fields["rpassword"]; ?>' id='rpwd' />
        <input type='submit' value='Register' name='<?php echo $fields["submit"]; ?>' id='reg' />
        </form>
    </body>
</html>
