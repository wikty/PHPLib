<?php
    include'author.php';
    $sv=mysql_connect($host,$user,$psd)or
    die('Unable to connect, please check you connection parameters.');
    mysql_select_db('moviesite',$sv) or die(mysql_error($sv));
    $cmd='CREATE TABLE IF NOT EXISTS movie(
        movie_id INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
        movie_name VARCHAR(255) NOT NULL,
        movie_type TINYINT NOT NULL DEFAULT 0,
        movie_year SMALLINT UNSIGNED DEFAULT 0,
        movie_leadactor SMALLINT UNSIGNED DEFAULT 0,
        movie_director SMALLINT UNSIGNED DEFAULT 0,
        PRIMARY KEY (movie_id),
        KEY movie_type(movie_type,movie_year)
        ) ENGINE=MYISAM auto_increment=1';
     mysql_query($cmd,$sv)or die(mysql_error($sv));
     $cmd='CREATE TABLE IF NOT EXISTS movietype(
        movietype_id TINYINT UNSIGNED NOT NULL AUTO_INCREMENT,
        movietype_label VARCHAR(100) NOT NULL,
        PRIMARY KEY(movietype_id)
     )ENGINE=MYISAM auto_increment=1';
     mysql_query($cmd, $sv)or die(mysql_error($sv));
     $cmd='CREATE TABLE IF NOT EXISTS moviepeople(
        moviepeople_id INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
        moviepeople_fullname VARCHAR(255) NOT NULL,
        moviepeople_isactor TINYINT(1) UNSIGNED NOT NULL DEFAULT 0,
        moviepeople_isdirector TINYINT(1) UNSIGNED NOT NULL DEFAULT 0,
        PRIMARY KEY(moviepeople_id)
        ) ENGINE=MYISAM auto_increment=1';
     mysql_query($cmd,$sv)or die(mysql_error($sv));
    $cmd='create table reviews(
    review_id integer unsigned auto_increment not null,
    review_movie_id integer unsigned not null,
    review_date date not null,
    reviewer_name varchar(255) not null,
    review_comment varchar(255) not null,
    review_rating tinyint unsigned not null default 0,
    primary key(review_id)
    )';
    mysql_query($cmd,$sv) or die(mysql_error($sv));
     echo "movie movietype moviepeople reviews tables is all succfully created!";
    
?>