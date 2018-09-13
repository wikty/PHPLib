<?php
include"tologin.php";
include"logout.php";

	//if logged in, show following content
	echo "welcome to our website's Home Page, Mr.{$_SESSION['username']}";
	echo "<form action='' method='post'>";
	echo "<input type='submit' name='logout' value='LogOut' />";
	echo "<p>after logged out, you will be redirect to login page.</p>";
	echo "</form>";
	echo "<a href='anotherpage.php'>Go Another Page</a>";
?>
