<?php
session_start();
$page_title = 'Transaksi';
require_once 'my_func.php';
include_once 'template/header.php';
?>



<div id="content">
    <div class="section group">
<br>
        <h1># Laporan Penjualan</h1>
        <div>
            <a href="laporan_penjualan.php">
                <div class="col span_1_of_4 menu-icon">
                    <img src="img/laporan.png">
                    <h2>Laporan Transaksi Penjualan</h2>
                </div>
            </a>

            <a href="laporan_penjualan_barang.php">
                <div class="col span_1_of_4 menu-icon">
                    <img src="img/laporan.png">
                    <h2>Laporan Penjualan Barang</h2>
                </div>
            </a>

            <a href="laporan_stok.php">
                <div class="col span_1_of_4 menu-icon">
                    <img src="img/laporan.png">
                    <h2>Laporan Stok Barang</h2>
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



