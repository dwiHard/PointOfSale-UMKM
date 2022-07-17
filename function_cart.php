<?php
require_once 'my_func.php';

function addtocart($pid,$q){
    if($pid<1 or $q<1) return;

    if(is_array($_SESSION['cart'])){
        if(product_exists($pid)) return;
        if(! check_stok($pid, $q)) {
            $max=count($_SESSION['cart']);
            $_SESSION['cart'][$max]['productid']=$pid;
            $_SESSION['cart'][$max]['qty']=$q;
        }else{
            $_SESSION['info'] = 'stok barang tidak cukup untuk di order !';
        }
    }
    else{
        if(! check_stok($pid, $q)){
            $_SESSION['cart']=array();
            $_SESSION['cart'][0]['productid']=$pid;
            $_SESSION['cart'][0]['qty']=$q;
        }else{
            $_SESSION['info'] = 'stok barang tidak cukup untuk di order !';
        }
    }
}

function product_exists($pid){
    $pid=intval($pid);
    $max=count($_SESSION['cart']);
    $flag=0;
    for($i=0;$i<$max;$i++){
        if($pid==$_SESSION['cart'][$i]['productid']){
            $flag=1;
            break;
        }
    }
    return $flag;
}


function get_product_name($pid){
    $db =new db_connect();

    $conn =$db->getConn();
    $q = "select nama from barang where barang_ID=$pid";
    $st= $conn->query($q);
    return $st->fetch(PDO::FETCH_ASSOC)['nama'];
}

function get_product_id($barcode){
    $db =new db_connect();

    $conn =$db->getConn();
    $q = "select barang_id from barang where kode_barang = $barcode";
    $st= $conn->query($q);
    if($st->rowCount() ==0){
        print '<h2>produk tidak di temukan !!</h2>';
    }
    return $st->fetch(PDO::FETCH_ASSOC)['barang_id'];
}



function get_price($pid){
    $db =new db_connect();

    $conn =$db->getConn();
    $q = "select harga_jual from barang where barang_ID=$pid";
    $st= $conn->query($q);
    return $st->fetch(PDO::FETCH_ASSOC)['harga_jual'];
}

//harga_beli
function get_price_beli($pid){
    $db =new db_connect();

    $conn =$db->getConn();
    $q = "select harga_beli from barang where barang_ID=$pid";
    $st= $conn->query($q);
    return $st->fetch(PDO::FETCH_ASSOC)['harga_beli'];
}


function get_order_total(){
    //php7
    //$max=count($_SESSION['cart']);
    //php8
    @$max=count($_SESSION['cart']);
    $sum=0;
    for($i=0;$i<$max;$i++){
        $pid=$_SESSION['cart'][$i]['productid'];
        $q=$_SESSION['cart'][$i]['qty'];
        $price=get_price($pid);
        $sum+=$price*$q;
    }
    return $sum;
}

function remove_product($pid){
    $pid=intval($pid);
    $max=count($_SESSION['cart']);
    for($i=0;$i<$max;$i++){
        if($pid==$_SESSION['cart'][$i]['productid']){
            unset($_SESSION['cart'][$i]);
            break;
        }
    }
    $_SESSION['cart']=array_values($_SESSION['cart']);
}



function check_stok($pid, $qty_permitaan){
    $q = "select stok from barang where barang_ID = $pid";

    $db =new db_connect();

    $st = $db->getConn()->query($q);
    $stok = $st->fetchColumn();
    if($qty_permitaan > $stok){
        return 1;
    }
    return 0;

}



