<?php
 include"connectMoviesite.php";
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
 global $sv;
 $cmd="select movie_name,movie_year,movie_director,
        movie_leadactor,movie_type
        from movie
        order by movie_name";
 $result=mysql_query($cmd,$sv) or die(mysql_error($sv));
 $num_movie=mysql_num_rows($result) or die(mysql_error($sv));
$table=<<<herehtml
<div>
<h2>Review Movie Database</h2>
<table style="width:70%;margin-left:auto;margin-right:auto;" border=1 cellpadding=2 cellspacing=2>
<tr>
<th>Movie Title</th>
<th>Year Of Release</th>
<th>Movie Director</th>
<th>Movie Lead Actor</th>
<th>Movie Type</th>
</tr>
herehtml;
while($row=mysql_fetch_assoc($result))
{   
    extract($row);
    $director_name=getMoviedirector($movie_director);
    $actor_name=getMovieactor($movie_leadactor);
    $movietype=getMovietype($movie_type);
  $table.=<<<herehtml
   <tr>
   <td>$movie_name</td>
   <td>$movie_year</td>
   <td>$director_name</td>
   <td>$actor_name</td>
   <td>$movietype</td>
   </tr> 
herehtml;
}
$table.=<<<herehtml
</table>
</div>
herehtml;
echo $table;
echo "movie nums is: ".$num_movie.".";
?>