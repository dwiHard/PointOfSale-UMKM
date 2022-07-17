<?php
class transaksi_barang implements IMysqlConn{
    private $_last_ID;
    static $_instance;
    static $_table = 'transaksi_barang';
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

    function store($nota_id = '', $barang_id = '', $qty='', $harga ='', $harga_beli = ''){
        try{
            $sql = 'INSERT into '. self::$_table. ' VALUES ( ?, ?, ?, ?, ?)';
            $stmt = $this->_db->prepare($sql);
            $stmt->execute(array(
                $nota_id,
                $barang_id,
                $qty,
                $harga, //harga jual
                $harga_beli
            ));
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
        $sql = 'SELECT * FROM '. self::$_table .' WHERE nota_ID = :id';
        $stmt = $this->_db->prepare($sql);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        if($stmt->rowCount() == 0){
            return ("Error: tidak ada item di database");
        }
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
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

    function destroy_by_nota($id= ''){
        try{
            $sql = 'DELETE FROM '. self::$_table .' WHERE nota_ID = :id';
            $stmt = $this->_db->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            return 1;
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



    function selectTransaksi($dari_tanggal = '', $sampai_tanggal ='', $petugas = 0){
        try{
            if($dari_tanggal != '' && $sampai_tanggal != ''){
                if($petugas == 0){
                    $pt = '';
                }else{
                    $pt = ' AND n.user_ID = "'. $petugas .'"';
                }
                $between = 'WHERE n.tanggal >= "'.$dari_tanggal.'" AND n.tanggal <= "'.$sampai_tanggal.'" '. $pt;
            }else{
                $between = '';
            }

            $sql = 'select
                n.tanggal, n.jam, n.total, n.user_ID, tb.nota_ID, tb.barang_ID, tb.qty, tb.harga_jual, tb.harga_beli, b.kode_barang,b.nama
                from transaksi_barang tb
                left join nota n using (nota_ID)
                left join barang b using (barang_ID) '. $between;

            $stmt = $this->_db->query($sql);
            return $stmt->fetchAll();
        }catch (PDOException $e){
            die("<h1>Could not connect to database::problem::SELECT_TRANSAKSI::NOTA
            <br><h2>". $e->getMessage(). $e->getFile().':::DI BARIS:::'.$e->getLine());
        }
        return 0;
    }



}