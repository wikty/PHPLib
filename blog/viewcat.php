<?php
    $catid=0;
    $needDB=true;
    $mystr='';
    //$error=false;
    if(isset($_GET[all]))
    {
        $sql_c="SELECT *
             FROM categories";
    }
    else
    {
        if(isset($_GET[id]) && is_numeric($_GET[id]))
        {
            $catid=(int)abs($_GET[id]);
            //$error=true;
        }
        else
        {
            header("Location:$cfg_sitedir");
            exit;
        }
        $sql_c="SELECT *
             FROM categories
             WHERE id=$catid";
    }
    require_once"inc/header.inc.php";
    $results_c=$mysqli->query($sql_c);
    $num_rows_c=$results_c->num_rows;
    if($num_rows_c)
    {
        while($row_c=$results_c->fetch_object())
        {
            $mystr.='<p><strong>'.$row_c->cat.' : </strong></p>';
            $sql="SELECT *
                FROM entries
                WHERE cat_id=$row_c->id
                ORDER BY dateposted DESC";
            $results=$mysqli->query($sql);
            $num_rows=$results->num_rows;
            if($num_rows)
            {
                while($row=$results->fetch_object())
                {
                    $mystr.='<p><a href="viewentry.php?id='.$row->id.'">'.$row->subject.'</a>';
                    $mystr.=' - Post On : '.date('D jS F Y g.iA',strtotime($row->dateposted));
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
                $mystr.='<p class="italic">No articles.</p>'."\n";
            }        
        }
    }
    else
    {
        $mystr.='<p><strong> No this class articles.<strong></p>'."\n";
    }
    echo $mystr;
    require_once"inc/footer.inc.php";
?>