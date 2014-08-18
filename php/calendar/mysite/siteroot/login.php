<?php
 include_once"../sys/core/init.inc.php";
 $page_title="Log In";
 $css_files=array("style.css","admin.css");
 include_once"asset/common/header.inc.php";
 ?>
 <div id="content">
    <form action="asset/inc/process.inc.php" method="post">
        <fieldset><legend>Log In</legend>
        <label for="uname">Username</label>
        <input type="text" name="uname" id="uname" value="" />
        <label for="pword">Password</label>
        <input type="password" name="pword" id="pword" value="" />
        <input type="hidden" name="action" value="user_login" />
        <input type="hidden" name="token" value="<?php echo $_SESSION[token]; ?>" />
        <input type="submit" name="login_submit" value="Log In" /> or <a href="./" >cancel</a>
        </fieldset>
    </form>
 </div>
 <?php
  include_once"asset/common/footer.inc.php";
  ?>