<?php
function checkRFields($post,$required)
{
    $missing=array();
    foreach($required as $item)
    {
        if(empty($post[$item]))
        {
            $missing[]=$item;
        }
    }
    return $missing;
}
function checkID($id)
{
	$id=trim($id);
	if(filter_var($id,FILTER_VALIDATE_INT,array('min_range=>1')))
	{
		return true;
	}
	return false;
}
function first50chars($article)
{
	$article=substr($article,0,50);
	return substr($article,0,strrpos($article,' '));
}
?>