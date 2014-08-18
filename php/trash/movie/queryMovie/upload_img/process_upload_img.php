<?php
    include_once"connectMoviesite.php";
    $image_dir="D:/users/administrator/documents/htdocs/upload_source/images";
    if($_FILES['upload_img']['error']!=UPLOAD_ERR_OK)
    {
        switch($_FILES['upload_img']['error'])
        {
            case UPLOAD_ERR_INI_SIZE:
                die("The uploaded file exceeds the upload_max_filesize directive in php.ini.");
                break;
            case UPLOAD_ERR_FORM_SIZE:
                die("The uploaded file exceeds the MAX_FILE_SIZE directive than was specified in html form.");
                break;
            case UPLOAD_ERR_PARTIAL:
                die("The uploaded file was only partially uploaded.");
                break;
            case UPLOAD_ERR_NO_FILE:
                die("No file is uploaded.");
                break;
            case UPLOAD_ERR_NO_TMP_DIR:
                die("The server is missing a temporary folder.");
                break;
            case UPLOAD_ERR_CANT_WRITE:
                die("The server failed to write uploaded file to disk.");
                break;
           case UPLOAD_ERR_EXTENSION:
                die("File upload stopped by extension.");
                break;
        }
    }
    $tmp_name=$_FILES['upload_image']['tmp_name'];
    list($width,$height,$type,$wh_attr,$t_attr)=getimagesize($tmp_name);
    switch($type)
    {
        case IMAGETYPE_GIF:
            $image=imagecreatefromgif($tmp_name)or die("you uploaded is not supported type");
            $ext=".gif";
            break;
        case IMAGETYPE_JPEG:
            $image=imagecreatefromjpeg($tmp_name)or die("you uploaded is not supported type");
            $ext=".jpg";
            break;
        case IMAGETYPE_PNG:
            $image=imagecreatefrompng($tmp_name)or die("you uploaded is not supported type");
            $ext=".png";
            break;
    }
    $image_caption=$_POST['image_caption'];
    $image_username=$_POST['image_username'];
    $image_date=@date("Y-m-d");
    $query="insert into images
        (image_id,image_caption,image_username,image_date)
        values
        (null,'$image_caption','$image_username','$image_date')";
    mysql_query($query,$sv) or die(mysql_error($sv));
    $last_id=mysql_insert_id();
    $image_name=$last_id.$ext;
    $query="update images set image_filename='$image_name' where image_id=$lase_id";
    mysql_close($sv);
    switch($type)
    {
        case IMAGETYPE_GIF:
            $image=imagegif($image_dir."/".$image_name);
            break;
        case IMAGETYPE_JPG:
            $image=imagejpeg($image_dir."/".$image_name,100);
            break;
        case IMAGETYPE_PNG:
            $image=imagepng($image_dir."/".$image_name);
            break;
    }
    imagedestroy($image);
 ?>
 <html>
    <head>
        <title>
        Check you upload image
        </title>
   </head>
   <body>
   <h2>How do you feel your uploaded image?</h2>
   <p>Here is the picture you uploaded on our server.</p>
   <img src='<?php echo "/upload_source/images/".$image_name; ?>' style="float:left;" />
   <table>
    <tr><td>Image Saved As:</td>
        <td><?php echo $image_name; ?></td>
    </tr>
    <tr><td>Image Type:</td>
        <td><?php echo $ext; ?></td>
    </tr>
    <tr><td>Width:</td>
        <td><?php echo $width; ?></td>
    </tr>
    <tr><td>Height:</td>
        <td><?php echo $height; ?></td>
    </tr>
    <tr><td>Upload Date:</td>
        <td><?php echo $image_date; ?></td>
    </tr>
    </table>
   </body>
 </html>