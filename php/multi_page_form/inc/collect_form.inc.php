<?php
function collect_form($nexturl, $form_access_key=APP_MPF_ACCESS_KEY, $form_key=APP_MPF_FORM_KEY)
{
	if(!isset($_SESSION))
	{
		session_start();
	}

	// collection form information
	if(!isset($_SESSION[$form_key]))
	{
		$_SESSION[$form_key]=array();
	}
	$p=$_POST;
	foreach($p as $key=>$field)
	{
		$_SESSION[$form_key][$key]=$field;
	}
	// return all of information about the form
	if(!$nexturl)
	{
		return $_SESSION[$form_key];
	}

	$_SESSION[$form_access_key]=sha1(rand());
	header(join('', array(
		'Location: ',
		$nexturl,
		'?',
		$form_access_key,
		'=',
		$_SESSION[$form_access_key]
	)));

	exit;
}