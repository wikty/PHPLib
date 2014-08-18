<html>
    <head>
        <title>
        Upload Image
        </title>
    <head>
    <body>
        <form action='process_upload_img.php' method='post' enctype='multipart/form-data'>
            <table>
                <tr><td>Your Name:</td>
                    <td><input type='text' name='image_username' /></td>
                </tr>
                <tr><td>Upload Image*</td>
                    <td><input type='file' name='upload_image' /></td>
                </tr>
                <tr><td colspan='2'><small><em>*Acceptable image formats include: .gig, .jpeg/.jpg and .png</em></small></td>
                </tr>
                <tr><td>Image Caption:</td>
                    <td><input type='text' name='image_caption' /></td>
                </tr>
                <tr><td colspan='2'><input type='submit' value='upload' /></td>
                </tr>
            </table>
        </form>
    </body>
</html>