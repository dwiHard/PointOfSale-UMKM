<?php
class lokasi implements IMysqlConn{
    private $_last_ID;
    static $_instance;
    static $_table = 'lokasi';
    use trait_database;

    private $_db;
    function __construct() {
        $db=new db_connect();
        $this->_db = $db->getConn();
    }

    public static function getInstance() {
        if( ! (self::$_instance instanceof self) ) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    function store($v = array()){
        try{
            $sql = 'INSERT into '. self::$_table. ' VALUES (null, ?, ?, ?, ?)';
            $stmt = $this->_db->prepare($sql);
            $stmt->execute(array(
                $v['nama'],
                1,
                date('Y-m-d'),
                date('Y-m-d')
            ));
            $this->_last_ID = $this->_db->lastInsertId();
            return 1;
        }catch (PDOException $e){
            die($e->getMessage());
        }
        return 0;
    }


    function querySELECT($sql = ''){
        $stmt = $this->_db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    function getAll($limit = ''){
        $sql = 'SELECT * FROM '. self::$_table . ' '. $limit;
        $stmt = $this->_db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    function show($id = ''){
        $sql = 'SELECT * FROM '. self::$_table .' WHERE lokasi_id = :id LIMIT 1';
        $stmt = $this->_db->prepare($sql);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        if($stmt->rowCount() == 0){
            return ("Error: tidak ada item di database");
        }
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    function getLastInsert(){
        return $this->_last_ID;
    }

      function edit($v = ''){
        try{
            $sql = 'UPDATE '. self::$_table .' SET
             nama_lokasi = ?
            WHERE lokasi_id = ?';
            $stmt = $this->_db->prepare($sql);
            $stmt->execute(array(
                $v['nama'],
                $v['id']
            ));
        }catch (PDOException $e){
            die($e->getMessage());
        }

    }



    function check2($id){
        try{
            $sql = 'SELECT count(*) FROM barang WHERE lokasi_id = :id';
            $stmt = $this->_db->prepare($sql);
            $stmt->bindParam(':id', $id,  PDO::PARAM_INT);
            $stmt->execute();
            if($stmt->fetchColumn()) {
                return 1;
            }
        }catch (PDOException $e){
            die($e->getMessage());
        }
        return 0;
    }



 function destroy($id= ''){
        try{
            $sql = 'DELETE FROM '. self::$_table .' WHERE lokasi_id = :id LIMIT 1';
            $stmt = $this->_db->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            return 1;
        }catch (PDOException $e){
            die($e->getMessage());
        }
        return 0;
    }
   

}