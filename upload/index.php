<?php
include('config.php');
require_once(APP_INC_DIR.'simple_upload.class.inc.php');

$fields=array('submit'=>'upload');
$up = new SimpleUpload(APP_RESOURCE_DIR);

if(isset($_POST[$fields['submit']]))
{	
	$up->move();
	$messages = $up->getMessages();
}

?>

<meta charset="utf-8" />
<?php
if(isset($messages))
{
	echo '<pre>';
	print_r($messages);
	echo '</pre>';
}
?>
<form action="" method="post" enctype="multipart/form-data">
  <p>
    <label for="image">Upload image:</label>
    <input type='hidden' name='MAX_FILE_SIZE' value="<?php echo $up->getAllowedFileMaxSize(); ?>" />
    <input type="file" name="image[]" id="image" multiple>
  </p>
  <p>
    <input type="submit" name="<?php echo $fields['submit']; ?>" value="Upload">
  </p>
</form>