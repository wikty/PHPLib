<?php

        $mpf_firstpage='multiple_01.php';
        $mpf_nextpage='multiple_03.php';
        $mpf_missing=array();
        $mpf_required=array('age');
        $mpf_submit='next';
        require_once'inc/multi_page_form.inc.php';
        //pay attention: follow test $mpf_missing
  
?>
<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<title>Multiple form 2</title>
</head>

<body>
<?php
require_once'inc/test_mpf_missing.inc.php';
?>
<form id="form1" name="form1" method="post" action="">
    <p>
        <label for="age">Age:</label>
        <input type="number" name="age" id="age">
    </p>
    <p>
        <input type="submit" name="next" value="Next &gt;">
    </p>
</form>
</body>
</html>
