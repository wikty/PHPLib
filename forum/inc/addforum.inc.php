<?php
$from=basename($_SERVER[SCRIPT_NAME]);
$mystr='';
$mystr.='<form action="inc/adminprocess.inc.php?from='.$from.'" method="post">';
$mystr.='<div><label for="cat">Select A Category:</label>';
$mystr.='<select id="cat" name="cat">';
$mystr.='<option value="">Select a category</option>';

$sql='select * from categories';
$results=$mysqli->query($sql);
while($row=$results->fetch_object())
{
$mystr.='<option value="'.$row->id.'">'.$row->cat.'</option>';
}
$mystr.='</select></div>';
$mystr.='<div><label for="name">Forum Name:</label>';
$mystr.='<input type="text" name="name" />';
$mystr.='</div>';
$mystr.='<div><label for="desc">Description About The Forum:</label></div>';
$mystr.='<div><textarea rows="15" cols="70" name="desc" id="desc"></textarea>';
$mystr.='<input type="hidden" name="action" value="addforum" /></div>';
$mystr.='<div><input type="submit" name="submit" value="Add" /></div>';
echo $mystr;

?>