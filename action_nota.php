<?php
session_start();
require_once 'my_func.php';
if(isset($_GET['command']) && $_GET['command'] == 'delete'){
    $id = base64_decode($_GET['id']);
    //lihat_array($_GET);
    //print $id;

    $transaksi = $transaksi_barang->show($id);
    $max = count($transaksi);
    $i = 0;
    while($i< $max){
        $barang->set_balik_stok($transaksi[$i]['barang_ID'],$transaksi[$i]['qty']);
        $nota->destroy($id);
        $transaksi_barang->destroy_by_nota($id);
        $i++;
    }
    header("Location: penjualan_barangUI.php?msg_op=3");
}