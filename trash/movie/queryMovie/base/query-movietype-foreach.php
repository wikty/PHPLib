<?php
    include'author.php';
    $sv=mysql_connect($host,$user,$psd)or 
    die('Unable to connect database ,please check you connection parameters.');
    mysql_select_db('moviesite',$sv)or 
    die(mysql_error($sv));
    $cmd='SELECT movietype_label,movietype_id
          FROM movietype
          WHERE movietype_id>0
          ORDER BY movietype_id';
    $result=mysql_query($cmd,$sv)or die(mysql_error($sv));
    echo '<table border=1>';
    while($row=mysql_fetch_assoc($result))
    {
        echo '<tr>';
        foreach($row as $value)
        {
        echo '<td>';
        echo $value;
        echo '</td>';
        }
        echo'</tr>';
    }
    echo '</table>';

?>