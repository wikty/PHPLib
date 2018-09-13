<?php
include('config.php');

$fields=array(
	'nextpage'=>'nexturl',
	'username'=>'name',
	'password'=>'pwd',
	'rpassword'=>'rpwd',
	'submit'=>'nextstep',
);

if(isset($_POST[$fields['submit']]))
{
	// collect current form information into session
	require_once(APP_INC_DIR.'collect_form.inc.php');
	$form=collect_form($_POST[$fields['nextpage']]);
	if($form)
	{
		echo '<h2>you fill form is following:</h2>';
		echo '<pre>';
		print_r($form);
		echo '</pre>';
		exit;
	}
}

?>
<form action='' method='post'>
	<label>username</label>
	<input type='text' name="<?php echo $fields['username']; ?>" />
	<label>password</label>
	<input type='text' name="<?php echo $fields['password']; ?>" />
	<label>retype password</label>
	<input type='text' name="<?php echo $fields['rpassword']; ?>" />
	<input type='hidden' name="<?php echo $fields['nextpage']; ?>" value='form_part02.php' />
	<input type='submit' name="<?php echo $fields['submit']; ?>" />
</form>