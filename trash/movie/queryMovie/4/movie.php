<?php
 include"../inc/connectMoviesite.php";
 ?>
 <html>
    <head>
        <title>Movie-<?php echo $_GET['action']; ?></title>
    </head>
    <body>
<?php
  switch($_GET['action'])
  {
    case 'add':
?>
    <form action="process.php?action=add&type=movie" method="post">
    <table>
        <tr>
            <td>Movie Name</td>
            <td><input type="text" name="movie_name" /></td>
        </tr>
<?php
    $mystr="";
    $results=mysql_query("select movietype_id,movietype_label from movietype order by movietype_label",$sv)or die(mysql_error($sv));
    $mystr.="<tr>";
    $mystr.="<td>Movie Type</td>";
    $mystr.="<td><select name='movie_type'>";
    while($row=mysql_fetch_assoc($results))
    {

        $mystr.="<option value=".$row['movietype_id'].">".$row['movietype_label']."</option>\n";
    }
    $mystr.="</select></td>";
    $mystr.="</tr>\n";
    
    
    $mystr.="<tr><td>Movie Year</td><td><select name='movie_year'>";
    for($i=date("Y");$i>=1970;$i--)
    {
        $mystr.="<option value=".$i.">".$i."</option>\n";
    }
    $mystr.="</select></td></tr>\n";
    
    
    $mystr.="<tr>";
    $mystr.="<td>Lead Actor</td>";
    $mystr.="<td><select name='movie_leadactor'>";
    $cmd="select moviepeople_id,moviepeople_fullname from moviepeople where moviepeople_isactor=1 order by moviepeople_fullname";
    $results=mysql_query($cmd,$sv) or die(mysql_error($sv));
    while($row=mysql_fetch_assoc($results))
    {
        $mystr.="<option value=".$row['moviepeople_id'].">".$row['moviepeople_fullname']."</option>\n";
    }
    $mystr.="</select></td></tr>\n";
    
    
    $mystr.="<tr>";
    $mystr.="<td>Director</td>";
    $mystr.="<td><select name='movie_director'>";
    $cmd="select moviepeople_id,moviepeople_fullname from moviepeople where moviepeople_isdirector=1 order by moviepeople_fullname";
    $results=mysql_query($cmd,$sv) or die(mysql_error($sv));
    while($row=mysql_fetch_assoc($results))
    {
        $mystr.="<option value=".$row['moviepeople_id'].">".$row['moviepeople_fullname']."</option>\n";
    }
    $mystr.="</select></td></tr>\n";
    
    $mystr.="<input type='hidden' name='id' value='' />";
    $mystr.="<tr><td colspan='2' style='text-align:center;'><input type='submit' name='movie_add' value='".$_GET['action']."' /></td></tr>";
    echo $mystr;
 ?>
    </table>
    </form>
<?php
    break;
    case 'edit':
        $id=$_GET['id'];
        $cmd="select movie_name,movie_type,movie_year,movie_leadactor,movie_director from movie where movie_id=".$id;
        $results=mysql_query($cmd,$sv) or die(mysql_error($sv));
        $row=mysql_fetch_assoc($results);
        extract($row);
        $mystr="<table><tr colspan='2'>Edit Movie</tr>";
        $mystr.="<form action='process.php?action=edit&type=movie' method='post'>";
        $mystr.="<tr><td>Movie Name</td><td><input type='text' name='movie_name' value='".$movie_name."' /></td></tr>";
        $mystr.="<tr><td>Movie Type</td><td><select name='movie_type'>";
        $cmd="select movietype_id ,movietype_label from movietype";
        $results=mysql_query($cmd,$sv) or die(mysql_error($sv));
        while($row=mysql_fetch_assoc($results))
        {
            if($row['movietype_id']==$movie_type)
            {
                $mystr.="<option value='$row[movietype_id]' selected='selected'>$row[movietype_label]</option>";
            }
            else
            {
                $mystr.="<option value='$row[movietype_id]'>$row[movietype_label]</option>";
            }
        }
        $mystr.="</select></td></tr>";
        $mystr.="<tr><td>Movie Year</td><td><select name='movie_year'>";
        for($i=date("Y");$i>=1970;$i--)
        {
            if($i==$movie_year)
            {
                $mystr.="<option value='$i' selected='selected'>$i</option>";
            }
            else
            {
                $mystr.="<option value='$i'>$i</option>";
            }
        }
        $mystr.="</select></td></tr>";
        $mystr.="<tr><td>Movie Actor</td><td><select name='movie_leadactor'>";
        $cmd="select moviepeople_id,moviepeople_fullname from moviepeople where moviepeople_isactor=1 order by moviepeople_fullname";
        $results=mysql_query($cmd,$sv) or die(mysql_error($sv));
        while($row=mysql_fetch_assoc($results))
        {
            if($row[moviepeople_id]==$movie_leadactor)
            {
                $mystr.="<option value='$row[moviepeople_id]' selected='selected'>$row[moviepeople_fullname]</option>";
            }
            else
            {
                $mystr.="<option value='$row[moviepeople_id]'>$row[moviepeople_fullname]</option>";
            }
        }
        $mystr.="</select></td></tr>";
        $mystr.="<tr><td>Movie Director</td><td><select name='movie_director'>";
        $cmd="select moviepeople_id,moviepeople_fullname from moviepeople where moviepeople_isdirector=1 order by moviepeople_fullname";
        $results=mysql_query($cmd,$sv) or die(mysql_error($sv));
        while($row=mysql_fetch_assoc($results))
        {
            if($row[moviepeople_id]==$movie_director)
            {
                $mystr.="<option value='$row[moviepeople_id]' selected='selected'>$row[moviepeople_fullname]</option>";
            }
            else
            {
                $mystr.="<option value='$row[moviepeople_id]'>$row[moviepeople_fullname]</option>";
            }
        }
        $mystr.="</select></td></tr>";
        $mystr.="<tr><td><input type='hidden' name='id' value='$id' /></td><td><input type='submit' value='Edit Movie'></td></tr>";
        $mystr.="</form></table>";
        echo $mystr;
?>
<?php
      
         break;
      }
 ?>
    </body>
 </html>