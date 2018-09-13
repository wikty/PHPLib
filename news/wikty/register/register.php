<?php
$error=array();
$usernameminimum='8';
$usersdata=realpath('../usersdata/usersdata.txt');
$homepage='../index.php';
$myform=array('username'=>'name','password'=>'pwd','rpassword'=>'rpwd','submit'=>'reg');
if(isset($_POST[$myform['submit']]))
{
	if(!empty($_POST[$myform['username']])&&!empty($_POST[$myform['password']])
	    &&!empty($_POST[$myform['rpassword']]))
	{
	    $username=$_POST[$myform['username']];
	    $password=$_POST[$myform['password']];
	    if(strlen($username)<$usernameminimum)
        {
             $error[]="username length at least be $usernameminimum.";
        }
        if(preg_match('/\s/',$username))
        {
            $error[]='username cannot include spaces.';
        }
        if($_POST[$myform['password']]!=$_POST[$myform['rpassword']])
        {
            $error[]='retype password is not same with password.';
        }
//base information check end
        if(empty($error))
        {
            require_once'processuser.php';
            $checkUser=checkUsername($usersdata,$username);
            if($checkUser[0])
            {
                require_once'my_checkpassword.class.php';
                $checkpwd=new my_checkpassword($password);
                 //$checkpwd->allowSpaces();
                 //$checkpwd->requireMixedCase();
                 //$checkpwd->requireNumbers(3);
                 //$checkpwd->requireSymbols();
                $pwdOK=$checkpwd->check();
                if($pwdOK)
                {
                    $OK=saveUser($usersdata,$username,$password);
                    if($OK)
                    {
                        $success='you register successfully';
                    }
                    else
                    {
                        $error[]='there is something wrong with our site , please try later.';
                    }
                }
                else
                {
                    $error=$checkpwd->getMessages();
                }
            }
            else
            {
                $error[]=$checkUser[1];
            }
        }
     }
	else
	{
	    $error[]='please completable information.';
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
    if($success)
    {
        echo $success;
    }
    else
    {
        echo "<ol>";
        foreach($error as $item)
        {
            echo "<li>$item</li>";
        }
        echo "</ol>";
    }
    ?>
        <form action='' method='post'>
        <label for='name'>Name:</label>
        <input type='text' name='name' id='name' />
        <label for='pwd'>Password:</label>
        <input type='password' name='pwd' id='pwd' />
        <label for='rpwd'>Retype Password:</label>
        <input type='password' name='rpwd' id='rpwd' />
        <input type='submit' value='Register' name='reg' id='reg' />
        </form>
    </body>
</html>