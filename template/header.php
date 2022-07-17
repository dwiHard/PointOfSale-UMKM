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
    <meta name="HandheldFriendly" content="True">
    <meta name="MobileOptimized" content="320">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Stylesheets -->
    <link rel="stylesheet" href="css/html5reset.css" media="all">
    <link rel="stylesheet" href="css/col.css" media="all">
    <link rel="stylesheet" href="css/2cols.css" media="all">
    <link rel="stylesheet" href="css/3cols.css" media="all">
    <link rel="stylesheet" href="css/4cols.css" media="all">
    <link rel="stylesheet" href="css/5cols.css" media="all">
    <link rel="stylesheet" href="css/6cols.css" media="all">
    <link rel="stylesheet" href="css/7cols.css" media="all">
    <link rel="stylesheet" href="css/8cols.css" media="all">
    <link rel="stylesheet" href="css/9cols.css" media="all">
    <link rel="stylesheet" href="css/10cols.css" media="all">
    <link rel="stylesheet" href="css/11cols.css" media="all">
    <link rel="stylesheet" href="css/12cols.css" media="all">
    <link rel="stylesheet" href="css/jquery.datetimepicker.min.css">
    <link rel="stylesheet" href="css/layout.css">

    <!-- Link Google Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Dosis:wght@600&family=Roboto&display=swap" rel="stylesheet"> 
    <script src="js/jquery.min.js"></script>
    <?php
        if(isset($script) && count($script) >= 1){
            foreach($script as $v){
                echo '<script src="js/'.$v.'"></script>';
            }
        }
    ?>
    <script src="js/jquery.datetimepicker.full.min.js"></script>
    <script src="js/app.js"></script>
</head>
<body>
<div class="wrapper" >
    <h2 style="font-size:28px;">Point Of sales |<span style="color:yellow;"> Toko </span><span style="font-size: 12px; font-weight: normal; color:#ccc;">Login As : <?php echo $_SESSION['__username'] ?> </span></h2><br>

    <div class="section group">
        <div class="span_2_of_2" style="margin-bottom: 60px">
            <nav>
                <ul>
                    <li><a href="http://localhost/toko/" class="primary" style="border: 1px solid white;margin-right:20px">Dashboard</a></li>
                    <li><a href="logout.php" class="error" style="border: 1px solid white;margin-right:20px">Keluar</a></li>
                </ul>
            </nav>
        </div>
    </div><!--// sec head -->
</div>
