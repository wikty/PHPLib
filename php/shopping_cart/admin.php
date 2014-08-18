<?php
session_start();
if(isset($_SESSION[admin]))
{
	header("Location:$cfg_sitedir");
	exit;
}
require_once'config/mysite.cfg.php';
require_once'inc/utility.inc.php';
require_once'inc/connection.inc.php';
$errors=array();
$missing=array();
$requiredFields=array('username','password');
if(isset($_POST[submit]))
{
	$missing=checkRFields($_POST,$requiredFields);
	if(empty($missing))
	{
		$username=$_POST[username];
		$password=$_POST[password];
		require_once'class/my_encrypt.class.php';
		$mysqli=dbConnection('read','mysqli');
		$sql='select password from admins where username=?';
		$stmt=$mysqli->stmt_init();
		$stmt->prepare($sql);
		$stmt->bind_param('s',$username);
		$stmt->execute();
		$stmt->bind_result($edpassword);
		$stmt->store_result();
		if($stmt->num_rows==1)
		{
			$stmt->fetch();
			$myencrypt=new my_encrypt($password);
			$myencrypt->setCheck($edpassword);
			$password=$myencrypt->getEncryptedData();
			if($password==$edpassword)
			{
				$_SESSION[admin]=true;
				header("Location:$cfg_sitedir".'admin_process_orders.php');
				exit;
			}
			else
			{
				$errors['password']='password not match';
			}
		}
		else
		{
			$errors['username']='you is not a administrator,please contract website admin';
		}
	}
}

require_once'inc/header.inc.php';
?>
<form action='' method='post' class="myform">
    <fieldset class="frame">
        <legend>Log-In</legend>

        <div>
            <label for='username'>
                Username:
                <?php
        if($_POST && $missing && in_array('username',$missing))
        {
            echo '<span class="error">Please Enter Username</span>';
        }
        elseif($_POST && $errors && array_key_exists('username',$errors))
        {
            echo '<span class="error">'.$errors['username'].'</span>';
        }
        ?>
            </label>
            <input type='text' name='username' id='username' value='<?php
        if($_POST && ($missing || $errors) && isset($_POST[username]))
        {
            echo $_POST[username];
        }
        ?>' />
        </div>
        <div>
            <label for='password'>
                Password:
                <?php
        if($_POST && $missing && in_array('password',$missing))
        {
            echo '<span class="error">Please Enter Password</span>';
        }
        elseif($_POST && $errors && array_key_exists('password',$errors))
        {
            echo '<span class="error">'.$errors['password'].'</span>';
        }
        ?>
            </label>
            <input type='password' name='password' id='password' />
        </div>
        <div>
            <input type='submit' value='Submit' name='submit' id='submit' />
        </div>
    </fieldset>
</form>
<?php
require_once'inc/footer.inc.php';
?>