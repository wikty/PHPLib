
<form action='' method='post' class="myform">
        <span class="prompt">如果你还没有注册，</span>
        <a href="register.php">
            <strong>请单击这里</strong>
        </a>
    <fieldset class="frame">
        <legend>登录</legend>

        <div>
            <label for='username'>
                用户名:
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
                密码:
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
            <input type='submit' value='登录' name='submit' id='submit' />
        </div>
    </fieldset>
</form>