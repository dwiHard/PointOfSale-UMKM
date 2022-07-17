<?php
session_start();
require_once 'my_func.php';
if(req_http() && $_POST['command'] == 'add'){
    $lokasi->store($_POST);
    header("Location: lokasi.php?msg_op=1");
}

if(req_http() && $_POST['command'] == 'edit'){
    $lokasi->edit($_POST);
    header("Location: lokasi.php?msg_op=2");
}



if($_GET['command'] == 'delete'){
    $id = base64_decode($_GET['id']);
    $check = $lokasi->check2($id);
    if(!$check){
        $lokasi->destroy($id);
        header("Location: lokasi.php?msg_op=3");
    }
    else{
        header("Location: lokasi.php?msg_op=4");
        
    }
}