<?php
 function getMovietype($movietype_id)
 {
    global $sv;
    $cmd="select movietype_label from
    movietype
    where movietype_id=".$movietype_id;
    $result=mysql_query($cmd,$sv) or die(mysql_error($sv));
    $row=mysql_fetch_assoc($result) or die(mysql_error($sv));
    extract($row);
    return $movietype_label;
 }
 function getMoviedirector($director_id)
 {
    global $sv;
    $cmd="select moviepeople_fullname from
    moviepeople
    where moviepeople_id=".$director_id;
    $result=mysql_query($cmd,$sv) or die(mysql_error($sv));
    $row=mysql_fetch_assoc($result) or die(mysql_error($sv));
    extract($row);
    return $moviepeople_fullname;
 }
 function getMovieactor($actor_id)
 {
    global $sv;
    $cmd="select moviepeople_fullname
    from moviepeople
    where moviepeople_id=".$actor_id;
    $result=mysql_query($cmd,$sv) or die(mysql_error($sv));
    $row=mysql_fetch_assoc($result) or die(mysql_error($sv));
    extract($row);
    return $moviepeople_fullname;
 }
 
 ?>