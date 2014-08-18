<?php
require_once'../config/mysite.cfg.php';

$mysqli=new mysqli($cfg_db_host,$cfg_db_user,$cfg_db_password,$cfg_db_dbname);
$mysqli->query('set names "'.$cfg_db_charset.'"');
if($myslqi->errno)
{
    throw new Exception('there is something wrong ,when construct mysqli');
}

$checkRequired=array('addcat'=>array('cat'),
				     'addforum'=>array('cat','name','desc')
					 );
if(empty($_GET[from]))
{
    header("Location:$cfg_sitedir");
    exit;
}
else
{
    $goback=urldecode($_GET[from]);
}

if(isset($_POST[action]))
{
	$action=$_POST[action];
	if(array_key_exists($action,$checkRequired))
	{
	    $missing=array();
	    foreach($checkRequired[$action] as $item)
	    {
                        if(!isset($_POST[$item]) || empty($_POST[$item]))
	        {
	              $missing[]=$item;
                        }
	    }
	    if(!empty($missing))
	    {
	        $query=implode('&',$missing);
	        header("Location:$cfg_sitedir".$goback.'?action='.$action.'&error=missing&'.$query);
	        exit;
	    }
	    else
	    {
                        foreach($checkRequired[$action] as $item)
	        {
                            ${$item}=$_POST[$item];
	        }
	        switch($action)
	        {
	             case 'addcat':
		$sql='insert into categories
			(cat)
			values
			("'.$cat.'")';
		break;
	             case 'addforum':
		$sql='insert into forums
			(cat_id,name,description)
			values
			('.$cat.',"'.$name.'","'.$desc.'")';
		break;
                        }
	        $results=$mysqli->query($sql);
	        //add cat or forum is successfully
	        header("Location:$cfg_sitedir");
	        exit;
                    }
	}
                else
	{
	    header("Location:$cfg_sitedir".$goback);
	    exit;
	}
}
else
{
    header("Location:$cfg_sitedir".$goback);
    exit;
}
?>