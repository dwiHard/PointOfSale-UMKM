<?php
class db_connect implements IMysqlConn
{
    private $_db;
    static $_instance;

    public function __construct()
    {
        try
        {
            $this->_db= new PDO('mysql:host='.self::HOST.';dbname='.self::DB.'', self::USERNAME, self::PASS);
            $this->_db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        catch(PDOException $e)
        {
            echo $e->getMessage();
        }
    }

    public function getInstance()
    {
        if (!(self::$_instance instanceof self)) {
            self::$_instance = new self();
        }
        return self::$_instance;
        return $this->_db;
    }


    public function getConn(){
        return $this->_db;
    }
}