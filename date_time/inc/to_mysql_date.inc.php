<?php
// $date should be like: array('year'=>2014, 'month'=>12, day=>33)
function to_mysql_date($date)
{
	if(is_array($date))
	{
		if(array_key_exists('year', $date) &&
			array_key_exists('month', $date) &&
			array_key_exists('day', $date))
		{
			if(is_numeric($date['year']) &&
				is_numeric($date['month']) &&
				is_numeric($date['day']))
			{
				if(checkdate($date['month'], $date['day'], $date['year']))
				{
					return join('-', 
						array($date['year'], $date['month'], $date['day']));
				}
			}
		}
	}
	return array();
}