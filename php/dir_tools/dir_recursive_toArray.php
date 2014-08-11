<?php
function dir_recursive_toArray($dir){
    $stack=array();
    if($hd=@opendir($dir)){
        while($item=readdir($hd)){
            if($item=='.' || $item=='..')continue;
            
            $itemPath=join(DIRECTORY_SEPARATOR, array($dir, $item));
            if(is_dir($itemPath)){
                array_push($stack, array('name'=>$item,'isdir'=>true,'children'=>array()));
                $stack[count($stack)-1]['children']=dir_recursive_toArray($itemPath);
            }
            else{
                array_push($stack, array('name'=>$item,'isdir'=>false));
            }
        }
    }
    closedir($hd);
    return $stack;
}
