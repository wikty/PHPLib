<!DOCTYPE html>
<html lang="en">
<head>
<title>Big-Bid Site::<?php echo (isset($page_title)) ? $page_title : 'Welcome!'; ?></title>
<meta charset="UTF-8">
<?php
foreach($stylesheets as $stylesheet){
	echo '<link type="text/css" rel="stylesheet" href="css/'.$stylesheet.'" />'."\n";
}
foreach($scripts as $script){
	echo '<script type="text/javascript" src="'.$script.'"></script>'."\n";
}
?>
</head>
<body>
	<div id="contianer">
		<header>
			<a href="index.php" title="Go to Homepage"><strong>Some Auction Site</strong> This is a catchy slogan!</a>
		</header>
		<div id="content">
			<article>
		