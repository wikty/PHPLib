<?php
    function is_administrator()
    {
        global $cookie_name;
        global $cookie_value;
        if(isset($_COOKIE[$cookie_name])&&($_COOKIE[$cookie_name]==$cookie_value))
        {
            return true;
        }
        else
        {
            return false;
        }
    }
 ?>