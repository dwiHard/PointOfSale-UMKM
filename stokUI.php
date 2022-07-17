<?php
session_start();
$page_title = 'Transaksi';
require_once 'my_func.php';
include_once 'template/header.php';
?>

<?php $db_connect= new db_connect();

$q = 'select count(barang_ID) as jum_brg from barang ';
$db = $db_connect->getConn();
$st = $db->query($q);
$jum_brg = $st->fetchColumn();
?>

<div id="content">
    <div class="section group">
<br>
        <h1># Data Master Barang</h1>
        <div>
            <a href="barangUI.php">
                <div class="col span_1_of_4 menu-icon">
                    <img src="img/barang.png">
                    <h2>Barang(<?php echo $jum_brg ?>)</h2>
                </div>
            </a>


            <a href="lokasi.php">
                <div class="col span_1_of_4 menu-icon">
                    <img src="img/lokasi.png">
                    <h2>Lokasi</h2>
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



