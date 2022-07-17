<?php
/**
 * barang masuk / pembelian barang pada supplier
 */
session_start();
$page_title = 'form transaksi pembelian';
$script = array('jquery.maskMoney.min.js','jquery.datetimepicker.full.min.js','choose_brg.js');
require_once 'function_barang_masuk.php';
require_once 'function_cart.php';
require_once 'my_func.php';
include_once 'template/header.php';
?>
    <script>
        $(function () {
            $('#harga').maskMoney({prefix:'', thousands:'.', decimal:',', precision:0});
        });
    </script>

    <script type="text/javascript">
        function clear_cart(){
            if(confirm('semua transaksi pembalian Akan di kosongkan,Apakah Anda Yakin untuk melanjutkan ?')){
                document.form1.command.value='clear';
                document.form1.submit();
            }
        }
    </script>
<?php

if(isset($_REQUEST['command'])){
    if($_REQUEST['command']=='clear'){
        unset($_SESSION['beli']);
    }
}
?>
<?php $db_connect= new db_connect();

$q = 'select max(no_nota) as kodeTerbesar from barang_masuk ';
$db = $db_connect->getConn();
$st = $db->query($q);
$kode = $st->fetchColumn();
$urutan = (int) substr($kode, 3, 3);
$urutan++;
$huruf = "BRG";
$kodeBarang = $huruf . sprintf("%03s", $urutan);
?>
    <div id="content">
        <div class="section group">
            <div class="col span_12_of_12">
                <?php
                if(isset($_GET['msg_op']) && $_GET['msg_op'] == 1){
                    echo '<div class="msg success">Success : barang berhasil ditambahkan ke database !</div>';
                }

                if(isset($_GET['add']) && $_GET['add'] == 1){
                    echo '<div class="msg success">Success : transaksi pembelian barang masuk berhasi di simpan di database !</div>';
                }
                ?>
                <a href="daftar_transaksi_pembelian.php" class="btn-print"><< Back</a>
                <fieldset>
                    <legend>Transaksi Pembelian Pada Supplier
                        <span style="">form ini digunakan untuk input barang masuk, & otomatis akan menambah jumlah stok barang</span></legend>
                    <br>
                    <?php
                    echo "<button class=button type=button
              onclick='Choose_brg(\"barang_id\");' style='border:solid 1px #B9EA75; padding:4px; color:#fff; background:blue; padding:10px; border:none;'>
              Pilih barang...</button>";
                    echo '<br><hr>Setelah pilih barang, refresh web browser!';

                    ?>
                    <?php
                    if(isset($_SESSION['beli']) && is_array($_SESSION['beli']) && count($_SESSION['beli']) > 0){
                    ?>
                    <table id="table-1" style="font-size: 15px">
                        <tr>
                            <th>Nama</th>
                            <th>Jumlah</th>
                            <th>Harga Beli</th>
                            <th>Harga Jual</th>
                            <th>Subtotal</th>
                        </tr>
                        <?php
                        $max = count($_SESSION['beli']);
                        $total = 0;
                        $i = 0;
                        while($i < $max){
                        $pid = $_SESSION['beli'][$i]['productid'];
                        $q = $_SESSION['beli'][$i]['qty'];
                        $harga_beli = $_SESSION['beli'][$i]['harga_beli'];
                        $harga_jual = $_SESSION['beli'][$i]['harga_jual'];
                        $total += $harga_beli;
                        ?>
                        <tr>
                            <td>
                                <?php echo get_product_name($pid); ?>
                            </td>
                            <td style="background: #DDEAC1"><?php echo $q; ?></td>
                            <td style="background: #DDEAC1"><?php echo number_format($harga_beli, 0, ',', '.'); ?></td>
                            <td><?php echo number_format($harga_jual, 0, ',', '.'); ?></td>

                            <td style="background: #DDEAC1"><?php echo number_format($harga_beli * $q, 0, ',', '.'); ?></td>

                            <?php
                            $i++;
                            }

                            echo '
    <tr>
    <td style="text-align:right;font-weight:bold; color:blue;" colspan=4>Total Pembelian Barang Masuk :</td>
    <td>'. number_format(get_total_beli(), 0, ',', '.') .'</td>
    </tr>
    </table>';
                            } ?>
                </fieldset>

                <form name="form1" method="post" onsubmit="return on_submit(this)">
                    <input type="hidden" name="pid" />
                    <input type="hidden" name="command" />
                 </form>
                <form method="post" action="action_transaksi.php" accept-charset="utf-8">



                    <fieldset>


                        <div style="float: left; margin-right: 8px;">
                            <label for="no_nota">No Nota:</label>
                            <input name="no_nota" id="no_nota" type="text" required="on" value="<?php echo $kodeBarang ?>" />
                        </div>

                        <div style="float: left; width: 200px; margin-right: 8px !important; ">
                            <label for="tgl_masuk">Tgl Barang Masuk :</label>
                            <input name="tgl_brg_masuk" id="tgl_brg_masuk" type="text"  />
                        </div>

                        <div style="clear: both;">
                            <label for="suplier">Supplier:</label>
                            <select name="supplier_ID">
            <?php foreach($supplier->getAll() as $k=> $v){
                echo '<option value="'. $v['supplier_ID'] .'">'. $v['nama'] .'</option>';
            } ?>
                            </select>
                        </div>
                        <div>
                            <label for="ket">Ket :</label>
                            <textarea cols="100" rows="4" name="ket"></textarea>
                        </div>
                        <br>
                        <input type="hidden" name="command" value="add_barang_masuk">
                        <input type="hidden" name="diajukan" value="1">
                        <input type="submit" value="Simpan">


                        <input type="button" value="hapus semua barang" onclick="clear_cart()">
                    </fieldset>

                </form>




            </div>



        </div>
    </div>

<?php
include_once 'template/footer.php'; ?>
