<?php
session_start();
$page_title = 'Transaksi';
require_once 'my_func.php';
include_once 'template/header.php';
?>



<div id="content">
    <div class="section group">
<br>
        <h1># Menu Lainnya</h1>
        <div>
            <a href="supplier.php">
                <div class="col span_1_of_4 menu-icon">
                    <img src="img/supplier.png">
                    <h2>Pengolahan Supplier</h2>
                </div>
            </a>

            <a href="userUI.php">
                <div class="col span_1_of_4 menu-icon">
                    <img src="img/user.png">
                    <h2>Pengolahan User</h2>
                </div>
            </a>

            <a href="produk_barcode_form.php">
                <div class="col span_1_of_4 menu-icon">
                    <img src="img/produk_barcode.png">
                    <h2>Produk Barcode Label</h2>
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



