<?php
include('config.php');

if(isset($_GET[APP_DOWNLOAD_KEY]))
{
	$resource_path=realpath(APP_RESOURCE_DIR);
	$item_path=realpath(APP_RESOURCE_DIR.$_GET[APP_DOWNLOAD_KEY]);
	if($item_path)
	{
		// must be restrict equal zero
		if(stripos($item_path, $resource_path)===0)
		{
			if(is_readable($item_path))
			{
				$file_size=filesize($item_path);
				header('Content-Type: application/octet-stream');
				header('Content-Length: '.$file_size);
				header('Content-Disposition: attachment; filename='.basename($item_path));
				header('Content-Transfer-Encoding: binary');
				$hf=@fopen($item_path,'r');
				if($hf)
				{
					fpassthru($hf);
					exit;
				}
			}
		}
	}
}

// redirect to error page
require_once(APP_INC_DIR.'redirect_error.inc.php');
redirect_error('download', 'sorry! download is failed.');
