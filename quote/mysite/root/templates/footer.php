<?php
    if((is_administrator()&&(basename($_SERVER[PHP_SELF])!="logout.php"))or(isset($loggedin)&&($loggedin)))
    {
    //basename($_SERVER[PHP_SELF])!="logout.php"�����logoutҳ��ģ���Ϊ������Ա��Ҫ�˳�ʱ����Ȼû�б�Ҫ����ʾ����������
    //or(isset($loggedin)&&($loggedin)�����loginҳ��ģ���Ϊloginҳ����������cookie��������غ���ܷ��ʸ�cookie�����������˱�������־
    //cookie�Ѿ����óɹ�
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