<?php 
    include_once"mysql_connect.php";
    $cmd="create table if not exists myquotes
        (quote_id int unsigned not null auto_increment,
        quote text not null,
        source varchar(100) not null,
        favorite tinyint(1) unsigned not null,
        date_entered timestamp not null default current_timestamp,
        primary key(quote_id)
        )";
     mysql_query($cmd,$sv) or die(mysql_error($sv));
     echo "you had created myquotes table.";
?>