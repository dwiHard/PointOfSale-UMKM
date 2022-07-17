<?php
session_start();
require_once 'my_func.php';
if(req_http() && $_POST['command'] == 'add'){
    $_POST['harga_beli'] = preg_replace("/[.]/", "", $_POST['harga_beli']);
    $_POST['harga_jual'] = preg_replace("/[.]/", "", $_POST['harga_jual']);
    if($barang->store($_POST)){
        header("Location: barangUI.php?msg_op=1");
    }die('Error : produk gagal di tambahkan !');

}


if(req_http() && $_POST['command'] == 'edit'){
    $_POST['harga_beli'] = preg_replace("/[.]/", "", $_POST['harga_beli']);
    $_POST['harga_jual'] = preg_replace("/[.]/", "", $_POST['harga_jual']);
    $barang->edit($_POST);
    header("Location: barangUI.php?msg_op=2");
}


if(isset($_GET['command']) && $_GET['command'] == 'delete'){


    $id = base64_decode($_GET['id']);
    $check_data_transaksi_beli = $barang_masuk_detail->check_jum_data_barang($id);



    $check_data_transaksi_jual = $transaksi_barang->check_jum_data_barang($id);


    if($check_data_transaksi_beli){
        header("Location: barangUI.php?msg_op=4");
    }elseif($check_data_transaksi_jual){
        header("Location: barangUI.php?msg_op=5");
    }else {
        $barang->destroy($id);
        header("Location: barangUI.php?msg_op=3");
    }
}