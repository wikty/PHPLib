        </div>
   <div id='footer'>
<?php
if(!isset($_SESSION[admin]) && basename($_SERVER[SCRIPT_NAME])=='index.php')
{
echo '<div><a href="admin.php"><strong>Administrator-LogIn</strong></a></div>';
}
?>
   <div>
        &copy; - <?php echo $cfg_siteauthor; ?>
        <p>E-mail to administrator:
            <address>
                <a href='mailto:<?php echo $cfg_siteadminemail; ?>'><?php echo $cfg_siteadmin; ?></a>
            </address>
        </p>
    </div>
    </div>
    </div>
    <?php 
    if($mysqli)
    {
        $mysqli->close();
    }
    ?>
 </body>
 </html>