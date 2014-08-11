<?php
//Warning: you should comment this code fragment,because it is too danger to use it
//不知道是什么原因这个函数每次只能删除一个目录而不是层级删除，可能是系统对php的限制？
function dir_recursive_delete($dir){
	if(is_dir($dir)&&is_writable($dir)){
		$hd=@opendir($dir);
		while($item=readdir($hd)){
			if($item=='.'||$item=='..')continue;
			
			$itemPath=join(DIRECTORY_SEPARATOR, array($dir, $item));
			if(is_dir($itemPath)){
				dir_recursive_delete($itemPath);
			}
			else{//file will be unlinked
				unlink($itemPath);
			}
		}
		@closedir($dir);
		//echo $dir.'<br/>';
		rmdir($dir);
	}
}
