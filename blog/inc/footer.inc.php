        </div>
    </div>
    <div id='footer'>
        &copy; - <?php echo $cfg_siteauthor; ?>
    </div>
    <?php 
    if($mysqli)
    {
        $mysqli->close();
    }
    ?>
 </body>
 </html>