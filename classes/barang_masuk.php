<?php

include_once "classes/trait_database.php";

class barang_masuk implements IMysqlConn{
    private $_last_ID;
    static $_instance;
    static $_table = 'barang_masuk';
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

    function store($v = array(), $total_beli = 0){
        try{
            $sql = 'INSERT into '. self::$_table. ' VALUES (?, ?, ?, ?, ?, ?, ?, ?)';
            $stmt = $this->_db->prepare($sql);
            $stmt->execute(array(
                $v['no_nota'],
                $_SESSION['__userID'],
                $v['supplier_ID'],
                date('Y-m-d', strtotime($v['tgl_brg_masuk'])),
                $total_beli,
                $v['ket'],
                date('Y-m-d H:i:s'),
                date('Y-m-d H:i:s')
            ));
            $this->_last_ID = $this->_db->lastInsertId();
            return 1;
        }catch (PDOException $e){
            die($e->getMessage() ."_".$e->errorInfo);
        }
        die("simpan barang masuk error !");
    }


    function check_nota($nota){
        try{
            $sql = 'SELECT no_nota FROM '. self::$_table .' WHERE no_nota = :nota LIMIT 1';
            $stmt = $this->_db->prepare($sql);
            $stmt->bindParam(':nota', $nota,  PDO::PARAM_STR);
            $stmt->execute();

            if($stmt->rowCount() == 0) {
                //not found
                return 0;
            }
            return 1;
        }catch (PDOException $e){
            die($e->getMessage());
        }

    }

//belum berfungsi
    function querySELECT($sql = ''){
        $stmt = $this->_db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    }


    function getAll($limit = ''){
        $sql = 'SELECT bm.no_nota, bm.user_ID, bm.supplier_ID, bm.tgl_masuk, bm.total, bm.ket, bm.ket, s.nama as nama_supplier
        FROM '. self::$_table . ' bm LEFT JOIN supplier s using (supplier_ID)
         ORDER BY bm.created_at DESC '. $limit;

        $stmt = $this->_db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    function show($id = ''){
        $sql = 'SELECT * FROM '. self::$_table .' WHERE no_nota = :id LIMIT 1';
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

    function destroy($no_nota= ''){
        try{
            $sql = 'DELETE FROM '. self::$_table .' WHERE no_nota = :no LIMIT 1';
            $stmt = $this->_db->prepare($sql);
            $stmt->bindParam(':no', $no_nota);
            $stmt->execute();
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


    function hapus_item_barang_masuk($nota, $sub_total){
        try{
            $q = 'UPDATE '.self::$_table.' SET
            total = total - :sub_total_item
            where no_nota = :no';
            $stmt = $this->_db->prepare($q);
            $stmt->execute(array(
                ':sub_total_item' => $sub_total,
                ':no' => $nota,
            ));
            return 1;
        }catch (PDOException $e){
            die($e->getMessage());
        }
        return 0;
    }


    function check_jum_data_supplier($id){
        try{
            $sql = 'SELECT count(*) FROM '. self::$_table .' WHERE supplier_ID = :id';
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

    function search($keyword = ''){
        try{
            $stmt = $this->_db->prepare("SELECT bm.no_nota, bm.user_ID, bm.supplier_ID, bm.tgl_masuk, bm.total, bm.created_at, bm.ket,
            s.nama as nama_supplier
            FROM ".self::$_table." bm left join supplier s using (supplier_ID)
            WHERE (bm.no_nota LIKE :cd_1) or (s.nama LIKE :cd_2) or (bm.tgl_masuk LIKE :cd_3) ORDER BY bm.tgl_masuk DESC");


            $cari_key = '%'. $keyword .'%';
            $stmt->bindParam(':cd_1', $cari_key);
            $stmt->bindParam(':cd_2', $cari_key);
            $stmt->bindParam(':cd_3', $cari_key);

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