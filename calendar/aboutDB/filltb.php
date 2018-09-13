<?php 
     include'author.php';
    $con=mysql_connect($host,$user,$psd)or
    die('Unable to connect, please check you connection parameters.');
    mysql_select_db("calendar",$con) or die(mysql_error($con));
    $cmd="insert into events
               (event_title,event_desc,event_start,event_end)
                values
                ('New Year$#39;s Day','Happy New Year!','2010-01-01 00:00:00',
                  '2010-01-01 23:59:59'),
                ('Last Day of January','Last day of the month! Yay!',
                 '2010-01-31 00:00:00', '2010-01-31 23:59:59')";
    mysql_query($cmd,$con) or die(mysql_error($con));
   echo "you had filled table of events.";
 ?>