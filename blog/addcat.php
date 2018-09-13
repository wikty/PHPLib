<?php
require_once'inc/tologin.inc.php';
$error='';
if(isset($_POST[submit]))
{
    if(isset($_POST[catname]))
    {
        require_once'config/blog.cfg.php';
        require_once'inc/getdb.inc.php';
        $sql='INSERT INTO categories
                (cat)
                VALUES
                ("'.$_POST[catname].'")';
        $results=$mysqli->query($sql);
        header("Location:http://$_SERVER[HTTP_HOST]".'/'."{$cfg_sitepath}viewcat.php?all=true");
    }
    else
    {
        require_once'inc/header.inc.php';
        $error='you should fill category.';
    }

}
else
{
    require_once'inc/header.inc.php';
}
if($error)
{
    echo '<p class="error">'.$error.'</p>';
}
?>
<form action="" method="post">
    <label for="catname">Category Name:</label>
    <input type="text" name="catname" id="catname" />
    <input type="submit" name="submit" value="Add Category" />
</form>
<?php
require_once'inc/footer.inc.php';
?>