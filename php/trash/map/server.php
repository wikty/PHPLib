<?php
    $dir=$_GET['dir'];
    $id=$_GET['id'];
    $desc=$_GET['desc'];
    $hfile=null;
    if(!file_exists($dir))
    {
        mkdir($dir);
        $hfile=fopen($dir."index.xml","wb");
        fwrite($hfile,'<?xml version="1.0" encoding="gb2312" standalone="yes"?><data></data>');
        fclose($hfile);
    }
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
                    $item->desc[0]=$desc;
                    echo "you already update iformation for $id";
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
            $myAdd=$hfile->addChild("item","");
            //var_dump($myAdd);
            $myAdd->addAttribute("id",$id);
            $myAdd->addChild("desc",$desc);
            echo "you already insert iformation for $id";
        }
        
    }
    else
    {
        $hfile->addChild("item","");
        $hfile->item[0]->addAttribute("id",$id);
        $hfile->item[0]->addChild("desc",$desc);
        echo "you already insert iformation for $id";
    }
    $hfile->asXML($path);
    
?>