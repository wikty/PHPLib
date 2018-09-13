<?php
    require_once"config/blog.cfg.php";
    $entryid=0;
    $needDB=true;
    //$error=false;
    if(isset($_GET[id]) && is_numeric($_GET[id]))
    {
        $entryid=(int)abs($_GET[id]);
        //$error=true;
    }
    else
    {
        header("Location:$cfg_sitedir");
        exit;
    }
    if(isset($_POST[submit]))
    {
        $mysqli=new mysqli($cfg_db_host,$cfg_db_user,$cfg_db_password,$cfg_db_dbname);
        $sql='INSERT INTO comments
            (blog_id,dateposted,name,comment)
            VALUES
            ('.$_POST[entryid].',now(),"'.$_POST[name].'","'.$_POST[comment].'")';
        $mysqli->query($sql);
        header("Location:http://$_SERVER[HTTP_HOST].$_SERVER[REQUEST_URI]");
    }
    else
    {
        require_once"inc/header.inc.php";
        $mystr='';
        $sql="SELECT entries.*,categories.cat
                FROM entries,categories
                WHERE entries.cat_id=categories.id
                AND entries.id=$entryid
                LIMIT 1";
        $results=$mysqli->query($sql);
        $row=$results->fetch_object();
        $mystr.="<h2>Article : $row->subject </h2>\n";
        $mystr.='<p class="italic">In <a href="viewcat.php?id='.$row->cat_id.'">'.$row->cat.'</a>'."\n";
        $mystr.=' - Post On : '.date('D jS F Y g.iA',strtotime($row->dateposted));
        if(isset($_SESSION[username]) && isset($_SESSION[password]))
        {
            $mystr.=' [<a href="updateentry.php?id='.$row->id.'">EDIT</a>]</p>'."\n";
        }
        else
        {
            $mystr.='</p>'."\n";
        }
        $mystr.='<p>'.nl2br($row->body).'</p>'."\n";
        $sql="SELECT * 
                FROM comments
                WHERE blog_id=$entryid
                ORDER BY dateposted";
        $results=$mysqli->query($sql);
        $num_rows=$results->num_rows;
        if($num_rows)
        {
            $mystr.='<strong>'.$num_rows.' Comments : </strong>';
            $i=1;
            while($row=$results->fetch_object())
            {
                $mystr.='<a name="comment'.$i.'"></a>';
                $mystr.='<p class="commentheader">Name : '.$row->name.' - Post On : '.date('D jS F Y g.iA',
                    strtotime($row->dateposted)).'</p>'."\n";
                $mystr.='<p class="commentbody">Comment : '.nl2br($row->comment).'</p>'."\n";
                $i++;
            }
        }
        else
        {
            $mystr.='<strong>No Comments</strong>';
        }
        echo $mystr;
    }
?>
    <form action='' method='post' class='myform'>
        <fieldset>
            <legend>Submit Comment : </legend>
        <label for='name'>Name:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
        <input type='text' name='name' id='name' /><br></br>
        <label for='comment'>Comment: </label>
        <textarea name='comment' id='comment' rows='10' cols='50'></textarea>
        <input type='hidden' name='entryid' id='entryid' value='<?php echo $entryid; ?>' />
        <input type='submit' value='Submit' name='submit' id='submit' />
        </fieldset>
    </form>
        
<?php
    require_once"inc/footer.inc.php";
?>