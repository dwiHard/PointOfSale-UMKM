<?php

include_once "classes/trait_database.php";

class barang_masuk_detail implements IMysqlConn{
    private $_last_ID;
    static $_instance;
    static $_table = 'barang_masuk_detail';

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

    function store($id_brg,$nota, $harga_beli, $harga_jual, $jumlah, $subtotal){
        try{
            $sql = 'INSERT into '. self::$_table. ' VALUES (?, ?, ?, ?, ?, ?, ?)';
            $stmt = $this->_db->prepare($sql);
            $stmt->execute(array(
                null,
                $id_brg,
                $nota,
                $harga_beli,
                $harga_jual,
                $jumlah,
                $subtotal
            ));
            return 1;
        }catch (PDOException $e){
            die($e->getMessage() ."_".$e->errorInfo);
        }
        die("simpan barang_masuk_detail error !");
    }

    function show($no= ''){
        $sql = 'SELECT * FROM '. self::$_table .' WHERE no_nota = :no';
        $stmt = $this->_db->prepare($sql);
        $stmt->bindParam(":no", $no);
        $stmt->execute();
        if($stmt->rowCount() == 0){
            return ("Error: tidak ada item di database");
        }
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }



    function getLastInsert(){
        return $this->_last_ID;
    }

    function destroy($no_nota= ''){
        try{
            $sql = 'DELETE FROM '. self::$_table .' WHERE no_nota = :no';
            $stmt = $this->_db->prepare($sql);
            $stmt->bindParam(':no', $no_nota);
            $stmt->execute();
        }catch (PDOException $e){
            die($e->getMessage());
        }
    }

    function hapus_item($id ='' ,$no_nota= ''){
        try{
            $sql = 'DELETE FROM '. self::$_table .' WHERE barang_ID = :id && no_nota = :no';
            $stmt = $this->_db->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':no', $no_nota);
            $stmt->execute();
        }catch (PDOException $e){
            die($e->getMessage());
        }
    }

    function check_record_exists($id, $nota){
        try{
            $sql = 'SELECT * FROM '. self::$_table .' WHERE barang_ID = :id AND no_nota =:no LIMIT 1';
            $stmt = $this->_db->prepare($sql);
            $stmt->bindParam(':id', $id,  PDO::PARAM_INT);
            $stmt->bindParam(':no', $nota,  PDO::PARAM_STR);
            $stmt->execute();
            if($stmt->rowCount() > 0){
                return $stmt->fetch(PDO::FETCH_ASSOC);
            }
        }catch (PDOException $e){
            die($e->getMessage());
        }
        return array();
    }

    function get_jumlah($nota_id = ''){
        try{
            $q = 'select count(*) from '.self::$_table.' where no_nota = '.$nota_id;
            $stmt = $this->_db->query($q);
            return $stmt->fetchColumn();

        }catch (PDOException $e){
            die($e->getMessage());
        }
    }


    function check_jum_data_barang($id){
        try{
            $sql = 'SELECT count(*) FROM '. self::$_table .' WHERE barang_ID = :id';
            $stmt = $this->_db->prepare($sql);
            $stmt->bindParam(':id', $id,  PDO::PARAM_INT);
            $stmt->execute();
            if($stmt->fetchColumn()) {
                return 1;
            }
            return 0;
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
                $v['nm_barang'],
                $v['stok'],
                $v['harga_beli'],
                $v['harga_jual'],
                $v['ket'],
                date('Y-m-d H:i:s'),
                $v['barang_ID']
            ));
            return 1;
        }catch (PDOException $e){
            die($e->getMessage());
        }
        return 0;
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


}