<?php
    define(TITLE,'Add quote');
    include_once"templates/header.php";
    echo "<h2>Add a quote.</h2>";
    if(!is_administrator())
    {   
        echo "<h2>Access Denined!</h2><p class='error'>you do not have permission to access to this page!</p>";
        include_once"templates/footer.php";
        exit;
    }
    if($_SERVER[REQUEST_METHOD]=="POST")
    {
        if(!empty($_POST['source'])&&!empty($_POST['quote']))
        {
            include_once"../sys/mysql_connect.php";
            $mysource=mysql_real_escape_string(trim(stripslashes($_POST['source'])));
            $myquote=mysql_real_escape_string(trim(stripslashes($_POST['quote'])));
            if(isset($_POST['favorite']))
            {
                $myfavorite=1;
            }
            else
            {
                $myfavorite=0;
            }
            $query="insert into myquotes
                (quote,source,favorite)
                values
                ('".$myquote."','".$mysource."',".$myfavorite.")";
            mysql_query($query,$sv);
            if(mysql_affected_rows($sv)==1)
            {
                echo "<p>you had add a quotation!</p>";
            }
            else
            {
     echo "<p class='error'>Could not store the quote because:<br/>".mysql_error($sv)."</p><p>The query being running is".$query."</p>";
            }
            mysql_close($sv);
        }
        else
        {
            echo "<p class='error'>please input a quotation and source</p>";
        }
    }
    $quote="";
    $favorite="";
    $source="";
    if(isset($_POST['quote']))
    {
        $quote=$_POST['quote'];
    }
    if(isset($_POST['favorite']))
    {
        $favorite=$_POST['favorite'];
    }
    if(isset($_POST['source']))
    {
        $source=$_POST['source'];
    }
 ?>
 <form action="add_quote.php" method="post">
    <p><label>Quote<textarea rows="5" cols="30" name="quote"><?php echo $quote; ?></textarea></label></p>
    <p><label>Source<input type="text" name="source" <?php echo "value='".$source."'"; ?> /></label></p>
    <p><label>Is this a favorite?<input type="checkbox" name="favorite" <?php if($favorite==1) echo "checked='checked'"; ?> /></label></p>
    <p><input type="submit" name="submit" value="Add Quote" /></p>
</form>
 <?php   
    include_once"templates/footer.php";
 ?>