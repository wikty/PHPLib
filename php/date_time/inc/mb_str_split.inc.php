<?php
// writen by http://php.net/manual/en/function.mb-split.php#99851
function mb_str_split($text)
{
	return preg_split('/(?<!^)(?!$)/u', $text);
}