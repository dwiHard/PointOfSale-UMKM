<?php
session_start();
$page_title = 'Product barcode';
require_once 'my_func.php';
$script = array('jquery-ean13.min.js');
//include_once 'template/header.php';
?>

<?php
if(! $user->check_auth()){
    header("Location: access_denied.php");
}
?>

<!DOCTYPE html>
<!-- HTML5 Boilerplate -->
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->

<head>

    <meta charset="utf-8">
    <!-- Always force latest IE rendering engine & Chrome Frame -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

    <title><?php echo $page_title. ' | '. title; ?></title>
    <meta name="description" content="This is the Responsive Grid System, a quick, easy and flexible way to create a responsive web site.">
    <meta name="keywords" content="responsive, grid, system, web design">

    <meta name="author" content="www.grahamrobertsonmiller.co.uk">

    <meta http-equiv="cleartype" content="on">

    <link rel="shortcut icon" href="/favicon.ico">

    <!-- Responsive and mobile friendly stuff -->
    <meta name="MobileOptimized" content="320">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Stylesheets -->
    <link rel="stylesheet" href="css/html5reset.css" media="print">
    <style>
        body, html, *{
            color:#212121;
        }
        .barcode{
            padding:10px;
            border:dotted 1px #ccc;
            display: inline-block;
        }
        .barcode span{
            display: block;
            float: left;
            width: 200px;
            padding-bottom: 10px;
            font-size: 13px;
            font-family: arial, tahoma, helvetica, sans-serif;
        }
        .clear{
            clear: both;
        }
        canvas{
            float: left;
        }
    </style>

    <script src="js/jquery.min.js"></script>
    <?php
    if(isset($script) && count($script) >= 1){
        foreach($script as $v){
            echo '<script src="js/'.$v.'"></script>';
        }
    }
    ?>
    <script src="js/app.js"></script>
</head>
<body>
  <?php if(!isset($_POST['id'])){
    die('invalid!');
  } ?>

<div id="content">
    <div class="section group" style="padding-top: 0; padding-bottom: 0; margin: 0;">

        <h2># Product barcode : <?php echo $_POST['id'] ?> | <a href="produk_barcode_form.php"> << kembali </a></h2>
        <?php

        $i=1;
        $j=1;
        while($j <= 8){
        foreach(barang::getInstance()->selectProductBarcode( $_POST['id'] ) as $k=> $v){
           
            
            echo '
                <div class="barcode">
                <span>'. $v['nama'] .'</span><div class="clear"></div>
                <canvas class="'. $j .'" width="300" height="140"></canvas>
                </div>';

            ?>
            <script type="text/javascript">
                $(".<?php echo $j ?>").EAN13("<?php echo $v['kode_barang'] ?>",{

// only printing the <a href="#">barcode</a> use the code below.
                    number: true,

// show country prefix.
                    prefix: true,

//  the color of <a href="#">barcode</a>.
                    color: "#212121",

// the background of <a href="#">barcode</a>.
                    background: null,

// padding
                    padding: 0,

// debug mode
                    debug: false,

// callbacks
                    onValid: function() {},
                    onInvalid: function() {},
                    onSuccess: function() {},
                    onError: function() {}
                });

            </script>
        <?php
        }
           $j++; 
        }
        ?>
    </div>

    <?php
    include_once 'template/footer.php';
    ?>



