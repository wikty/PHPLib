<?php
 include "connectMoviesite.php";
 function paintStar($rating)
 {
    $stars='';
    for($index=0;$index<$rating;$index++)
    {
        $stars.='<img src="star.png" />';
        
    }
    return $stars;
 }
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
 function getMoviedifference($movie_id)
 {
    global $sv;
    $cmd='select movie_cost,movie_takings
    from movie where movie_id='.$movie_id;
    $result=mysql_query($cmd,$sv) or die(mysql_error($sv));
    $row=mysql_fetch_assoc($result) or die(mysql_error($sv));
    $difference=$row['movie_takings']-$row['movie_cost'];
    if($difference<0)
    {
    $color='red';
    $difference='$'.abs($difference).' million';
    }
    elseif ($difference>0)
    {
    $color='green';
    $difference='$'.$difference.' million';
    }
    else
    {
    $color='blue';
    $difference='broke even';
    }
    return "<span style='color:".$color.";'>".$difference."</span>";
 }
 global $sv;
 $cmd="select movie_name,movie_year,movie_director,
        movie_leadactor,movie_type,movie_running_time,movie_cost,movie_takings
        from movie
        where movie_id=".$_GET['movie_id'];
 $result=mysql_query($cmd,$sv) or die(mysql_error($sv));
 $row=mysql_fetch_assoc($result);
 $movie_name=$row['movie_name'];
 $movie_year=$row['movie_year'];
 $movie_director=getMoviedirector($row['movie_director']);
 $movie_leadactor=getMovieactor($row['movie_leadactor']);
 $movie_type=getMovietype($row['movie_type']);
 $movie_running_time=$row['movie_running_time'];
 $movie_cost=$row['movie_cost'];
 $movie_takings=$row['movie_takings'];
 $movie_difference=getMoviedifference($_GET['movie_id']);
$table=<<<herehtml
<html>
<head>
<title>Details for Movie:$movie_name</title>
</head>
<body>
<div style="text-align:center;">
<h2>Review Movie $movie_name</h2>
<h3>details</h3>
<table style="width:70%;margin-left:auto;margin-right:auto;" cellpadding=2 cellspacing=2>
<tr>
<td><strong>Title</strong></td>
<td>$movie_name</td>
<td><strong>Release Year</strong></td>
<td>$movie_year</td>
</tr>
<tr>
<td><strong>Movie Director</strong></td>
<td>$movie_director</td>
<td><strong>Cost</strong></td>
<td>$movie_cost</td>
</tr> 
<tr>
<td><strong>Lead Actor</strong></td>
<td>$movie_leadactor</td>
<td><strong>Takings</strong></td>
<td>$movie_takings</td>
</tr>
<tr>
<td><strong>Running Time</strong></td>
<td>$movie_running_time</td>
<td><strong>Health</strong></td>
<td>$movie_difference</td>
</tr>
</table>
herehtml;
    $cmd="select review_date,reviewer_name,review_comment,review_rating
    from reviews
    where review_movie_id=".$_GET['movie_id'];
    $result=mysql_query($cmd,$sv) or die(mysql_error($sv));
  $table.=<<<herehtml
        <h3>Reviews About $movie_name</h3>
        <table cellpadding=2 cellspacing=2 style="width:90%;
        margin-left:auto;margin-right:auto;">
        <tr>
        <th>
        Date
        </th>
        <th>
        Reviewer
        </th>
        <th>
        Comments
        </th>
        <th>
        Rating
        </th>
        </tr>
herehtml;
    while($row=mysql_fetch_assoc($result))
    {
        extract($row);
        $stars=paintStar($review_rating);
  $table.=<<<herehtml
        <tr>
        <td>$review_date</td><td>$reviewer_name</td><td>$review_comment</td>
        <td>$stars</td>
        </tr>
herehtml;
    }
 
$table.=<<<herehtml
</table>
</div>
</body>
</html>
herehtml;
echo $table;

 ?>