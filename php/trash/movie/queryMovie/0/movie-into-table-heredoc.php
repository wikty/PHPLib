<?php
 include"connectMoviesite.php";
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
    extract($row);//注意下面.=语法的使用
  $table.=<<<herehtml
   <tr>
   <td>$movie_name</td>
   <td>$movie_year</td>
   <td>$movie_director</td>
   <td>$movie_leadactor</td>
   <td>$movie_type</td>
   </tr> 
herehtml;
}
$table.=<<<herehtml
</table>
</div>
herehtml;
//将php先解析到变量中，一次输出为html，省去了，html和php之间来回的跳转
echo $table;
echo "movie nums is: ".$num_movie.".";
?>