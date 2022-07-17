<?php
class users implements IMysqlConn{

    static $_instance;
    static $_table = 'user';
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

    public function query($sql) {
        //Run a query using $this->_db
        return pg_query($this->_db,$sql);
    }



    function login($username, $pass){
        $token_encrip = hash('ripemd128', salt1.$pass.salt2);
        try{
            $sql = 'SELECT * FROM '. self::$_table .' WHERE username = ? AND pass = ?';
            $stmt = $this->_db->prepare($sql);
            $stmt->execute(array(
                $username,
                $token_encrip
            ));
            if($stmt->rowCount() == 1){
                $r = $stmt->fetch(PDO::FETCH_ASSOC);
                $_SESSION['__username'] = $r['username'];
                $_SESSION['__nama'] = $r['nama'];
                $_SESSION['__auth'] = 1;
                $_SESSION['__userID'] = $r['user_ID'];
                return 1;
            }
        }catch (PDOException $e){
            die($e->getMessage());
        }
        return 0;
    }

    public function check_auth(){
        if(isset($_SESSION['__auth']) && !empty($_SESSION['__username'])){
            return 1;
        }
        return 0;
    }

    public function getAll(){
        $sql = 'SELECT * FROM '. self::$_table .' WHERE level = "user" ORDER BY nama';
        $stmt = $this->_db->query($sql);
        $stmt->execute();
        if($stmt->rowCount() == 0){
            return ("Error: user tidak di temukan");
        }
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    function store($v = array()){
        try{
            $token = hash('ripemd128', salt1.$v['pass'].salt2);
            $sql = 'INSERT into '. self::$_table. ' VALUES (null, ?, ?, ?, ?, ?, ?, ?, ?)';
            $stmt = $this->_db->prepare($sql);
            $stmt->execute(array(
                $v['username'],
                $token,
                $v['nama'],
                $v['email'],
                'user',
                $v['peran'],
                date('Y-m-d'),
                date('Y-m-d')
            ));
            return 1;
        }catch (PDOException $e){
            die($e->getMessage());
        }
        return 0;
    }





    public function getNama($id = ''){
        $sql = 'SELECT nama FROM '. self::$_table .' WHERE user_ID = :id';
        $stmt = $this->_db->prepare($sql);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        if($stmt->rowCount() == 0){
            return ("Error: user tidak di temukan");
        }
        return $stmt->fetch(PDO::FETCH_ASSOC)['nama'];
    }

    function show($user_ID = ''){
        try{
            $sql = 'SELECT * FROM '.self::$_table . ' WHERE user_ID = ?';
            $stmt = $this->_db->prepare($sql);
            $stmt->execute(array(
               $user_ID
            ));
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }catch (PDOException $e){
            die($e->getMessage());
        }
        return 0;
    }

    function edit($v = ''){
        try{
            $token2 = hash('ripemd128', salt1.$v['pass'].salt2);

            $sql = 'UPDATE '.self::$_table.' SET
            pass=?, nama = ?, email = ?, updated_at = ? WHERE user_ID = ?';
            $stmt= $this->_db->prepare($sql);
            $stmt->execute(array(
               $token2,
               $v['nama'],
               $v['email'],
               date('Y-m-d'),
               $v['user_ID']
            ));
            return 1;
        }catch (PDOException $e){
            die($e->getMessage());
        }
        return 0;
    }

    //check pass saat ini
    function check_pass($user_ID = '', $pass_lama = ''){
        try{
            $sql = 'SELECT * FROM '.self::$_table.' WHERE user_ID = ? && pass = ? LIMIT 1';
            $stmt = $this->_db->prepare($sql);
            $stmt->execute(array(
               $user_ID,
               $pass_lama
            ));

            if($stmt->rowCount() == 1){
                return 1;
            }
        }catch (PDOException $e){
            die($e->getMessage());
        }
         return 0;
    }

    function delete1($id= ''){
        try{
            $sql = 'DELETE FROM '. self::$_table .' WHERE user_ID = :id';
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
