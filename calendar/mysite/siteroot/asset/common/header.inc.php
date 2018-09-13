<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" >
<head>
    <title><?php echo $page_title; ?></title>
    <?php 
    $loadcss="";
    foreach($css_files as $mycss)
    {
        $loadcss.="<link rel=\"stylesheet\" type=\"text/css\" media=\"screen,projection\"
            href=\"asset/css/$mycss\" />";
     }
     if(!empty($loadcss))
     {
        echo $loadcss;
     }
    ?>
    
</head>
<body>

