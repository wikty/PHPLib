<?php
    include"../inc/connectMoviesite.php";
    switch($_GET['action'])
    {
        case 'add':
            switch($_GET['type'])
                {
                    case 'movie':
                    
                        $cmd="insert into movie(movie_id,movie_name,movie_type,movie_year,movie_leadactor,movie_director)
                            values
                            (null, '".$_POST[movie_name]."',".$_POST[movie_type].",".$_POST[movie_year].",".$_POST[movie_leadactor].",".
                            $_POST[movie_director].")";
                        mysql_query($cmd,$sv) or die(mysql_error($sv));
                        header("Location:admin.php");
                        break;
                    case 'people':
                        if(isset($_POST['is_director']))
                        {
                            $is_director=1;
                            $is_actor=0;
                        }
                        else
                        {
                            $is_director=0;
                            $is_actor=1;
                        }
                        $cmd="insert into moviepeople(moviepeople_id,moviepeople_fullname,moviepeople_isactor,moviepeople_isdirector)
                            values(null,'$_POST[people_name]',$is_actor,$is_director)";
                        mysql_query($cmd,$sv) or die(mysql_error($sv));
                        mysql_close($sv);
                        header("Location:admin.php");
                        break;
                }
            break;
        case 'edit':
            switch($_GET['type'])
            {
                case 'movie':
                    $query="update movie set movie_name='$_POST[movie_name]',movie_type=$_POST[movie_type],movie_year=$_POST[movie_year]
                        ,movie_leadactor=$_POST[movie_leadactor],movie_director=$_POST[movie_director] where movie_id=$_POST[id]";
                    mysql_query($query,$sv) or die(mysql_error($sv));
                    mysql_close($sv);
                    header("Location:admin.php");
                    break;
                case 'people':
                    if(isset($_POST['is_director']))
                    {
                        $is_director=1;
                        $is_actor=0;
                    }
                    else
                    {
                        $is_director=0;
                        $is_actor=1;
                    }
                    $query="update moviepeople set moviepeople_fullname='$_POST[moviepeople_fullname]',moviepeople_isactor=$is_actor,
                        moviepeople_isdirector=$is_director where moviepeople_id=$_POST[id]";
                    mysql_query($query,$sv) or die(mysql_error($sv));
                    mysql_close($sv);
                    header("Location:admin.php");
                    break;
            }
            break;
    
    }
    
    
 ?>
 