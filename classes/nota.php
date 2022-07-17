<?php
class nota implements IMysqlConn{
    private $_last_ID;
    static $_instance;
    static $_table = 'nota';
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
                $_SESSION['__userID'],
                date('Y-m-d'),
                date('H:i:s'),
                $v['total_belanja']
            ));
            $this->_last_ID = $this->_db->lastInsertId();
            return 1;
        }catch (PDOException $e){
            die($e->getMessage());
        }
        return 0;
    }
    function getLastInsert(){
        return $this->_last_ID;
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
        $sql = 'SELECT * FROM '. self::$_table .' WHERE barang_ID = :id LIMIT 1';
        $stmt = $this->_db->prepare($sql);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        if($stmt->rowCount() == 0){
            return ("Error: tidak ada item di database");
        }
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }


    function destroy($id= ''){
        try{
            $sql = 'DELETE FROM '. self::$_table .' WHERE nota_ID = :id LIMIT 1';
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
            $sql = 'SELECT count(*) FROM '. self::$_table .' WHERE surat_keluar_ID = :id LIMIT 1';
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
            $stmt = $this->_db->prepare("SELECT * FROM ".self::$_table." WHERE (nota_ID LIKE :cd_1) or (tanggal LIKE :cd_2) ORDER BY nota_ID DESC");
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




    function selectTransaksi($dari_tanggal = '', $sampai_tanggal ='', $petugas = 0){
        try{
            if($dari_tanggal != '' && $sampai_tanggal != ''){
                if($petugas == 0){
                    $pt = '';
                }else{
                    $pt = ' AND user_ID = "'. $petugas .'"';
                }
                $between = 'WHERE tanggal >= "'.$dari_tanggal.'" AND tanggal <= "'.$sampai_tanggal.'" '. $pt;
            }else{
                $between = '';
            }
            $sql = 'SELECT * FROM '. self::$_table. ' '. $between;
            $stmt = $this->_db->query($sql);
            return $stmt->fetchAll();
        }catch (PDOException $e){
            die("<h1>Could not connect to database::problem::SELECT_TRANSAKSI::NOTA
            <br><h2>". $e->getMessage(). $e->getFile().':::DI BARIS:::'.$e->getLine());
        }
        return 0;
    }

    function selectTransaksi_day(){
        $q = 'select count(nota_ID) as jumlah from nota where tanggal = "'. date("Y-m-d") .'"';
        $stmt = $this->_db->query($q);
        return $stmt->fetchColumn();
    }


    function selectTotalTransaksi_day(){
        $q = 'select SUM(total) as pendapatan from nota where tanggal = "'. date("Y-m-d") .'"';
        $stmt = $this->_db->query($q);
        return $stmt->fetchColumn();
    }



    function grafik_nota(){
        try{
            $stmt = $this->_db->query(
                'SELECT MONTH(tanggal) as bulan, COUNT(nota_ID) as jumlah, SUM(total) as total
FROM '.self::$_table.' WHERE YEAR(tanggal) = '.date('Y').' GROUP BY MONTH(tanggal)');
            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        }catch (PDOException $e){ die($e->getMessage()); }
        return array();
    }
    function auto_nota(){
        $q = 'SELECT max(nota_ID) as kodeTerbersar FROM nota';
        $stmt = $this->_db->query($q);
        return $stmt->fetch_array();
    }


}
