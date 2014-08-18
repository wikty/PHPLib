<?php
if($_POST && $errors && array_key_exists('special',$errors))
{
	echo '<div class="error">'.$errors['special'][0].'</div>';
}
?>
<form action='' method='post'>
    <fieldset class="frame">
        <legend>Register Form</legend>
        <span class="prompt">
            The Field Marked <span class="required">*</span> Is Must Be Filled
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
            <legend>Basic Information</legend>
            <div>
                <label for='username'>
                    <span class="required">*</span>Username:
                
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
                    <span class="required">*</span>Password:
                
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
                    <span class="required">*</span>Retype Password:
                
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
            <legend>Personal Information</legend>
            <div>
                <label for='surname'>
                    <span class="required">*</span>Surname:
                
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
                    <span class="required">*</span>Fullname:
                
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
                    <span class="required">*</span>Address 1:
               
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
                <label for='addr2'>Address 2:
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
                <label for='addr3'>Address 3:
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
                    <span class="required">*</span>Postcode:
                
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
                    <span class="required">*</span>Phone Number:
                
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
                <label for='email'>E-mail:
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
            <input type="submit" name="submit" value="Submit" id="submit" class="button" />
        </div>
    </fieldset>
</form>
  