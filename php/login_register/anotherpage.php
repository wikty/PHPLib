<?php
include('config.php');
//include(APP_INC_DIR.'authenicate.inc.php');
include(APP_INC_DIR.'authenicate_encrypt.inc.php');

if(!is_authenicated(APP_AUTHENICATE_KEY))
{
	// redirect user to sign in
	header('Location:'.APP_SIGNIN_URL);
	exit;
}
else
{
	// flush session for authenicated user
	require_once(APP_INC_DIR.'flush_session.inc.php');
	flush_session();

	// page content
	$mystr='this is another page to test session start or destroy, if you see this , that meaning session
	is start.';
	echo $mystr;
	echo "<form action='". APP_SIGNOUT_URL ."' method='post'>";
	echo "<input type='submit' name='logout' value='LogOut' />";
	echo "<p>after logged out, you will be redirect to login page.</p>";
	echo "</form>";
}
?>