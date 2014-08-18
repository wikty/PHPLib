<?php 
    include'author.php';
    $con=mysql_connect($host,$user,$psd)or
    die('Unable to connect, please check you connection parameters.');
    mysql_select_db('calendar',$con)or die(mysql_error($con));
    $cmd="create table events(
                 event_id int not null auto_increment,
               	 event_title varchar(80) default null,
	 event_desc text,
	 event_start timestamp default '0000-00-00 00:00:00',
	 event_end timestamp default '0000-00-00 00:00:00',
	 primary key(event_id),
	 index(event_start)
             )engine=myisam character set utf8 collate utf8_unicode_ci";
    mysql_query($cmd,$con) or die(mysql_error($con));
   $cmd="alter table events auto_increment=0";
   mysql_query($cmd,$con) or die(mysql_error($con));
   echo "you calender.events table is created";
 ?>