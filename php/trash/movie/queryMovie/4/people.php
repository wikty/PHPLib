<?php
 include"../inc/connectMoviesite.php";
 ?>
 <html>
    <head>
        <title>People-<?php echo $_GET['action']; ?></title>
    </head>
    <body>
<?php
  switch($_GET['action'])
  {
    case 'add':
?>
    <form action="process.php?action=add&type=people" method="post">
    <table>
        <tr>
            <td>People Name</td>
            <td><input type="text" name="people_name" /></td>
        </tr>
<?php
    $mystr="";
    $mystr.="<tr>";
    $mystr.="<td>Is Director?(default is actor.)</td>";
    $mystr.="<td><input type='checkbox' name='is_director' /></td>";
    $mystr.="</tr>\n";

    $mystr.="<input type='hidden' name='id' value='' />";
    $mystr.="<tr><td colspan='2' style='text-align:center;'><input type='submit' name='people_add' value='".$_GET['action']."' /></td></tr>";
    echo $mystr;
 ?>
    </table>
    </form>
<?php
    break;
    case 'edit':
        $id=$_GET['id'];
        $cmd="select moviepeople_fullname,moviepeople_isactor from moviepeople where moviepeople_id=".$id;
        $results=mysql_query($cmd,$sv) or die(mysql_error($sv));
        $row=mysql_fetch_assoc($results);
        extract($row);
        $check="";
        if($moviepeople_isactor!=1)
        {
            $check=" checked='checked' ";
        }
        $mystr="";
        $mystr.="<form action='process.php?action=edit&type=people' method='post'>";
        $mystr.="<table><tr><td>PeopleName</td><td><input type='text' value='$moviepeople_fullname' name='moviepeople_fullname' />";
        $mystr.="</td></tr>";
        $mystr.="<tr><td>Is a director?(defalut is actor)</td><td><input type='checkbox' name='is_director' ".$check." /></td></tr>";
        $mystr.="<tr><td><input type='hidden' name='id' value='$id' /></td><td><input type='submit' value='Edit People'></td></tr>";
        $mystr.="</table></form>";
        echo $mystr;
?>
<?php
      
         break;
      }
 ?>
    </body>
 </html>