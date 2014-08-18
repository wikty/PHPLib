<?php
$needDB=true;
require_once'inc/tologin.inc.php';
require_once'config/blog.cfg.php';
if(isset($_POST[submit]))
{
    $id=$_POST[entryid];
    $subject=$_POST[subject];
    $body=$_POST[body];
    $cat_id=$_POST[cat];
    if(!isset($subject) || !isset($body) || !isset($cat_id))
    {
        header("Location:http://$_SERVER[HTTP_HOST]".'/'."{$cfg_sitepath}updateentry.php?id=$id");
        exit;
    }
    else
    {
        require_once'inc/getdb.inc.php';
        if(isset($_POST[dateposted]))
        {
            $sql="UPDATE entries
                    SET cat_id=$cat_id,
                    subject='".$subject."',
                    body='".$body."',
                    dateposted=now()
                    WHERE id=$id";   
        }
        else
        {
            $sql="UPDATE entries
                    SET cat_id=$cat_id,
                    subject='".$subject."',
                    body='".$body."'
                    WHERE id=$id";  
        }
        $results=$mysqli->query($sql);
        header("Location:http://$_SERVER[HTTP_HOST]".'/'."{$cfg_sitepath}viewentry.php?id=$id");
        exit;
    }
}
else
{
    if(isset($_GET[id]) && is_numeric($_GET[id]))
    {
        $entryid=abs($_GET[id]);
        require_once'inc/getdb.inc.php';
        $sql="SELECT *
                FROM entries
                WHERE id=$entryid";
        $results=$mysqli->query($sql);
        if(($num_rows=$results->num_rows)==1)
        {
            $row=$results->fetch_object();
            $cat_id=$row->cat_id;
            $dateposted=$row->dateposted;
            $subject=$row->subject;
            $body=$row->body;
        }
        else
        {
            header("Location:$cfg_sitedir");
            exit;
        }
    }
    else
    {
        header("Location:$cfg_sitedir");
        exit;
    }
    require_once'inc/header.inc.php';
}
?>
<form action='' method='post' class='myform'>
    <fieldset>
        <legend>Update Entry : </legend>
        <label for='subject'>Subject:</label>
        <input type='text' name='subject' id='subject' value='<?php echo $subject; ?>' /><br></br>
        <label for='dateposted'>UpdatePostedDate:</label>
        <input type='checkbox' checked='checked' name='dateposted' id='dateposted' /><br/>
        <label for='cat'>Categories:</label>
        <select id='cat' name='cat'>
            <option value=''>Select a category</option>
        <?php
            $sql='SELECT * FROM categories';
            $results=$mysqli->query($sql);
            while($row=$results->fetch_object())
            {
                if($row->id==$cat_id)
                {
                    echo "<option value='".$row->id."' selected='selected'>$row->cat</option>";
                }
                else
                {
                    echo "<option value='".$row->id."'>$row->cat</option>";
                }
            }
        ?>
        </select>
        <br></br>
        <label for='body'>Entry:&nbsp;&nbsp; </label>
        <textarea name='body' id='body' rows='20' cols='70'><?php echo $body; ?></textarea>
        <br></br>
        <input type='hidden' name='entryid' id='entryid' value='<?php echo $entryid; ?>' />
        <input type='submit' value='Submit' name='submit' id='submit' />
    </fieldset>
</form>
<?php
require_once'inc/footer.inc.php';
?>