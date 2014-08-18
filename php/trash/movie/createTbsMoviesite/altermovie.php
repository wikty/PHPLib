<?php
    include'connectMoviesite.php';
    global $sv;
    $cmd="alter table movie add column(
    movie_running_time tinyint unsigned not null,
    movie_cost decimal(4,1) not null,
    movie_takings decimal(4,1) not null)";
    mysql_query($cmd,$sv) or die(mysql_error($sv));
    $cmd='update movie set movie_running_time=101,
    movie_cost=81,movie_takings=242.6 where movie_id=1';
    mysql_query($cmd,$sv) or die(mysql_error($sv));
    $cmd='update movie set movie_running_time=89,
    movie_cost=10,movie_takings=10.8 where movie_id=2';
    mysql_query($cmd,$sv) or die(mysql_error($sv));
    $cmd='update movie set movie_running_time=134,
    movie_cost=12,movie_takings=33.2 where movie_id=3';
    mysql_query($cmd,$sv) or die(mysql_error($sv));
    echo "movie alter is successed , add movie_running_time,movie_cost,movie_takings";
?>