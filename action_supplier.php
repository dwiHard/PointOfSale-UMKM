<?php
session_start();
require_once 'my_func.php';
if(req_http() && $_POST['command'] == 'add'){
    $supplier->store($_POST);
    header("Location: supplier.php?msg_op=1");
}

if(req_http() && $_POST['command'] == 'edit'){
    $supplier->edit($_POST);
    header("Location: supplier.php?msg_op=2");
}



if($_GET['command'] == 'delete'){
    $id = base64_decode($_GET['id']);
    $check = $barang_masuk->check_jum_data_supplier($id);
    if(!$check){
        $supplier->destroy($id);
        header("Location: supplier.php?msg_op=3");
    }
    else{
        header("Location: supplier.php?msg_op=4");
       
    }
}