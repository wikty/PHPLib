<?php
function checkUsername($db,$username)
{
    $sql='SELECT username
            FROM usersinfo
            WHERE username="'.$username.'"';
    $results=$db->query($sql);
    $num_rows=$results->num_rows;
    $checkResult=array();
    if($num_rows)
    {  
        $checkResult[0]=false;
        $checkResult[1]='username existed.';
    }
    else
    {
        $checkResult[0]=true;
        $checkResult[1]=true;
    }
    return $checkResult;
}
function saveUser($db,$username,$password)
{
    if(isset($db))
    {
        if(empty($username)||empty($password))
        {
            return false;
        }
        else
        {
            $sql='INSERT INTO usersinfo
                    (username,password)
                    VALUES
                    ("'.$username.'","'.$password.'")';
            $results=$db->query($sql);
            return true;
            //$affected_rows=$results->affected_rows;
           // if($affected_rows==1)
            //{
              //  return true;
            //}
            //return false;
        }
    }
    else
    {
        return false;
    }
}
?>