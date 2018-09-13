<?php
    define(TITLE,'Delete Quote');
    include_once"templates/header.php";
    echo "<h2>Delete Quote</h2>";
    if(!is_administrator())
    {
        echo "<h2>Access Denined!</h2><p class='error'>you do not have permission to access to this page!</p>";
        include_once"templates/footer.php";
        exit;
    }
    if(isset($_POST['id']))
    {
        if($_POST['submit']=="No,Just Kidding")
        {
            echo "you do not delete the quote.";
        }
        else
        {
            include_once"../sys/mysql_connect.php";
            $query="delete from myquotes where quote_id=".$_POST['id'];
            if(mysql_query($query,$sv))
            {
                echo "you had deleted the quote.";
            }
            else
            {
                echo "<p class='error'>there is something wrong ,because:<br/>";
                echo mysql_error($sv)." When the query:$query is running.";
            }
            mysql_close($sv);
        }
    }
    elseif(isset($_GET['id'])&&is_numeric($_GET['id'])&&($_GET['id']>0))
    {
        $id=$_GET['id'];
        include_once"../sys/mysql_connect.php";
        $query="select quote,source,favorite from myquotes where quote_id=".$id;
        if($results=mysql_query($query,$sv))
        {
            $row=mysql_fetch_assoc($results);
            echo "<form action='delete_quote.php' method='post'>";
            echo "<p>Are you sure to delete this quote?</p>";
            echo "<div><blockquote>$row[quote]&nbsp;&nbsp;---$rew[source]<br/>";
            if($row[favorite]==1)
            {
                echo "<strong>Favorite</strong>";
            }
            echo "</div>";
            echo "<input type='hidden' name='id' value='".$id."' /><br/>";
            echo "<input type='submit' name='submit' value='Delete Quote' />";
            echo "<input type='submit' name='submit' value='No,Just Kidding' />";
            echo "</form>";
            
        }
        else
        {
            echo "<p class='error'>there is something wrong ,because:<br/>";
            echo mysql_error($sv)." When the query:$query is running.";
        }
        mysql_close($sv);
    }
    else
    {
        echo "<p class='error'>you id is illegal</p>";
    }
    
    
    include_once"templates/footer.php";
 ?>