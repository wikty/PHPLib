<?php
$needDB=true;
require_once'inc/tologin.inc.php';
$error='';
if(isset($_POST[submit]))
{
    $subject=$_POST[subject];
    $body=$_POST[body];
    $cat=$_POST[cat];
    echo $cat;
    echo $_POST[cat];
    if(isset($subject) && isset($body) && isset($cat))
    {
        require_once'inc/getdb.inc.php';
        $sql='INSERT INTO entries
                (cat_id,dateposted,subject,body)
                VALUES
                ('.$cat.',now(),"'.$subject.'","'.$bosy.'")';
        //$results=$mysqli->query($sql);
        //$last_id=$mysqli->insert_id;
        header("Location:http://$_SERVER[HTTP_HOST]".'/'."{$cfg_sitepath}viewentry.php?id=$last_id");
        exit;
    }
    else
    {
        $error='please fill subject ,entry,and select a category.';
    }
}
else
{
    require_once'inc/header.inc.php';
    if($error)
    {
        echo '<p class="error">'.$error.'</p>';
    }
?>
<form action='' method='post' class='myform'>
    <fieldset>
        <legend>Add Entry : </legend>
        <label for='subject'>Subject:</label>
        <input type='text' name='subject' id='subject' /><br></br>
        <label for='cat'>Categories:</label>
        <select id='cat' name='cat'>
            <option value=''>Select a category</option>
        <?php
            $sql='SELECT * FROM categories';
            $results=$mysqli->query($sql);
            while($row=$results->fetch_object())
            {
                echo "<option value=$row->id>$row->cat</option>";
            }
        ?>
        </select>
        <br></br>
        <label for='body'>Entry:&nbsp;&nbsp; </label>
        <textarea name='body' id='body' rows='20' cols='70'></textarea>
        <br></br>
        <input type='submit' value='Submit' name='submit' id='submit' />
    </fieldset>
</form>
<?php
    require_once'inc/footer.inc.php';
}
?>