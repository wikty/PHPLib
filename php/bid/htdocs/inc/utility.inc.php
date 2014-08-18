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
	if(!empty($id) && is_numeric($id) && $id>0)
	{
		return true;
	}
	return false;
}
?>