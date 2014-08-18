<?php
$needDB=true;//use DB flag
require_once"inc/header.inc.php";
//sql
$sql='SELECT entries.*,categories.cat FROM entries,categories
    WHERE entries.cat_id=categories.id
    ORDER BY entries.dateposted DESC
    LIMIT 0,1';
$results=$mysqli->query($sql);
$mystr='';
while($row=$results->fetch_object())
{
    $mystr.='<h2>Lastest Article : <a href="viewentry.php?id='.$row->id.'">'.$row->subject.'
    </a></h2><br/>'."\n";
    $mystr.='<p class="italic">In <a href="viewcat.php?id='.$row->cat_id.'">'.$row->cat.'</a>'."\n";
    $mystr.=' - Posted on '.date('D jS F Y g.iA',strtotime($row->dateposted));
    if(isset($_SESSION[username]) && isset($_SESSION[password]))
    {
        $mystr.=' [<a href="updateentry.php?id='.$row->id.'">EDIT</a>]</p>'."\n";
    }
    else
    {
        $mystr.='</p>'."\n";
    }
    $mystr.='<p>'.nl2br($row->body).'</p>'."\n";
    $mystr.='<div class="additional">';
    $sql='SELECT name,dateposted
                    FROM comments
                    WHERE blog_id='.$row->id.' ORDER BY dateposted DESC';
    $results_c=$mysqli->query($sql);
    $num_rows_c=$results_c->num_rows;
    if($num_rows_c)
    {
        $mystr.='<p><strong>'.$num_rows_c.' Comments : </strong></p>'."\n";
        $i=1;
        while($row_c=$results_c->fetch_object())
        {
            $mystr.='<p>';
            $mystr.='<a href="viewentry.php?id='.$row->id.'#comment'.$i.'">'.$row_c->name.'</a>';
            $mystr.=' - Posted On : '.date('D jS F Y g.iA',strtotime($row_c->dateposted)).'</p>'."\n";
            $i++;
        }
    }
    else
    {
        $mystr.='<p><strong>No Comments.</strong></p>'."\n";
    }
}
$sql='SELECT entries.*,categories.cat FROM entries,categories
    WHERE entries.cat_id=categories.id
    ORDER BY entries.dateposted DESC
    LIMIT 1,5';
$results_prev=$mysqli->query($sql);
$num_rows_prev=$results_prev->num_rows;
if($num_rows_prev)
{
    $mystr.='<p><strong>Previous Articles List : </strong></p>'."\n";
    while($row_p=$results_prev->fetch_object())
    {
        $mystr.='<p><a href="viewentry.php?id='.$row_p->id.'">'.$row_p->subject.'</a>';
        $mystr.=' - Post On : '.date('D jS F Y g.iA',strtotime($row_p->dateposted));
        if(isset($_SESSION[username]) && isset($_SESSION[password]))
        {
            $mystr.=' [<a href="updateentry.php?id='.$row->id.'">EDIT</a>]</p>'."\n";
        }
        else
        {
            $mystr.='</p>'."\n";
        }
    }
}
else
{
    $mystr.='<p><strong>No Previous Article.</strong></p>'."\n";
}
$mystr.='</div>';
//css class:additional end
echo $mystr;
require_once"inc/footer.inc.php";
?>