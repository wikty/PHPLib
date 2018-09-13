<?php
 include"../inc/connectMoviesite.php";
 ?>
 <html>
    <head>
    <style type="text/css">
        th{background-color:#999;}
        .odd_row{background-color:#eee;}
        .even_row{background-color:#fff;}
        table{
        width:70%;
        margin-left:15%;
        }
    </style>
    <title>
        Movie Database
    </title>
    </head>
    <body>
        <table>
        <tr>
        <th colspan="2">Movies<a href="movie.php?action=add">[ADD]</a></th>
        </tr>
<?php
    $results=mysql_query("select movie_id,movie_name from movie",$sv)or die(mysql_error($sv));
    $chg=true;
    $mystr="";
    while($row=mysql_fetch_assoc($results))
    {
        $class=(($chg=!$chg)?"odd_row":"even_row");
        $mystr.="<tr class=".$class.">";
        $mystr.="<td style='width:75%'>".$row['movie_name']."</td>";
        $mystr.="<td><a href='movie.php?action=edit&id=".$row['movie_id']."'>[EDIT]</a>";
        $mystr.="<a href='delete.php?type=movie&id=".$row['movie_id']."'>[DELETE]</a></td>";
        $mystr.="</tr>";
    }
    echo $mystr;
 ?>
    <tr>
    <th colspan="2">
        People<a href="people.php?action=add">[ADD]</a>
    </th>
    </tr>
<?php
    $results=mysql_query("select moviepeople_id,moviepeople_fullname from moviepeople",$sv)or die(mysql_error($sv));
    $chg=true;
    $mystr="";
    while($row=mysql_fetch_assoc($results))
    {
        $class=(($chg=!$chg)?"odd_row":"even_row");
        $mystr.="<tr class=".$class.">";
        $mystr.="<td style='width:75%'>".$row['moviepeople_fullname']."</td>";
        $mystr.="<td><a href='people.php?action=edit&id=".$row['moviepeople_id']."'>[EDIT]</a>";
        $mystr.="<a href='delete.php?type=people&id=".$row['moviepeople_id']."'>[DELETE]</a></td>";
        $mystr.="</tr>";
    }
    echo $mystr;
 ?>
 
    </table>
    </body>
</html>
 