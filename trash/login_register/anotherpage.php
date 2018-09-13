<?php
include'tologin.php';
include'logout.php';
$mystr='this is another page to test session start or destroy, if you see this , that meaning session
is start.';
echo $mystr;
echo "<form action='' method='post'>";
echo "<input type='submit' name='logout' value='LogOut' />";
echo "<p>after logged out, you will be redirect to login page.</p>";
echo "</form>";
?>