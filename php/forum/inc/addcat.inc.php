<?php
$from=basename($_SERVER[SCRIPT_NAME]);
?>
<form action='inc/adminprocess.inc.php?from=<?php echo $from; ?>' method='post'>
	<div>
	<label for='cat'>Category Name:</label>
	<input type='text' name='cat' id='cat' />
	<input type='hidden' name='action' value='addcat' />
	</div>
	<div>
	<input type='submit' name='submit' value='Add' />
	</div>
</form>