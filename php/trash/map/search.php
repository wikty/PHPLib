<?php
    $id=(int)$_GET['id'];
    $rownum=(int)($id/20);
    $dir="row".($rownum+1)."/";
    $hfile=null;
    if(!file_exists($dir))
    {
        echo "";
    }
    else{
    $path=$dir."index.xml";
    $hfile=simplexml_load_file($path);
    $found=false;
    if(count($hfile->item)>0){
        foreach($hfile->item as $item)
        {
            $attris=$item->attributes();
            foreach($attris as $attri)
            {
                if($attri==$id)
                {
                    $desc=$item->desc[0];
                    echo "$id,$desc";
                    $found=true;
                    break;
                }
            }
            if($found)
            {
                break;
            }
        }
        if(!$found)
        {
            echo "";
        }
        
    }
    else
    {
        echo "";
    }
    }
    //$hfile->asXML($path);
    
?>