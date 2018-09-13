<?php
 include"connectMoviesite.php";
 global $sv;
 $cmd="select movie_name,movie_year,movie_director,
        movie_leadactor,movie_type
        from movie
        order by movie_name";
 $result=mysql_query($cmd,$sv) or die(mysql_error($sv));
 $num_movie=mysql_num_rows($result) or die(mysql_error($sv));
?>
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
<?php
while($row=mysql_fetch_assoc($result))
{   
    extract($row);
    echo "<tr>";
    echo "<td>".$movie_name."</tb>";
    echo "<td>".$movie_year."</tb>";
    echo "<td>".$movie_director."</tb>";
    echo "<td>".$movie_leadactor."</tb>";
    echo "<td>".$movie_type."</tb>";
    echo "</tr>";
}
?>
</table>
</div>
<?php
echo "movie nums is: ".$num_movie.".";
?>