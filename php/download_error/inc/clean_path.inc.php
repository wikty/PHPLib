<?php

function clean_path($path)
{
	$items=split(DIRECTORY_SEPARATOR, $path);
	$head=(substr($path, 0, 1)==DIRECTORY_SEPARATOR)?DIRECTORY_SEPARATOR:'';
	$tail=(substr($path, strlen($path)-1, 1)==DIRECTORY_SEPARATOR)?DIRECTORY_SEPARATOR:'';
	$result=array();

	foreach($items as $item)
	{
		$item=trim($item);

		if($item=='.'||$item==='')
		{
			continue;
		}
		else if($item=='..'){
			array_pop($result);
		}
		else
		{
			$result[]=$item;
		}
	}

	$result=join(DIRECTORY_SEPARATOR, $result);
	return $head.$result.$tail;
}