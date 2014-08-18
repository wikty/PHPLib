<?php
require_once'mysite.cfg.php';
$dbc = new mysqli ($cfg_db_host,$cfg_db_w_user,$cfg_db_w_password);
try{
$sql='create database if not exists mybid';
$dbc->query($sql);
$dbc->select_db('mybid');
if($dbc->error){
echo $dbc->error;
}
$sql='create table if not exists items(
			item_id int(10) unsigned not null auto_increment,
			user_id int(10) unsigned not null,
			item varchar(100) not null,
			description tinytext,
			opening_price decimal(7,2) unsigned not null,
			final_price decimal(7,2) unsigned default null,
			date_opened timestamp not null,
			date_closed datetime not null,
			primary key(item_id)
			)';
$dbc->query($sql);
if($dbc->error){
echo $dbc->error;
}
$sql='create table if not exists bids(
			bid_id int(10) unsigned not null auto_increment,
			item_id int(10) unsigned not null,
			user_id mediumint(8) unsigned not null,
			bid decimal(7,2) unsigned not null,
			date_submitted timestamp not null,
			primary key(bid_id),
			key item_id(item_id),
			key user_id(user_id)
			)';
$dbc->query($sql);
if($dbc->error){
echo $dbc->error;
}
$sql='create table if not exists users(
			user_id mediumint(8) unsigned not null auto_increment,
			username varchar(50) not null,
			password varchar(50) not null,
			date_created timestamp not null,
			timezone varchar(100) not null,
			primary key(user_id),
			unique key username(username),
			key login(username,password)
			)';
$dbc->query($sql);
if($dbc->error){
echo $dbc->error;
}
echo 'ok';
}
catch(Exception $e){
echo $e->getMessage();
exit;
}
?>