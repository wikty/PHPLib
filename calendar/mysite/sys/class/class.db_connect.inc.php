<?php
    class DB_Connect
    {
        protected $db;
        protected function __construct($db=null)
        {
            if(!is_object($db))
            {
                $dsn="mysql:host=".DB_HOST.";dbname=".DB_NAME;
                try
                {
                    $this->db=new PDO($dns,DB_USER,DB_PASS);
                    //PDO is php class
                }
                catch(Exception $e)
                {
                    die($e->getMessage());
                }
            }
            else
            {
                $this->db=$db;
            }
        }
    
    }
 
 ?>