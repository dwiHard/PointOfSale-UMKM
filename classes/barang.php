<?php
include_once "classes/trait_database.php";

class barang implements IMysqlConn{
    private $_last_ID;
    static $_instance;
    static $_table = 'barang';
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
            $sql = 'INSERT into '. self::$_table. ' VALUES (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
            $stmt = $this->_db->prepare($sql);
            $stmt->execute(array(
                $_SESSION['__userID'],
                $v['lokasi'],
                $v['kd_barang'],
                $v['nm_barang'],
                $v['stok'],
                0,
                $v['harga_beli'],
                $v['harga_jual'],
                $v['ket'],
                date('Y-m-d H:i:s'),
                date('Y-m-d H:i:s')
            ));
            $this->_last_ID = $this->_db->lastInsertId();
            return 1;
        }catch (PDOException $e){
            die($e->getMessage());
        }
        return 0;
    }

    function selectProductBarcode($kode=''){
        $q = 'select barang_ID, kode_barang, nama from barang where kode_barang = '. $kode;
        $stmt = $this->_db->query($q);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    function querySELECT($sql = ''){
        $stmt = $this->_db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    }


    function getCol($id, $nama_kolom = ''){
        $st = $this->_db->query("select ". $nama_kolom ." from barang where barang_ID = ". $id);
        return $st->fetchColumn();
    }

    function getAll($limit = ''){
        $sql = 'SELECT * FROM '. self::$_table . ' '. $limit;
        $stmt = $this->_db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    function show($id = ''){
        $sql = 'SELECT * FROM '. self::$_table .' WHERE barang_ID = :id LIMIT 1';
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

    function destroy($id= ''){
        try{
            $sql = 'DELETE FROM '. self::$_table .' WHERE barang_ID = :id LIMIT 1';
            $stmt = $this->_db->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            return 1;
        }catch (PDOException $e){
            die($e->getMessage());
        }
        return 0;
    }


    function check_record_exists($id){
        try{
            $sql = 'SELECT count(*) FROM '. self::$_table .' WHERE barang_ID = :id LIMIT 1';
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


    function edit_stok_barang($id, $tambah_stok, $harga_beli, $harga_jual){
        try{
            $q = 'UPDATE '.self::$_table.' SET
            stok = stok + :stok,
            harga_beli = :hrg_beli,
            harga_jual = :hrg_jual
            WHERE barang_ID = :id';
            $stmt = $this->_db->prepare($q);
            $stmt->execute(array(
                ':stok' => $tambah_stok,
                ':hrg_beli' => $harga_beli,
                ':hrg_jual' => $harga_jual,
                ':id' => $id,
            ));
            return 1;
        }catch (PDOException $e){
            die($e->getMessage());
        }
    }


    function edit_jumlah_stok($id, $stok){
        try{
            $q = 'UPDATE '.self::$_table.' SET
            stok = stok - :stok
            where barang_ID = :id';
            $stmt = $this->_db->prepare($q);
            $stmt->execute(array(
                ':stok' => $stok,
                ':id' => $id,
            ));
            return 1;
        }catch (PDOException $e){
            die($e->getMessage());
        }
        return 0;
    }

    //edit stok, terjual
    function edit_data_barang($id, $qty){
        try{
            $q = 'UPDATE '.self::$_table.' SET
            stok = stok - :jumlah,
            terjual = terjual + :terjual
            where barang_ID = :id';
            $stmt = $this->_db->prepare($q);
            $stmt->execute(array(
                ':jumlah' => $qty,
                ':terjual' => $qty,
                ':id' => $id,
            ));
            return 1;
        }catch (PDOException $e){
            die($e->getMessage());
        }

    }

    function set_balik_stok($id, $qty){
        try{
            $q = 'UPDATE '.self::$_table.' SET
            stok = stok + :jumlah,
            terjual = terjual - :terjual
            where barang_ID = :id';
            $stmt = $this->_db->prepare($q);
            $stmt->execute(array(
                ':jumlah' => $qty,
                ':terjual' => $qty,
                ':id' => $id,
            ));
            return 1;
        }catch (PDOException $e){
            die($e->getMessage());
        }
    }

    //edit
    function edit($v = ''){
        try{
            $sql = 'UPDATE '. self::$_table .' SET
             user_ID = ?,
             lokasi_id = ?,
             kode_barang = ?,
             nama = ?,
             stok = ?,
             harga_beli = ?,
             harga_jual = ?,
             ket = ?,
             updated_at = ?
            WHERE barang_ID = ?';
            $stmt = $this->_db->prepare($sql);
            $stmt->execute(array(
                $_SESSION['__userID'],
                $v['lokasi'],
                $v['kd_barang'],
                $v['nm_barang'],
                $v['stok'],
                $v['harga_beli'],
                $v['harga_jual'],
                $v['ket'],
                date('Y-m-d H:i:s'),
                $v['barang_ID']
            ));

        }catch (PDOException $e){
            die($e->getMessage());
        }
    }


    function search($keyword = ''){
        try{
            $stmt = $this->_db->prepare("SELECT * FROM ".self::$_table." WHERE (kode_barang LIKE :cd_1) or (nama LIKE :cd_2) ORDER BY nama");
            $cari_key = '%'. $keyword .'%';
            $stmt->bindParam(':cd_1', $cari_key);
            $stmt->bindParam(':cd_2', $cari_key);
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


    function show_barang_bystok($stok = 0, $operator = '='){
        try{
            $sql = 'SELECT * FROM '. self::$_table .' WHERE stok '.$operator.' '. $stok;
            $stmt = $this->_db->query($sql);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }catch (PDOException $e){
            die($e->getMessage());
        }
    }

}