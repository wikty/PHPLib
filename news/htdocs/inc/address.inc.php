<form action='' method='post' class="myform">
    <fieldset class="frame">
		<fieldset class="personal">
        <legend>Address Form</legend>
        <span class="prompt">
            The Field Marked <span class="error">*</span> Is Must Be Filled
        </span>
        <div>
            <?php
        if($_POST && ($missing || $errors))
        {
            echo '<span class="error">please fixed follow error fields</span>';
        }
        ?>
        </div>
        <div>
                <label for='surname'>
                    <span class="error">*</span>Surname:
                
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
elseif(isset($surname) && !empty($surname))
{
	echo $surname;
}
?>' />
            </div>
            <div>
                <label for='name'>
                    <span class="error">*</span>Fullname:
                
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
elseif(isset($name) && !empty($name))
{
	echo $name;
}
?>' />
            </div>
            <div>
                <label for='addr1'>
                    <span class="error">*</span>Address:
               
<?php
        if($_POST && $missing && in_array('addr1',$missing))
        {
            echo '<span class="error">Please Enter Address</span>';
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
elseif(isset($addr1) && !empty($addr1))
{
echo $addr1;
}
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
        else
        {
			echo '<span class="prompt">(is a alternate address,be optional)</span>';
        }
        ?>
                </label>
                <input type='text' name='addr2' id='addr2' value='<?php if($_POST && $errors && isset($_POST[addr2])) 
    echo $_POST[addr2]; 
    elseif(isset($addr2) && !empty($addr2))
    {
    echo $addr2;
    }
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
       else
        {
			echo '<span class="prompt">(is a alternate address,be optional)</span>';
        }
?>
                </label>
                <input type='text' name='addr3' id='addr3' value='<?php 
if($_POST && $errors && isset($_POST[addr3])) 
    echo $_POST[addr3];
elseif(isset($addr3) && !empty($addr3))
{
    echo $addr3;
}
?>' />
            </div>
            <div>
                <label for='postcode'>
                    <span class="error">*</span>Postcode:
                
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
elseif(isset($postcode) && !empty($postcode))
{
echo $postcode;
}
?>' />
            </div>
            <div>
                <label for='phone'>
                    <span class="error">*</span>Phone Number:
                
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
elseif(isset($phone) && !empty($phone))
{
echo $phone;
}
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
elseif(isset($email) && !empty($email))
{
echo $email;
}
?>' />
            </div>
            </fieldset>
        <div>
        <?php
        if(isset($_GET[modify]))
        {
			echo '<input type="hidden" name="modify" value="true" />';
			echo '<input type="hidden" name="deliveryid" value="'.$deliveryid.'" />';
        }
        ?>
            <input type="submit" name="submit" value="GoPay" id="submit" />
        </div>
        
    </fieldset>
</form>
  