<?php
function dir_list_by_ext($dir,$exts,$limitNum=20,$depth=false)
{
//参数：此函数可以列出指定目录中所有指定类型的文件，depth决定是否
//递归子目录列出，$limitNum限制列出的条目数量，不限制数量则指定为负数
//exts is defined extsion name(array or string)
//返回值：
//value[0]表示是否遍历成功，value[0]===true则遍历成功，此时value[1]是含有文件名的数组
//value[0]!==true，说明遍历失败，查看value[0]可以知道出错原因
    $filenames=array();
    if(!is_dir($dir)||!is_readable($dir))
    {
        $filenames[0]="$dir is not a directory or can't readable";
        return $filenames;
    }

    $exts=(array)$exts;
    foreach($exts as $key=>$ext)
    {
        if($ext[0]=='.')
        {
            $exts[$key]=substr($ext,1);
        }
    }
    $regex=implode('|',$exts);
    $pattern="/\.(?:{$regex})$/i";

    if(!$depth)
    {
        $files=new DirectoryIterator($dir);
        $files=new RegexIterator($files,$pattern);
        if(!($limitNum<0))
        {
            $files=new LimitIterator($files,0,$limitNum);
        }
    }
    else
    {
        $files=new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir));
        $files=new RegexIterator($files,$pattern);
        if(!($limitNum<0))
        {
            $files=new limitIterator($files,0,$limitNum);
        }
    }

     foreach($files as $file)
    {
        $filenames[1][]=$file->getFileName();
    }
    if(empty($filenames))
    {
        $filenames[0]="$dir no you defined type $regex";
    }
    else
    {
        $filenames[0]=true;
    }
    
    return $filenames;
}

?>
