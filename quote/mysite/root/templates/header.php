<?php
    include_once"../sys/cookie_data.php";
    include_once"inc/functions.php";
 ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title>
<?php
 if(defined(TITLE))
    echo TITLE;
 else 
    echo "My Quote";
 ?>
</title>
	<link rel="stylesheet" href="css/style.css" type="text/css" />
</head>
<body>
<div id="container">
 <h1>My Site Quotes</h1>
 <br/>