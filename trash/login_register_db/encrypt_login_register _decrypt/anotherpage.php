<?php
include"inc/gologin.inc.php";
include'inc/flush_session.inc.php';
include"inc/process_leave.inc.php";
$mystr='this is another page to test session start or destroy, if you see this , that meaning session
is start.';
echo $mystr;
echo "<form action='' method='post'>";
echo "<input type='submit' name='logout' value='LogOut' />";
echo "</form>";
?>