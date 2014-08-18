<?php 
 $myrtn="";
 for($i=1;$i<21;$i++)
 {
    $dir="row".$i."/";
    if(file_exists($dir))
    {
        $path=$dir."index.xml";
        $root=simplexml_load_file($path);
        $items=$root->item;
        foreach($items as $item)
        {
            $attris=$item->attributes();
            $myrtn.=$attris[0].",";
        }
    }
 }
 echo $myrtn;
 ?>