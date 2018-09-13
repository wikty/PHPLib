<?php
require_once'../mysite.cfg.php';
session_start();
if(!isset($_SESSION[userId])){
	header("Location:$cfg_sitedir".'login.php');
	exit;
}
$page_title="Create Item";
$stylesheets=array('main.css');
$scripts=array('utility.js');
require_once'inc/header.inc.php';
if($_SERVER[REQUEST_METHOD]=='POST'){
	
}
echo '<form action="" method="post">
<label for="item">Item</label>
<input id="item" name="item" type="text" />
<label for="description">Description</label>
<textarea title="description..." id="description" name="description"></textarea>
<label for="endTime">Date Closes(e.g,2013-08-01 12:00:00)</label>
<input type="text" id="endTime" name="date_closed" />
<label for="startPrice">Opening Price</label>
<input type="text" id="startPrice" name="opening_price" />
<input type="submit" name="submit" id="submit" value="submit" class="button" />
</form>';
require_once'inc/footer.inc.php';
?>