<?php
 define(TITLE,'View Quotations');
 include_once"templates/header.php";
 echo "<h2>View Quotations</h2>";
 if(!is_administrator())
 {
    echo "<h2>Access Denined!</h2><p class='error'>you do not have permission to access to this page!</p>";
    include_once"templates/footer.php";
    exit;
 }
 include_once"../sys/mysql_connect.php";
 $query="select quote_id ,quote ,source,favorite,date_entered from myquotes order by date_entered desc";
 if($results=mysql_query($query,$sv))
 {
    while($row=mysql_fetch_assoc($results))
    {
        $mystr="";
        $mystr.="<div><blockquote>".$row['quote']."</blockquote>\n";
        $mystr.="---".$row['source']."<br/>";
        $mystr.="upload time: ".$row['date_entered']."<br/>";
        if($row['favorite']==1)
        {
            $mystr.="<strong>Favorite</strong><br/>\n";
        }
        $mystr.="<p>Admin Quote: <a href='edit_quote.php?id=".$row['quote_id']."' >EDIT</a>\n";
        $mystr.="| <a href='delete_quote.php?id=".$row['quote_id']."' >DELETE</a></p><br/><br/>";
        echo $mystr;
    }
 }
 else
 {
    echo "<p class='error'>Colud not retrieve data beacuse:".mysql_error($sv)."The query being running is ".$query.".";
 }
 
 ?>