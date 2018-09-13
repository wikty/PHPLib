<?php
session_start();
include('config.php');

$fields=array(
	'nextpage'=>'nexturl',
	'address'=>'ads',
	'email'=>'eml',
	'submit'=>'nextstep',
);

if(isset($_POST[$fields['submit']]))
{
	require_once(APP_INC_DIR.'collect_form.inc.php');
	$form = collect_form($_POST[$fields['nextpage']]);
	if($form)
	{
		echo '<h2>you fill form is following:</h2>';
		echo '<pre>';
		print_r($form);
		echo '</pre>';
		exit;
	}
}

if(isset($_GET[APP_MPF_ACCESS_KEY]) && isset($_SESSION[APP_MPF_ACCESS_KEY]))
{
	if($_GET[APP_MPF_ACCESS_KEY]==$_SESSION[APP_MPF_ACCESS_KEY])
	{

?>
<form action='' method='post'>
	<label>Address</label>
	<input type='text' name="<?php echo $fields['address']; ?>" />
	<label>E-mail</label>
	<input type='text' name="<?php echo $fields['email']; ?>" />
	<input type='hidden' name="<?php echo $fields['nextpage']; ?>" value="" />
	<input type='submit' name="<?php echo $fields['submit']; ?>" />
</form>
<?php

		exit;
	}
}

echo '<h2>You cannot access form_part02 directly</h2>';
?>