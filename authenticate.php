<?php
session_start();
require_once 'my_func.php';
require_once 'classes/users.php';

$UserIntance = users::getInstance();
$login = $UserIntance->login($_POST['username'],$_POST['pass']);
if($login == 1){
    header("Location: dashboard.php");
}
else{
    header("Location: login.php?pesan=gagal");
}


