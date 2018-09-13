<form action='' method='post' class="myform">
    <fieldset class="frame">
        <legend>注册表单</legend>
        <span class="prompt">
            标记为 <span class="error">*</span> 是必填项
        </span>
        <div>
            <?php
        if($_POST && ($missing || $errors))
        {
            echo '<span class="error">please fixed follow error fields</span>';
        }
        ?>
        </div>
        <fieldset class="basic">
            <legend>用户基本信息</legend>
            <div>
                <label for='username'>
                    <span class="error">*</span>用户名:
                
<?php
        if($_POST && $missing && in_array('username',$missing))
        {
            echo '<span class="error">Plesae Enter Username</span>';
        }
        elseif($_POST && $errors && array_key_exists('username',$errors))
        {
            foreach($errors['username'] as $item)
            {
                echo '<span class="error">'.$item.'</span>';
            }
        }
?>
                </label>
                <input type='text' name='username' id='username' value='<?php
if($_POST && ($errors || $missing) && isset($_POST[username]))
    echo $_POST[username]; 

?>' />
            </div>
            <div>
                <label for='password'>
                    <span class="error">*</span>密码:
                
<?php
        if($_POST && $missing && in_array('password',$missing))
        {
            echo '<span class="error">Please Enter Password</span>';
        }
        elseif($_POST && $errors && array_key_exists('password',$errors))
        {
            foreach($errors['password'] as $item)
            {
                echo '<span class="error">'.$item.'</span>';
            }
        }
?>
                </label>
                <input type='password' name='password' id='password'  />
            </div>
            <div>
                <label for='rpassword'>
                    <span class="error">*</span>再次输入密码:
                
<?php
        if($_POST && $missing && in_array('password',$missing))
        {
            echo '<span class="error">Please Retype Password</span>';
        }
        elseif($_POST && $errors && array_key_exists('rpassword',$errors))
        {
            foreach($errors['rpassword'] as $item)
            {
                echo '<span class="error">'.$item.'</span>';
            }
        }
?>
                </label>
                <input type='password' name='rpassword' id='rpassword' />
            </div>
        </fieldset>
        <fieldset class="personal">
            <legend>个人信息</legend>
            <div>
                <label for='surname'>
                    <span class="error">*</span>您的姓:
                
<?php
        if($_POST && $missing && in_array('surname',$missing))
        {
            echo '<span class="error">Please Enter Surname</span>';
        }
        elseif($_POST && $errors && array_key_exists('surname',$errors))
        {
            foreach($errors['surname'] as $item)
            {
                echo '<span class="error">'.$item.'</span>';
            }
        }
?>
                </label>
                <input type='text' name='surname' id='surname' value='<?php
if($_POST && ($errors || $missing) && isset($_POST[surname]))
    echo $_POST[surname]; 
?>' />
            </div>
            <div>
                <label for='name'>
                    <span class="error">*</span>姓名:
                
<?php
        if($_POST && $missing && in_array('name',$missing))
        {
            echo '<span class="error">Please Enter Fullname</span>';
        }
        elseif($_POST && $errors && array_key_exists('name',$errors))
        {
            foreach($errors['name'] as $item)
            {
                echo '<span class="error">'.$item.'</span>';
            }
        }
        ?>
                </label>
                <input type='text' name='name' id='name' value='<?php
if($_POST && ($errors || $missing) && isset($_POST[name]))
    echo $_POST[name]; 
?>' />
            </div>
            <div>
                <label for='addr1'>
                    <span class="error">*</span>地址 1:
               
<?php
        if($_POST && $missing && in_array('addr1',$missing))
        {
            echo '<span class="error">Please Enter Address 1</span>';
        }
        elseif($_POST && $errors && array_key_exists('addr1',$errors))
        {
            foreach($errors['addr1'] as $item)
            {
                echo '<span class="error">'.$item.'</span>';
            }
        }
        ?>
                </label>
                <input type='text' name='addr1' id='addr1' value='<?php
if($_POST && ($errors || $missing) && isset($_POST[addr1]))
    echo $_POST[addr1]; 
?>' />
            </div>
            <div>
                <label for='addr2'>地址 2:
                <?php
        if($_POST && $errors && array_key_exists('addr2',$errors))
        {
            foreach($errors['addr2'] as $item)
            {
                echo '<span class="error">'.$item.'</span>';
            }
        }
        ?>
                </label>
                <input type='text' name='addr2' id='addr2' value='<?php if($_POST && $errors && isset($_POST[addr2])) 
    echo $_POST[addr2]; 
?>' />
            </div>
            <div>
                <label for='addr3'>地址 3:
<?php
        if($_POST && $errors && array_key_exists('addr3',$errors))
        {
            foreach($errors['addr3'] as $item)
            {
                echo '<span class="error">'.$item.'</span>';
            }
        }
?>
                </label>
                <input type='text' name='addr3' id='addr3' value='<?php 
if($_POST && $errors && isset($_POST[addr3])) 
    echo $_POST[addr3]; 
?>' />
            </div>
            <div>
                <label for='postcode'>
                    <span class="error">*</span>邮编:
                
<?php
        if($_POST && $missing && in_array('postcode',$missing))
        {
            echo '<span class="error">Please Enter Postcode</span>';
        }
        elseif($_POST && $errors && array_key_exists('postcode',$errors))
        {
            foreach($errors['postcode'] as $item)
            {
                echo '<span class="error">'.$item.'</span>';
            }
        }
        ?>
                </label>
                <input type='text' name='postcode' id='postcode' value='<?php 
if($_POST && ($errors || $missing) && isset($_POST[postcode])) 
    echo $_POST[postcode]; 
?>' />
            </div>
            <div>
                <label for='phone'>
                    <span class="error">*</span>手机号：
                
<?php
        if($_POST && $missing && in_array('phone',$missing))
        {
            echo '<span class="error">Please Enter Phone Number</span>';
        }
        elseif($_POST && $errors && array_key_exists('phone',$errors))
        {
            foreach($errors['phone'] as $item)
            {
                echo '<span class="error">'.$item.'</span>';
            }
        }
?>
                </label>
                <input type='text' name='phone' id='phone' value='<?php
if($_POST && ($errors || $missing) && isset($_POST[phone]))
    echo $_POST[phone]; 
?>' />
            </div>
            <div>
                <label for='email'>邮箱:
<?php
        if($_POST && $errors && array_key_exists('email',$errors))
        {
            foreach($errors['email'] as $item)
            {
                echo '<span class="error">'.$item.'</span>';
            }
        }
?>
                </label>
                <input type='text' name='email' id='email' value='<?php
if($_POST && ($errors || $missing) && isset($_POST[email]))
    echo $_POST[email]; 
?>' />
            </div>
        </fieldset>
        <div>
            <input type="submit" name="submit" value="注册" id="submit" />
        </div>
    </fieldset>
</form>
  