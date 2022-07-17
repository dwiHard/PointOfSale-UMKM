<?php
require_once 'function_cart.php';
require_once 'function_barang_masuk.php';
require_once 'my_func.php';

if(isset($_POST['command']) && $_POST['command'] == 'add_to_cart' && $_POST['barcode'] != ""){
    //cari barang, apakah valid
       session_start();
    if(strlen($_POST['barcode']) < 12 && $_POST['barcode'] > 13){
        die("<h2>kode barcode tidak valid, mohon periksa kembali !");
    }
       $barcode=$_POST['barcode'];
       $pid = get_product_id($barcode);
       addtocart($pid,$_POST['jumlah']);
       header("Location:penjualan_addUI.php");
       exit();
}

//jasa



if(isset($_POST['command']) && $_POST['command'] == 'add_transaksi_jasa' && $_POST['jid'] > 0){
    session_start();
    $jid=$_POST['jid'];
    addjasa($jid,$_POST['jumlah']);
    header("Location:jasa_transaksi.php");
    print $jid;
}

//barang masuk
if( req_http() && isset($_POST['command']) && $_POST['command'] == 'add_barang_masuk'){
    session_start();

    if(isset($_SESSION['beli']) && is_array($_SESSION['beli']) && count($_SESSION['beli']) > 0 ){

        //check no_nota
        $check_nota = barang_masuk::getInstance()->check_nota($_POST['no_nota']);
        if($check_nota){
            die("<h2>Maaf, no nota sudah ada di database sebelumnya <br> <p>silahkan ganti no nota yang berbeda !");
        }

       $last_id = barang_masuk::getInstance()->store($_POST, get_total_beli());
       $max = count($_SESSION['beli']);
       $i= 0;
       while($i < $max){
           $check = barang::getInstance()->check_record_exists($_SESSION['beli'][$i]['productid']);
           if($check){
               $save = barang_masuk_detail::getInstance()->store(
               //simpan detail barang masuk
                   $_SESSION['beli'][$i]['productid'],
                   $_POST['no_nota'],
                   $_SESSION['beli'][$i]['harga_beli'],
                   $_SESSION['beli'][$i]['harga_jual'],
                   $_SESSION['beli'][$i]['qty'],
                   ($_SESSION['beli'][$i]['harga_beli'] * $_SESSION['beli'][$i]['qty'])
               );
               if($save){
                   //edit stok di table master brg
                   $edit = barang::getInstance()->edit_stok_barang(
                       $_SESSION['beli'][$i]['productid'],
                       $_SESSION['beli'][$i]['qty'],
                       $_SESSION['beli'][$i]['harga_beli'],
                       $_SESSION['beli'][$i]['harga_jual']
                   );
                   if(!$edit){
                       continue;
                   }
               }else{
                   continue;
               }
           }
           $i++;
       }
       unset($_SESSION['beli']);
        header("Location:barang_masuk.php?add=1");
    }else{
        die("barang yang di beli tidak boleh kosong !");
    }
}

if(isset($_GET['command']) && $_GET['command'] == 'delete_pembelian'){
    $no_nota = base64_decode($_GET['no']);
    if(barang_masuk::getInstance()->check_nota($no_nota) == 0){
        die("no nota tidak valid !");
    }
    else{
        $list_barang = barang_masuk_detail::getInstance()->show($no_nota);
        $max = count($list_barang);
        $i = 0;
        while($i< $max){
            $edit = barang::getInstance()->edit_jumlah_stok($list_barang[$i]['barang_ID'], $list_barang[$i]['jumlah']);
            $i++;
        }
        barang_masuk_detail::getInstance()->destroy($no_nota);
        barang_masuk::getInstance()->destroy($no_nota);
        header("Location:daftar_transaksi_pembelian.php?msg_op=3");
    }
}

if(isset($_GET['command']) && $_GET['command'] == 'delete_item_transaksi') {
    $brg_id = base64_decode($_GET['barang_id']);
    $nota = base64_decode($_GET['no_nota']);
    $jum = barang_masuk_detail::getInstance()->get_jumlah($nota);
    //jika barang tinggal 1 tidak dapat di hapus
    if($jum > 1){
        $item_yang_dihapus = barang_masuk_detail::getInstance()->check_record_exists($brg_id , $nota);
        if(count($item_yang_dihapus)>0 && !empty($item_yang_dihapus)){
            barang_masuk_detail::getInstance()->hapus_item($brg_id, $nota);
            //kurang subtotal di barang masuk
            barang_masuk::getInstance()->hapus_item_barang_masuk(
                $item_yang_dihapus['no_nota'],
                $item_yang_dihapus['sub_total']
            );
            //kurangi stok di master brg
            barang::getInstance()->edit_jumlah_stok($item_yang_dihapus['barang_ID'], $item_yang_dihapus['jumlah']);
            header("Location: daftar_transaksi_pembelian_detail.php?no=". base64_encode( $nota ) ."&&msg_op=3");
        }else{
            echo '<h2>item tidak valid !';
        }
    }
    else{
        die('<h2>error: item barang tidak dapat di hapus !');
    }
}
