<?php
require_once"inc/header.inc.php";
?>
<form action='' method='post' class='myform'>
    <fieldset>
        <legend>Register&nbsp;:&nbsp;</legend>
        <label for='name'>Name:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
        <input type='text' name='username' id='username' /><br/><br/>
        <lable for='password'>Password:</label>
        <input type='password' name='password' id='password' /><br/><br/>
        <lable for='rpassword'>Retype&bnsp;Password:</label>
        <input type='password' name='rpassword' id='rpassword' /><br/><br/>
        <input type='submit' name='submit' value='Register' />
    </fieldset>
</form>
<?php
require_once"inc/footer.inc.php";
?>