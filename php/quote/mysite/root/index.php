<?php
    define(TITLE,'Home Page');
    include_once"templates/header.php";
    echo "<h2>Home Page</h2>";
    include_once"../sys/mysql_connect.php";
    $query="select quote,source,date_entered from myquotes ";
    if(isset($_GET['favorite']))
    {
        $query.="where favorite=1 order by rand() limit 1";
    }
    elseif(isset($_GET['random']))
    {
        $query.="order by rand() limit 1";
    }
    else
    {
        $query.="order by date_entered limit 1";
    }
    if($r=mysql_query($query,$sv))
    {
        $row=mysql_fetch_assoc($r);
        echo "<div><blockquote>$row[quote]</blockquote>";
        echo "---$row[source]<br/>";
        echo "upload time:$row[date_entered]<br/><br/>";
    }
    else
    {
        echo "<p class='error'>there is something wrong ,because:<br/>";
        echo mysql_error($sv)." When the query:$query is running.";
    }
    mysql_close($sv);
    echo "<a href='index.php?lastest=true'>Lastest</a>&nbsp;|";
    echo "&nbsp;<a href='index.php?random=true'>Random</a>&nbsp;|";
    echo "&nbsp;<a href='index.php?favorite=true'>Favorite</a><br/>";
    include_once"templates/footer.php";
 ?>