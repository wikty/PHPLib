<?php
include('config.php');
require_once(APP_INC_DIR.'simple_upload.class.inc.php');
require_once(APP_INC_DIR.'simple_thumbnail.class.inc.php');

$fields=array('submit'=>'submit', 'size'=>'size');
$up = new SimpleUpload(APP_RESOURCE_DIR);

if(isset($_POST[$fields['submit']]))
{
	$width='';
	$height='';
	$size=explode('*', $_POST[$fields['size']]);
	if(count($size)==2)
	{
		$width=$size[0];
		$height=$size[1];
	}

	$download=array();
	$files=$up->move();
	$tb=new SimpleThumbnail(APP_RESOURCE_DIR);
	foreach ($files as $filename) {
		$tb->setOriginal(APP_RESOURCE_DIR.$filename);
		$thumbnail=$tb->create($width, $height);
		$download[]=join('', array(
			'<a href="download.php?',
			APP_DOWNLOAD_KEY,
			'=',
			$thumbnail,
			'">Download ',
			$thumbnail,
			'</a>'
		));
	}

	$messages=array_merge($up->getMessages(), $tb->getMessages());
}

?>


<meta charset='utf-8' />
<?php
if(isset($messages))
{
	echo '<pre>';
	print_r($messages);
	echo '</pre>';
}
if(isset($download))
{
	foreach ($download as $link) {
		echo '<p>' . $link . '</p>';
	}
}
?>
<form action='' method='post' enctype='multipart/form-data' >
<filedset>
	<legend>Cut-Image</legend>
	<div>
		<label>Upload image that you want be cut:</label>
		<input type='file' name='image[]' multiple='true' />
		<!-- <input type='file' name='image' />-->
		<input type='hidden' name='MAX_FILE_SIZE' value="<?php echo $up->getAllowedFileMaxSize(); ?>" />
	</div>
	<div>
		<label>Enter the size you want be cut:(120*150)
		default max size is 200
		</label>
		<input type='text' name='size' />
	</div>
	<div>
	<input type='submit' name='submit' value='submit' />
	</div>
	</fieldset>
</form>
