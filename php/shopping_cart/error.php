<?php
require'config/mysite.cfg.php';
require_once'inc/header.inc.php';
if(isset($_GET[error]))
{
    switch($_GET[error])
    {
        case 1 :
            echo '<div class="error">sorry! there is something wrong with our site, please later try again!</div>';
            break;
        default :
            header("Location:$cfg_sitedir");
            exit;
    }
}
else
{
    header("Location:$cfg_sitedir");
    exit;
}
require_once'inc/footer.inc.php';
?>