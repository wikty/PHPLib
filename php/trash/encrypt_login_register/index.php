<?php
require_once'config/mysite.cfg.php';
include"inc/gologin.inc.php";
include'inc/flush_session.inc.php';
include"inc/process_leave.inc.php";
	//show home page.
	echo "welcome to our website's Home Page.";
	echo "<form action='' method='post'>";
	echo "<input type='submit' name='logout' value='LogOut' />";
	echo "</form>";
	echo "<a href='anotherpage.php'>Go Another Page</a>";
?>