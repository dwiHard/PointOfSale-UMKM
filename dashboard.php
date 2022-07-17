<?php
session_start();
$page_title = 'Dashboard';
$script = array("highcharts.js","exporting.js");
require_once 'my_func.php';
include_once 'template/header.php';
?>
    <div id="content">
<?php $db_connect= new db_connect();

$q = 'select count(barang_ID) as jum_brg from barang ';
$db = $db_connect->getConn();
$st = $db->query($q);
$jum_brg = $st->fetchColumn();


$q = 'select count(nota_ID) as jum_brg from nota';
$db = $db_connect->getConn();
$st = $db->query($q);
$jum_trans = $st->fetchColumn();



?>
        <div class="section group"><hr>
            <a href="stokUI.php">
                <div class="col span_1_of_4 menu-icon">
                    <img src="img/product.png">
                    <h2>Master Data Barang</h2>
                </div>
            </a>
<?php
if ($_SESSION['__username'] == 'admin'){
    echo "<a href='transaksiUI.php'><div class='col span_1_of_4 menu-icon'><img src='img/transaksi.png'><h2>Total Transaksi </h2></div></a>";
}else{
    echo "<a href='penjualan_barangUI.php'><div class='col span_1_of_4 menu-icon'><img src='img/cart.png'><h2>Penjualan <br>Pada Pelanggan(" . $jum_trans . ")</h2></div></a>";
}
?>
<?php
if ($_SESSION['__username'] == 'admin'){
    echo "<a href='laporanUI.php'><div class='col span_1_of_4 menu-icon'><img src='img/cart.png'><h2>Laporan Penjualan</h2></div></a>";
}else{
    echo "<a href='daftar_transaksi_pembelian.php'><div class='col span_1_of_4 menu-icon'><img src='img/product.png'><h2>Pembelian<br> Pada Supplier</h2></div></a>";
}
?>

<?php
if ($_SESSION['__username'] == 'admin'){
    echo "<a href='menuUI.php'><div class='col span_1_of_4 menu-icon'><img src='img/pembelian.png'><h2>Menu Lainnya</h2></div></a>";
}else{
    echo "<a href='produk_barcode_form.php'><div class='col span_1_of_4 menu-icon'><img src='img/produk_barcode.png'><h2>Tampilkan Barcode</h2></div></a>";
}
            ?>  

            <?php
            $arr = array();
            $data = $nota->grafik_nota();
            $i = 1;
            while($i <= 12){
                foreach($data as $k => $v){
                    if($i == $v['bulan']){
                        $arr [$v['bulan']] = $v['total'];
                        break;
                    }
                    if($i !== $v['bulan']){
                        $arr [$i] = 0;
                    }
                }
                $i++;
            }
            ?>



        </div>
    <div class="section group">
        <div id="grafik" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
     </div>

    <div class="section group">
        <div class="alert info">
            Jumlah transaksi hari ini : <span class="count"><?php echo nota::getInstance()->selectTransaksi_day(); ?></span> kali
        </div>

    <div class="alert info">
        Total Penjualan hari ini : Rp. <span class="count"><?php echo number_format (nota::getInstance()->selectTotalTransaksi_day(), 0, ',', '.'); ?></span>
    </div>

   <div>


    </div>

    <script>
        $(function () {

            $('#grafik').highcharts({
                colors: ['#547bbb'],
                chart: {
                    zoomType: 'xy'
                },
                title: {
                    text: 'Data Penjualan Toko,  ATK, Atau UKM Per-bulan Thn.'+ (new Date).getFullYear()
                },

                xAxis: [{
                    categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
                        'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                    crosshair: true
                }],
                yAxis: [{ // Primary yAxis
                    labels: {
                        format: '{value}°C',
                        style: {
                            color: Highcharts.getOptions().colors[1]
                        }
                    },
                    title: {
                        text: 'Total Transaksi Penjualan',
                        style: {
                            color: Highcharts.getOptions().colors[1]
                        }
                    }
                }, { // Secondary yAxis
                    title: {
                        text: 'Rainfall',
                        style: {
                            color: Highcharts.getOptions().colors[0]
                        }
                    },
                    labels: {
                        format: '{value}',
                        style: {
                            color: Highcharts.getOptions().colors[0]
                        }
                    },
                    opposite: true
                }],
                tooltip: {
                    shared: true
                },
                legend: {
                    layout: 'vertical',
                    align: 'left',
                    x: 120,
                    verticalAlign: 'top',
                    y: 100,
                    floating: true,
                    backgroundColor: (Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF'
                },
                series: [{
                    data : [
                        <?php
                            $i =1;
                            while($i <= 12){
                                echo  $arr[$i].',';
                                $i++;
                            }
                        ?>],
                    name: 'Total Penjualan',
                    type: 'column',
                    yAxis: 1,
                    //data: [1, 0, 106, 122, 144, 176, 135, 148, 216, 194, 95, 54],
                    tooltip: {
                        valueSuffix: ''
                    }

                }]

            });
        });
    </script>

<?php
include_once 'template/footer.php'; ?>
