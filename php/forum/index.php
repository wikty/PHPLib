<?php
session_start();
$needDB=true;
require_once'inc/header.inc.php';
$sql='SELECT * FROM categories';
$results=$mysqli->query($sql);
$mystr='<table>';
while($row=$results->fetch_object())
{
    $mystr.='<tr class="head"><td colspan="2">'.$row->cat.'</td></tr>'."\n";
    $sql='SELECT *  FROM forums WHERE cat_id='.$row->id;
    $results_f=$mysqli->query($sql);
    $num_rows=$results_f->num_rows;
    if($num_rows)
    {
        while($row_f=$results_f->fetch_object())
        {
            $mystr.='<tr><td><strong><a href="viewforum.php?id='.$row_f->id.
            '">'.$row_f->name.'</a></strong><p class="italic">'.$row_f->description.'</p></td></tr>'."\n";
        }
    }
    else
    {
        $mystr.='<tr><td><span class="italic">暂时没有话题</span></td></tr>'."\n";
    }
}
    $mystr.='</table>'."\n";
	echo $mystr;

require_once'inc/footer.inc.php';
?>