<?php
    include'author.php';
    $sv=mysql_connect($host,$user,$psd)or
    die('Unable to connect databast ,please check you parameters.');
    mysql_select_db('moviesite',$sv)or die(mysql_error($sv));
    $cmd='INSERT INTO movie(
    movie_name,movie_type,movie_year,movie_leadactor,movie_director)
    VALUES
    ("Bruce Almighty",5,2003,1,2),
    ("Office Space",5,1999,5,6),
    ("Grand Canyon",2,1991,4,3)
    ';
    mysql_query($cmd,$sv)or die(mysql_error($sv));
    
    $cmd='INSERT INTO movietype(
    movietype_label)
    VALUES
    ("SCI FI"),
    ("DRAMA"),
    ("ADVENTURE"),
    ("WAR"),
    ("COMEDY"),
    ("HORROR"),
    ("ACTION"),
    ("KIDS")
    ';
    mysql_query($cmd, $sv)or die(mysql_error($sv));
    
    $cmd='INSERT INTO moviepeople(
    moviepeople_fullname,moviepeople_isactor,moviepeople_isdirector)
    VALUES
    ("Jim Carrary",1,0),
    ("Tom Shadcay",0,1),
    ("Lawrence Kasdan",0,1),
    ("Kevin Kline",1,0),
    ("Ron Living Ston",1,0),
    ("Mike Joe",0,1)
    ';
    mysql_query($cmd,$sv)or die(mysql_error($sv));
    $cmd="insert into reviews
    (review_movie_id,review_date,reviewer_name,review_comment,review_rating)
    values
    (1,'2008-09-23','John Doe','I thought this was a great movie ,Event thought my girlfriend
    made me see against I will.',4),
    (1,'2008-09-23','Billy Bob','I liked Ereasehead better.',2),
    (2,'2008-09-28','Peppermint Patty','I wish i had seen it sooner.',5),
    (3,'2008-09-23','Geroge B.','I liked this film',3)";
    mysql_query($cmd,$sv) or die(mysql_error($sv));
    echo "Data insert movie movietype moviepeople reviews succfully!";
?>