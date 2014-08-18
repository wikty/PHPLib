<?php
    if((is_administrator()&&(basename($_SERVER[PHP_SELF])!="logout.php"))or(isset($loggedin)&&($loggedin)))
    {
    //basename($_SERVER[PHP_SELF])!="logout.php"是针对logout页面的，因为当管理员想要退出时，显然没有必要再显示管理连接了
    //or(isset($loggedin)&&($loggedin)是针对login页面的，因为login页面在设置了cookie后必须重载后才能访问该cookie，所以设置了变量来标志
    //cookie已经设置成功
        $mystr="<h3>Site Admin</h3><p>";
        $mystr.="<a href='add_quote.php'>ADD NEW QUOTE</a>&nbsp;|&nbsp;";
        $mystr.="<a href='view_quotes.php'>VIEW QUOTES</a>&nbsp;|&nbsp;";
        $mystr.="<a href='logout.php'>LOG OUT</a></p>";
        echo $mystr;
    }

 ?>
</div>
<div id="footer">
Content &copy; 2013-05
</div>
</body>
</html>