<?php
    define(TITLE,'Edit Quote');
    include_once"templates/header.php";
    echo "<h2>Edit Quote</h2>";
    if(!is_administrator())
    {
        echo "<h2>Access Denined!</h2><p class='error'>you do not have permission to access to this page!</p>";
        include_once"templates/footer.php";
        exit;
    }
    if($_SERVER[REQUEST_METHOD]=="POST")
    {
        $postid=(int)$_POST['id'];
        if(isset($_POST[favorite]))
        {
            $favorite=1;
        }
        else
        {
            $favorite=0;
        }
        $quote=htmlentities(stripslashes(trim($_POST['quote'])));
        $source=htmlentities(stripslashes(trim($_POST['source'])));
        if(!empty($quote)&&!empty($source))
        {
            include_once"../sys/mysql_connect.php";
            $query="update myquotes set quote='$quote',source='$source',favorite=$favorite where quote_id=$postid";
            mysql_query($query,$sv);
            if(mysql_affected_rows($sv)==1)
            {
                 echo "alter successed!";
            }
            else
            {
                echo "<p class='error'>Could not edit the quote because:<br/>".mysql_error($sv);
                echo "</p><p>The query being running is".$query."</p>";
            }
            mysql_close($sv);
        }
        else
        {
            echo "<p class='error'>please input quote and source.</p>";
        }
    }
    else
    {
        
        if(isset($_GET['id'])&&is_numeric($_GET['id'])&&($_GET['id']>0))
        {   
            include_once"../sys/mysql_connect.php";
            $id=$_GET['id'];
            $query="select quote,source,favorite from myquotes where quote_id=".$id;
            $results=mysql_query($query,$sv);
            if($row=mysql_fetch_assoc($results))
            {
                $check="";
                if($row[favorite]==1)
                {
                    $check="checked=\"checked\"";
                }
                $myform="";
                $myform.="<form action='edit_quote.php' method='post'>";
                $myform.="<p><label>Quote<textarea rows=\"5\" cols=\"30\" name=\"quote\">$row[quote]</textarea></label></p>";
                $myform.="<p><label>Source<input type=\"text\" name=\"source\" value=\"$row[source]\" /></label></p>";
                $myform.="<p><label>Is this a favorite?";
                $myform.="<input type=\"checkbox\" name=\"favorite\"".$check." /></label></p>";
                $myform.="<input type='hidden' name='id' value='".$id."' />";
                $myform.="<p><input type=\"submit\" name=\"submit\" value=\"Edit Quote\" /></p>";
                echo $myform;;
            }
            else
            {
                echo "<p class='error'>there is no quote that you want edit. $id";
            }
            mysql_close($sv);
        }
        else
        {
            echo "<p class='error'>you can not edit quote,because you don't identy a id .";
        }
    }
    include_once"templates/footer.php";
 ?>