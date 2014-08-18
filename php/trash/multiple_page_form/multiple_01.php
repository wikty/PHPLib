<?php
if(isset($_POST['next']))
{
        session_start();
        $_SESSION['mpf_started']=true;
        $mpf_firstpage='multiple_01.php';
        $mpf_nextpage='multiple_02.php';
        $mpf_missing=array();
        $mpf_required=array('name');
        $mpf_submit='next';
        require_once'inc/multi_page_form.inc.php';
        //pay attention: follow test $mpf_missing
}  
?>
<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<title>Multiple form 1</title>
<style type='text/css'>
.error:Red;
</style>
</head>

<body>
<?php
//don't forget this section
require_once'inc/test_mpf_missing.inc.php';
?>
<form id="form1" method="post" action="">
    <p>
        <label for="name">Name:</label>
        <input type="text" name="name" id="name" required>
    </p>
    <p>
        <input type="submit" name="next" value="Next &gt;">
    </p>
</form>
</body>
</html>
