<?php
session_start();
$page_title = 'Laporan penjualan barang';
require_once 'my_func.php';
$script= array("jquery.datetimepicker.full.min.js");
?>

<html>
<head>
    <title>Laporan Penjualan Barang</title>
</head>
<style>
    html, body{
        width: 1200px; 
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

    table thead tr th{
        padding: 4px;
        background: #f2f2f2;
        border:solid 1px #999;
    }

    table tbody tr:hover{
        background: #ffff99;
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
</style>
<body>
<?php
if(isset($_POST['command']) && $_POST['command'] == 'select' && isset($_POST['diajukan'])){

    if(empty($_POST['dr_tgl']) || empty($_POST['smp_tgl'])){
        echo '<h2>pilih tanggal per-Periode !</h2>';
    }
    //transaksi penjualan barang
    $res = transaksi_barang::getInstance()->selectTransaksi($_POST['dr_tgl'], $_POST['smp_tgl'], $_POST['petugas_ID']);
    if(count($res) == 0){
        echo '<h2 class="msg error">tidak ada transaksi berdasarkan tanggal yang Anda masukkan !</h2>';
    }else{

        ?>

        <div id="info-select" style="margin-bottom: 10px">
            <hr>
            <h2 style="background:#f2f2f2; display: inline">Laporan Transaksi Penjualan Barang Dari Tanggal

                <span style="background:#E5E8A5;"><?php echo date("d-m-Y", strtotime($_POST['dr_tgl'])) ?></span> S/d
                <span style="background:#E5E8A5;"><?php echo date("d-m-Y", strtotime($_POST['smp_tgl'])) ?></span>
                <a href="javascript:window.print()">Print</a>
            </h2><hr>

        </div>
        <table style="font-size: 15px">
            <thead>
            <tr>
                <th>No</th>
                <th>Tanggal & Jam</th>
                <th>No.Nota</th>
                <th>Kasir</th>
                <th>Barcode</th>
                <th>Nama Barang</th>
                <th>Harga Beli</th>
                <th>Harga Jual</th>
                <th>Jumlah </th>
                <th>Total Bayar</th>
                <th>View</th>
                <th>Untung</th>


            </tr>
            </thead>
            <tbody>

            <?php
            $untung = 0;
            $total = 0;
            $i = 1;
            foreach($res as $k => $v){
                echo '<tr>';
                echo '<td>'.$i.'</td>';
                echo "<td>". date('d/m/Y', strtotime( $v['tanggal'] ))." | ".date("H:i", strtotime($v['jam'])) ."</td>";
                echo "<td>".$v['nota_ID']."</td>";

                echo "<td>".$user->getNama($v['user_ID'])."</td>";
                echo "<td>". $v['kode_barang'] ."</td>";
                echo "<td>". $v['nama'] ."</td>";

                echo "<td>Rp. ".number_format ($v['harga_beli'], 0, ',', '.')."</td>";
                echo "<td>Rp. ".number_format ($v['harga_jual'], 0, ',', '.')."</td>";

                echo "<td>". $v['qty'] ."</td>";
                echo "<td>Rp. ".number_format ($v['total'], 0, ',', '.')."</td>";


                $untung +=($v['harga_jual'] - $v['harga_beli']) * $v['qty'];
                echo "<td><a target='blank' href='nota_detailUI.php?id=". base64_encode( $v['nota_ID'] )."'>view</a></td>";
                echo "<td>Rp. ".number_format (($v['harga_jual'] - $v['harga_beli']) * $v['qty'], 0, ',', '.')."</td>";

                echo '</tr>';
                $total += $v['total'];

                $i++;
            }
            ?>
            </tbody>
            <tfoot>
            <tr>
                <td colspan="9" style="text-align: right; background: #f2f2f2">Total Omset Penjualan :</td>
                <td colspan="2" style="background: #f2f2f2; color:blue; font-weight: bold">Rp. <?php echo number_format ($total, 0, ',', '.');?></td>

                <td colspan="1" style="background: #f2f2f2; color:green; font-weight: bold">Rp. <?php echo number_format ($untung, 0, ',', '.');?></td>


            </tr>
            </tfoot>
        </table>
        Total Row : <?php echo count($res); ?> record


    <?php
    }
}
?>
</body>
</html>