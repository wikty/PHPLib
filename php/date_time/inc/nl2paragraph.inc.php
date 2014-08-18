<?php
// the built-in nl2br convert newline to <br/>
// nl2paragraph function convert newlines to <p></p>
function nl2paragraph($text)
{
	return '<p>' . preg_replace('/([\r\n]|\r\n)+/', '</p><p>', trim($text)) . '</p>';
}