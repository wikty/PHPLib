<?php
function clean_url($url)
{
	$protocol=substr($url, 0, stripos($url, '://'));
	if($protocol)
	{
		$protocol.='://';
		$url=ltrim($url,$protocol);
		$head='';
	}
	else
	{
		$protocol='';
		$head=(substr($url, 0, 1)=='/')?'/':'';
	}

	$prefix=($protocol!=='')?$protocol:$head;

	
	$tail=(substr($url, strlen($url)-1, 1)=='/')?'/':'';

	$result=array();
	$items=split('/', $url);
	foreach($items as $item)
	{
		$item=trim($item);
		if($item=='.'||$item==='')
		{
			continue;
		}
		else if($item=='..')
		{
			array_pop($result);
		}
		else
		{
			$result[]=$item;
		}
	}

	$result=join('/', $result);
	return $prefix.$result.$tail;
}