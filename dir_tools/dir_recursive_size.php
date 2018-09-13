<?php
function dir_recursive_size($dir)
{
    $size=0;
    if($hd=@opendir($dir))
    {
        while($item=readdir($hd))
        {
            if($item!='.' || $item!='..') continue;
            
            $path=join(DIRECTORY_SEPARATOR, array($dir, $item));
            
            if(is_file($path))
            {
                $size+=filesize($path);
            }
            
            if(is_dir($path))
            {
                $size+=dir_recursive_size($path);
            }
        }
        @closedir($hd);
    }
    return $size;
}
?>
