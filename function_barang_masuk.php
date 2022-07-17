<?php
require_once 'my_func.php';


function tambah_ke_transaksi($pid,$q, $hrg_beli, $hrg_jual){
    if($pid<1 or $q<1) return;

    if(isset($_SESSION['beli']) && is_array($_SESSION['beli'])){
        if(check_product($pid)) return;
        $max=count($_SESSION['beli']);
        $_SESSION['beli'][$max]['productid']=$pid;
        $_SESSION['beli'][$max]['qty']=$q;
        $_SESSION['beli'][$max]['harga_beli']=$hrg_beli;
        $_SESSION['beli'][$max]['harga_jual']=$hrg_jual;
    }
    else{
        $_SESSION['beli']=array();
        $_SESSION['beli'][0]['productid']=$pid;
        $_SESSION['beli'][0]['qty']=$q;
        $_SESSION['beli'][0]['harga_beli']=$hrg_beli;
        $_SESSION['beli'][0]['harga_jual']=$hrg_jual;
    }
}

function check_product($pid){
    $pid=intval($pid);
    $max=count($_SESSION['beli']);
    $flag=0;
    for($i=0;$i<$max;$i++){
        if($pid==$_SESSION['beli'][$i]['productid']){
            $flag=1;
            break;
        }
    }
    return $flag;
}



function remove_barang_transaksi($pid){
    $pid=intval($pid);
    $max=count($_SESSION['beli']);
    for($i=0;$i<$max;$i++){
        if($pid==$_SESSION['beli'][$i]['productid']){
            unset($_SESSION['beli'][$i]);
            break;
        }
    }
    $_SESSION['beli']=array_values($_SESSION['beli']);
}




function get_harga($pid){
    $db =new db_connect();
    $conn =$db->getConn();
    $q = "select harga_beli from barang where barang_ID=$pid";
    $st= $conn->query($q);
    return $st->fetch(PDO::FETCH_ASSOC)['harga_beli'];
}


function get_total_beli(){
    $max=count($_SESSION['beli']);
    $sum=0;
    for($i=0;$i<$max;$i++){
        $q=$_SESSION['beli'][$i]['qty'];
        $price=$_SESSION['beli'][$i]['harga_beli'];
        $sum+=$price*$q;
    }
    return $sum;
}
