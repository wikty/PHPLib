<?php
require_once'config/blog.cfg.php';
session_start();
if(isset($_SESSION[username]) && isset($_SESSION[password]))
{
    header("Location:$cfg_sitedir");
    exit;
}
if($_POST[submit])
{
    $username=trim($_POST[username]);
    $password=trim($_POST[password]);
    $sql='SELECT username,password
            FROM usersinfo
            WHERE username="'.$username.'"
            AND password="'.$password.'"';
    $mysqli=new mysqli($cfg_db_host,$cfg_db_user,$cfg_db_password,$cfg_db_dbname);
    $results=$mysqli->query($sql);
    $row=$results->fetch_object();
    $num_rows=$results->num_rows;
    if($num_rows==0)
    {
        echo 'you not register,if you want register please <a href="register/register.php">Click Here</a>';
        exit;
    }
    else
    {
        $_SESSION['username']=$_POST['username'];
        $_SESSION['password']=$_POST['password'];
        header("Location:$cfg_sitedir");
        exit;
    }
}
else
{
    require_once'inc/header.inc.php';
}
?>
<form action='' method='post' class='myform'>
    <fieldset>
        <legend>Log In&nbsp;:&nbsp;</legend>
        <label for='name'>Name:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
        <input type='text' name='username' id='username' /><br/><br/>
        <lable for='password'>Password:</label>
        <input type='password' name='password' id='password' /><br/><br/>
        <input type='submit' name='submit' value='Log In' />
    </fieldset>
</form>
<?php
require_once'inc/footer.inc.php';
?>