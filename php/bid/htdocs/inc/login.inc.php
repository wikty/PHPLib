<?php
$prologin='login.php';
if(isset($_GET[timeout]))
{
    echo '<p class="notice">you leave so long that auto log out.</p>';
    if(isset($_SERVER[QUERY_STRING]))
    {
		$prologin.='?'.$_SERVER[QUERY_STRING];
    }
}
?>
<form action='<?php echo $prologin; ?>' method='post' class="myform">
        <span class="prompt">If you aren't a register,please register first.
			<a href="register.php">
				<strong>Click  Here To Register</strong>
			</a>
        </span>
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
            <input type='submit' value='Submit' name='submit' id='submit' class="button" />
        </div>
    </fieldset>
</form>