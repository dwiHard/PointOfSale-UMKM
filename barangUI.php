<?php
session_start();
$page_title = 'Inventory';
$script = array('jquery.maskMoney.min.js');
require_once 'my_func.php';
include_once 'template/header.php';
?>
<script>
    $(function () {
        $('#harga_beli,#harga_jual ').maskMoney({prefix:'', thousands:'.', decimal:',', precision:0});
    });
</script>

    <div id="content">
        <div class="section group">
            <div class="col span_3_of_6 judul-page">
                <h1># Master Barang <a href="barang_addUI.php" class="btn success">Tambah</a></h1>

            </div>
            <div class="col span_3_of_6">
                <form method="post" action="barang_search.php" accept-charset="utf-8">
                    <div style="display: inline; margin-top: 10px">
                        <input type="text" name="keyword" placeholder="Cari kode/nama barang" style="padding: 6px;">
                    </div>
                    <input type="hidden" name="diajukan" value="1">
                    <input type="submit" value="Pencarian" style="padding: 9px;">
                </form>
            </div>
        </div>
        <!-- //top-page -->

        <div class="section group">

                <?php
                    if(isset($_GET['msg_op']) && $_GET['msg_op'] == 1){
                        echo '<div class="msg success">Success : barang berhasil ditambahkan ke database !</div>';
                    }
                if(isset($_GET['msg_op']) && $_GET['msg_op'] == 2){
                    echo '<div class="msg success">Success : data barang berhasil di perbarui !</div>';
                }
                if(isset($_GET['msg_op']) && $_GET['msg_op'] == 3){
                    echo '<div class="msg success">Success : 1 record barang berhasil di hapus !</div>';
                }
                if(isset($_GET['msg_op']) && $_GET['msg_op'] == 4){
                    echo '<div class="msg error">Maaf : kami tidak dapat menghapus barang yang Anda maksud,
                     karna masih memiliki keterkaitan dengan transaksi Pembelian !</div>';
                }
                if(isset($_GET['msg_op']) && $_GET['msg_op'] == 5){
                    echo '<div class="msg error">
                    Maaf : kami tidak dapat menghapus barang yang Anda maksud,
                     karna masih memiliki keterkaitan dengan transaksi Penjualan !</div>';
                }


                ?>
                <div style="overflow-x:auto">
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
                        <th colspan="2">Action </th>
                    </tr>
                    </thead>
                    <tbody>

                    <?php
                    $results_per_page=20;
                    $pg_query="SELECT * FROM ". barang::$_table;
                    $pg=new Paging($pg_query,$results_per_page);
                    $start=$pg->get_start();
                    $query= $pg_query." ORDER BY barang_ID DESC LIMIT $start,$results_per_page ";
                    $hasil = $barang->querySELECT($query);
                    $i = $start + 1;
                    foreach($hasil as $k => $v){
                        echo '<tr>';
                        echo '<td>'.$i.'</td>';
                        echo "<td>".$v['kode_barang']."</td>";
                        echo "<td>".$v['nama']."</td>";
                        echo "<td>". Lokasi::getInstance()->show($v['lokasi_id']) ['nama_lokasi'] ."</td>";
                        echo "<td>".number_format ($v['harga_beli'], 0, ',', '.')."</td>";
                        echo "<td style='background:#DDE8A6'>".number_format ($v['harga_jual'], 0, ',', '.')."</td>";


                        echo "<td>".$v['stok']."</td>";
                        echo "<td>".$v['terjual']."</td>";


                        echo "<td><a class='btn primary' href='barang_detailUI.php?id=". base64_encode($v['barang_ID']) ."'>Detail</a></td>";
                        echo "<td><a class='btn error' href='action_barang.php?command=delete&&id=". base64_encode($v['barang_ID']) ."' class='delete' data-confirm='Are you sure to delete this item?'>Delete</a></td>";
/*
echo "<td><a class='btn success' href='barang_detailUI.php?id=". base64_encode($v['barang_ID']) ."'>Detail</a> |
                        <span style='font-size:11px;'>: fitur delete dinon-aktifkan, lanjutkan pembelian</span>
                        </td>"; */


                        echo '</tr>';

                        $i++;
                    }

                    ?>
                    </tbody>
                    <tfoot>
                    <tr>
                        <td colspan="9">
                            <div class="pagingBar">
                                <div style="float:left">Total Record :<?php echo $pg->get_total_records();?></div>
                                <div style="float:right">Pages: <?php echo $pg->render_pages()?></div> <br style="clear:both" />
                            </div>
                        </td>
                    </tr>
                    </tfoot>
                </table>
                </div>


        </div>
    </div>



    <script type="text/javascript">
        var deleteLinks = document.querySelectorAll('.delete');

        for (var i = 0; i < deleteLinks.length; i++) {
            deleteLinks[i].addEventListener('click', function(event) {
                event.preventDefault();

                var choice = confirm(this.getAttribute('data-confirm'));

                if (choice) {
                    window.location.href = this.getAttribute('href');
                }
            });
        }

    </script>

<?php
include_once 'template/footer.php'; ?>
