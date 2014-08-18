        </div>
   <div id='footer'>
        &copy; - <?php echo $cfg_siteauthor; ?>
        <p>E-mail to administrator:
            <address>
                <a href='mailto:<?php echo $cfg_siteadminemail; ?>'><?php echo $cfg_siteadmin; ?></a>
            </address>
        </p>
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