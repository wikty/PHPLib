<?php
if(isset($_SESSION[username]))
{
	echo '<div><img src="images/me.jpg">';
	echo '<strong>Username:</strong>'.$_SESSION[username];
	echo '<br/><strong>Level:</strong>';
	switch($_SESSION[userlevel])
	{
			case 1:
			echo 'Publish User<br/><a href="addstory.php">Add-Story</a>';
			break;
			case 10:
			echo 'Administrator<br/><a href="addstory.php">Add-Story</a>';
			break;
			default:
			echo 'Ordinary User';
			break;
	}
	echo '</div>';
}
?>