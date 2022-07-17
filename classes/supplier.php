<?php
class supplier implements IMysqlConn{
    private $_last_ID;
    static $_instance;
    static $_table = 'supplier';
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

    function getAll($limit = ''){
        $sql = 'SELECT * FROM '. self::$_table . ' '. $limit;
        $stmt = $this->_db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    function getCol($id, $nama_kolom = ''){
        $st = $this->_db->query("select ". $nama_kolom ." from supplier where supplier_ID = ". $id);
        return $st->fetchColumn();
    }

    function store($v = array()){
        try{
            $sql = 'INSERT into '. self::$_table. ' VALUES (null, ?, ?, ?, ?)';
            $stmt = $this->_db->prepare($sql);
            $stmt->execute(array(
                $v['nama'],
                $v['alamat'],
                $v['no_telpon'],
                date('Y-m-d H:i:s')
            ));
        }catch (PDOException $e){
            die($e->getMessage());
        }
    }

    function destroy($id= ''){
        try{
            $sql = 'DELETE FROM '. self::$_table .' WHERE supplier_ID = :id LIMIT 1';
            $stmt = $this->_db->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
        }catch (PDOException $e){
            die($e->getMessage());
        }
    }


    function show($id = ''){
        $sql = 'SELECT * FROM '. self::$_table .' WHERE supplier_ID = :id LIMIT 1';
        $stmt = $this->_db->prepare($sql);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        if($stmt->rowCount() == 0){
            return ("Error: tidak ada item di database");
        }
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }


    function edit($v = ''){
        try{
            $sql = 'UPDATE '. self::$_table .' SET
             nama = ?,
             alamat  = ?,
             no_telpon = ?
            WHERE supplier_ID = ?';
            $stmt = $this->_db->prepare($sql);
            $stmt->execute(array(
                $v['nama'],
                $v['alamat'],
                $v['no_telpon'],
                $v['id']
            ));
        }catch (PDOException $e){
            die($e->getMessage());
        }

    }

    function search($keyword = ''){
        try{
            $stmt = $this->_db->prepare("SELECT * FROM ".self::$_table."
            WHERE (nama LIKE :cd_1) ORDER BY nama ASC");
            $cari_key = '%'. $keyword .'%';
            $stmt->bindParam(':cd_1', $cari_key);
            $isQueryOk = $stmt->execute();
            $results = array();

            if($isQueryOk){
                $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            }else{
                trigger_error('Error executing statement.', E_USER_ERROR);
            }
            return $results;
        }catch (PDOException $e){
            die($e->getMessage());
        }
    }


}