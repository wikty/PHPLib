<?php
    include'author.php';
    $sv=mysql_connect($host,$user,$psd)or 
    die('Unable to connect database ,please check you connection parameters.');
    mysql_select_db('moviesite',$sv)or 
    die(mysql_error($sv));
    $cmd='SELECT movie_name,movie_type
          FROM movie
          WHERE movie_year>1990
          ORDER BY movie_type';
    $result=mysql_query($cmd,$sv)or die(mysql_error($sv));
    while($row=mysql_fetch_assoc($result))
    {
        extract($row);
        echo $movie_name.'-'.$movie_type.'<br/>';
    }

?>