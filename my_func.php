<?php
require_once 'IMysqlConn.php';

function MyAutoload($className){
    require_once "classes/".$className . ".php";
}
include_once "classes/barang.php";
include_once "classes/barang_masuk.php";
include_once "classes/barang_masuk_detail.php";
include_once "classes/db_connect.php";
include_once "classes/lokasi.php";
include_once "classes/nota.php";
include_once "classes/Paging.php";
include_once "classes/supplier.php";

include_once "classes/trait_database.php";

include_once "classes/transaksi_barang.php";
include_once "classes/users.php";

// Next, register it with PHP.
spl_autoload_register('MyAutoload');
date_default_timezone_set('Asia/Jakarta');

define('title','Inventory Toko ');
define('instansi','ATK');

define('salt1', ')');
define('salt2', '_');
define('TB_USER', 'user');


//Function to check if the request is an AJAX request
function is_ajax() {
    return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
}

// check pengiriman form
function req_http(){
    if($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['diajukan']){
        return true;
    }
    return false;
}

function string_sanitasi($var){
    $convers = htmlspecialchars($convers, ENT_QUOTES, 'UTF-8');
    //  Encoding entitas HTML dalam sebuah string
    $convers = htmlentities($convers, ENT_QUOTES, 'UTF-8');
    return trim($convers);
}


function permak_tanggal($date = ''){
    $tgl = substr($date, 8, 2);
    $bln = substr($date, 5, 2);
    $thn = substr($date, 0, 4);

    $tgl_lahir = $tgl.$bln.$thn;
    return $tgl_lahir;
}

function day_ON_INDO($N){
    $daftar_hari = array(1 => "senin", "selasa", "rabu", "kamis", "jum'at", "sabtu", "minggu");
    if(array_key_exists($N, $daftar_hari))
        return ucfirst($daftar_hari[$N]);
    return ;
}

function month_ON_INDO($_No){
    $daftar_bulan = array(
        '01' => "jan",
        '02' => "feb",
        '03' => "mar",
        '04' => "apr",
        '05' => "mei",
        '06' => "jun",
        '07' => "jul",
        '08' => "agus",
        '09' => "sept",
        '10' => "okto",
        '11' => "nov",
        '12' => "des");

    if(array_key_exists($_No, $daftar_bulan))
        return ucfirst($daftar_bulan[$_No]). '/';
    return ;
}

function tanggal_ON_INDO($date){
    $tgl = substr($date, 8, 2);
    $bln = month_ON_INDO(substr($date, 5, 2));
    $thn = substr($date, 0, 4);
    return $tgl."/". $bln."".$thn;
}


$barang = new barang();
$barang_masuk = new barang_masuk();
$barang_masuk_detail = new barang_masuk_detail();
$lokasi = new lokasi();
$nota = new nota();
$supplier =new supplier();
$transaksi_barang = new transaksi_barang();

$user = new users();
