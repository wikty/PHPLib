<?php
include"connectMoviesite.php";
$query="create table if not exists images
(image_id int not null auto_increment,
image_caption varchar(255),
image_username varchar(255),
image_filename varchar(255),
image_date date,
primary key(image_id)
)";
mysql_query($query,$sv) or die(mysql_error($sv));
mysql_close($sv);
echo "you had created images table.";
 ?>