<?php
 include"../inc/connectMoviesite.php";
 if(!isset($_GET['confirm']))
 {
    switch($_GET['type'])
    {
        case 'people':
            echo "<strong>Are you sure delete this people,";
            break;
        case 'movie':
            echo "<strong>Are you sure delete this movie,";
            break;
    }
    $type=$_GET['type'];
    $id=$_GET['id'];
    echo "<a href='delete.php?confirm=1&id=$id&type=$type'>Yes</a> or <a href='admin.php'>No,back home page.</a></strong>";
 }
 else
 {
    switch($_GET['type'])
    {
        case 'people':
            $cmd="update movie set movie_leadactor=0 where movie_leadactor=".$_GET['id'];
            mysql_query($cmd,$sv) or die(mysql_error($sv));
            $cmd="update movie set movie_director=0 where movie_director=".$_GET['id'];
            mysql_query($cmd,$sv)or die(mysql_error($sv));
            $cmd="delete from moviepeople where moviepeople_id=".$_GET['id'];
            mysql_query($cmd,$sv) or die(mysql_error($sv));
            echo "people had delete ! get back to <a href='admin.php'>home page</a>";
            break;
        case 'movie':
            $cmd="delete from movie where movie_id=".$_GET['id'];
            mysql_query($cmd,$sv) or die(mysql_error($sv));
            echo "movie had delete ! get back to <a href='admin.php'>home page</a>";
            break;
    }
 }
 ?>