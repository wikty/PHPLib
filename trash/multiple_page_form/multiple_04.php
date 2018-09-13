<?php
session_start();
?>
<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<title>Multiple form 4</title>
</head>

<body>
<p>The details submitted were as follows: </p>
<dl>
<?php
//show all divided form information
foreach($_SESSION as $key=>$value)
{
    echo '<dt>'.$key.'</dt>';
    echo '<dd>'.$value.'</dd>';
}
?>
</dl>
</body>
</html>
