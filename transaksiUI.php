<?php
session_start();
$page_title = 'Transaksi';
require_once 'my_func.php';
$script = array("highcharts.js","exporting.js");
include_once 'template/header.php';
?>
<?php $db_connect= new db_connect();

$q = 'select count(nota_ID) as jum_brg from nota';
$db = $db_connect->getConn();
$st = $db->query($q);
$jum_trans = $st->fetchColumn();

?>

<div id="content">
    <div class="section group">
<br>
        <h1># Transaksi</h1>
        <div>
            <a href="penjualan_barangUI.php">
                <div class="col span_1_of_4 menu-icon">
                    <img src="img/cart.png">
                    <h2>Penjualan <br>Pada Pelanggan(<?php echo $jum_trans ?>)</h2>
                </div>
            </a>


            <a href="daftar_transaksi_pembelian.php">
                <div class="col span_1_of_4 menu-icon">
                    <img src="img/product.png">
                    <h2>Pembelian <br> Pada Supplier</h2>
                </div>
            </a>

            <a href="dashboard.php">
                <div class="col span_1_of_4 menu-icon">
                    <img src="img/home.png">
                    <h2>Kembali Ke Beranda</h2>
                </div>
            </a>

        </div>
        <br><br><br><br> <br><br>
        


</div>
<?php
include_once 'template/footer.php'; ?>



