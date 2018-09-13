<?php
//don't forget this section
if(!empty($mpf_missing))
{
echo "<div class='error'>Follow must be filed";
echo '<ul >';
foreach($mpf_missing as $item)
{
    echo '<li>';
    echo $item;
    echo '</li>';
}
echo '</ul>';
echo "</div>";
}
?>