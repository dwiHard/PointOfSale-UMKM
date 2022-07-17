<?php
session_start();
$page_title = 'hasil laporan stok barang';
require_once 'my_func.php';
$script= array("jquery.datetimepicker.full.min.js");
?>

<html>
<head>
    <title>Hasil Laporan Stok Barang</title>
</head>
<style>
    html, body{
        width: 900px; 
        margin:0 auto;
        font-family: arial;
    }

    table, td, tr{
        padding: 10px !important;
        border: solid 1px #ccc;
    }
    td{
        padding: 2px 10px;

    }
    table{
        border-collapse: collapse;
    }
    table thead{
        background: #f2f2f2;
    }

    table thead tr td,
    table thead tr{
        border:solid 1px #fff;
    }
    .msg{
        background: rgba(201, 234, 226, 0.89);
        border:solid 1px #A4E1EA;
        padding: 4px 10px;
    }

    table thead tr th{
        padding: 4px;
        background: #f2f2f2;
        border:solid 1px #999;
    }

</style>
<body>
<?php
if(isset($_POST['command']) && $_POST['command'] == 'select' && isset($_POST['diajukan'])){

    if($_POST['jum_stok'] == 0){
        $op = "=";
    }elseif($_POST['jum_stok'] == 10 || $_POST['jum_stok'] == 20 || $_POST['jum_stok'] == 30 ){
        $op = "<=";
    }elseif($_POST['jum_stok'] == "31"){
        $op = ">=";
    }else{
        $op = "=";
    }
    $res = barang::getInstance()->show_barang_bystok( $_POST['jum_stok'], $op );
    if(count($res) == 0){
        echo '<h2 class="msg error">tidak ada barang dengan stok '.$op.' '.$_POST['jum_stok'].' !</h2>';
    }else{

        ?>

        <div id="info-select" style="margin-bottom: 10px">
            <hr>
            <h2 style="background:#f2f2f2; display: inline">Laporan Barang Dengan Stok Akhir <?php echo $op.' '. $_POST['jum_stok']; ?>

                <a href="javascript:window.print()">Print</a>
            </h2>

        </div>

        <table style="font-size: 15px;">
            <thead>
            <tr>
                <th>No</th>
                <th>Barcode</th>
                <th>Nama</th>
                <th>Lokasi</th>
                <th>Harga Beli</th>
                <th style='background:#E6E877'>Harga Jual</th>
                <th>Stock Akhir</th>
                <th>Terjual</th>
                <th>Action </th>
            </tr>
            </thead>
            <tbody>

            <?php

            $i=1;
            foreach($res as $k => $v){
                echo '<tr>';
                echo '<td>'.$i.'</td>';
                echo "<td>".$v['kode_barang']."</td>";
                echo "<td>".$v['nama']."</td>";
                echo "<td>". Lokasi::getInstance()->show($v['lokasi_id']) ['nama_lokasi'] ."</td>";
                echo "<td>".number_format ($v['harga_beli'], 0, ',', '.')."</td>";
                echo "<td style='background:#DDE8A6'>".number_format ($v['harga_jual'], 0, ',', '.')."</td>";


                echo "<td>".$v['stok']."</td>";
                echo "<td>".$v['terjual']."</td>";

                echo "<td><a target='blank' href='barang_detailUI.php?id=". base64_encode($v['barang_ID']) ."'>Detail</a>


                        </td>";
                echo '</tr>';

                $i++;
            }

            ?>
            </tbody>

        </table>


        Total Row : <?php echo count($res); ?> record


    <?php
    }
}
?>
</body>
</html>