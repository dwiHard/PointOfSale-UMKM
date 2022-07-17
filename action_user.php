<?php
session_start();
require_once 'my_func.php';
if(req_http() && $_POST['command'] == 'add'){

    if(strlen($_POST['username']) < 4){ die("<h2>Maaf, username tidak valid !!<br>mohon periksa kembali, field harus berupa kombinasi huruf & angka (mix 6 karakter) !");}
    if(strlen($_POST['pass'])  < 4){ die("<h2>Maaf, pass tidak valid !!<br>mohon periksa kembali, field harus berupa kombinasi huruf & angka (mix 6 karakter) !"); }
    if (!ctype_alnum($_POST['username']) || !ctype_alnum($_POST['pass'])){ die('<h2>Username atau Password yang Anda masukkan tidak valid, periksa kembali !'); }

    if($user->store($_POST)){
        header("Location: userUI.php?msg_op=1");
    }die('Error : user gagal di tambahkan, coba lagi !!');
}

if(req_http() && $_POST['command'] == 'edit'){
    $user->edit($_POST);
    header("Location: userUI.php?msg_op=2");
}


if(isset($_GET['command']) && $_GET['command'] == 'delete'){
    $uid = base64_decode($_GET['uid']);
    $user->delete1($uid);
    header("Location: userUI.php?msg_op=2");
}
