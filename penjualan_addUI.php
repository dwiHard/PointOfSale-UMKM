<?php
session_start();
$page_title = 'Tambah Penjualan Barang';
$script = array(
  'jquery.maskMoney.min.js'
);
require_once 'my_func.php';
require_once 'function_cart.php';
include_once 'template/header.php';

if(isset($_REQUEST['command'])){

    if($_REQUEST['command']=='delete' && $_REQUEST['pid']>0){
        remove_product($_REQUEST['pid']);
    }

    else if($_REQUEST['command']=='add_transaksi'){
        if(!isset($_SESSION['cart'])){
            header("Location:penjualan_addUI.php?msg_op=2");
            exit;
        }else{
            $nota->store($_POST);
            $noda_id = $nota->getLastInsert();
            //add trans
            $max=count($_SESSION['cart']);
            for($i=0;$i<$max;$i++){
                $pid=$_SESSION['cart'][$i]['productid'];
                $q=$_SESSION['cart'][$i]['qty'];
                $price=get_price($pid);
                $harga_beli=get_price_beli($pid);

                $transaksi_barang->store($noda_id, $pid, $q, $price, $harga_beli);
                $barang->edit_data_barang($pid, $q);
                header("Location:penjualan_barangUI.php?msg_op=1");
            }
        }

    }

    else if($_REQUEST['command']=='clear'){
        unset($_SESSION['cart']);
    }
    else if($_REQUEST['command']=='update' && isset($_SESSION['cart'])){
        $max=count($_SESSION['cart']);
        for($i=0;$i<$max;$i++){
            $pid=$_SESSION['cart'][$i]['productid'];
            $q=intval($_REQUEST['product'.$pid]);
            if($q>0 && $q<=999){
                if(! check_stok($pid, $q)){
                    $_SESSION['cart'][$i]['qty']=$q;
                }else{
                    $_SESSION['info'] = 'stok barang tidak cukup untuk di order ';
                }
            }
            else{
                $_SESSION['info'] = 'produk tidak bisa di update!, masukkan nilai numerik';
            }
        }
    }



}

?>


<script language="javascript">
    function del(pid){
        if(confirm('Apakah Anda ingin meng-hapus item ini ?')){
            document.form1.pid.value=pid;
            document.form1.command.value='delete';
            document.form1.submit();
        }
    }

    function clear_cart(){
        if(confirm('Keranjang Belanja Anda Akan di kosongkan,Apakah Anda Yakin untuk melanjutkan ?')){
            document.form1.command.value='clear';
            document.form1.submit();
        }
    }


    function update_cart(){
        document.form1.command.value='update';
        document.form1.submit();
    }

    function on_submit(){
        document.form1.command.value='add_transaksi';
        document.form1.submit();
    }

</script>


<div id="content" style="margin-top: 0">

    <?php
    if(isset($_GET['msg_op']) && $_GET['msg_op'] == 2){
        echo '<div class="msg error">Error : keranjang masih kosong, silahkan tambahan barang terlebih dahulu !</div>';
    }
    ?>
    <div class="section group" style="margin-top:20px">

        <?php
        if(isset($_SESSION['info'])){
            echo '<div class="error">'. $_SESSION['info']  .'</div><br>';
            unset($_SESSION['info']);
        }?>
                    <div class="col span_10_of_12" style="margin-top: 0;overflow-x:auto">
                        <a href="penjualan_barangUI.php">Kembali</a>
                        <h1 style="padding-top: 10px; font-weight: normal">Tambah Transaksi</h1>


                        <form method="post" action="action_transaksi.php" accept-charset="utf-8" id="fmtransaksi">
                            <fieldset style="padding:0 10px; background: #fafafa; padding:10px;">
                                <div>
                                    <label for="kd_barang" style="font-size:18px;">Scan Barcode Pada Barang ( atau input barcode , lalu tekan enter):</label>
                                    <input type="text" name="barcode" id="barcode" autocomplete="off">
                                    <input type="hidden" name="jumlah" value="1">
                                    <input type="hidden" name="command" value="add_to_cart">
                                    <input type="button" class="btn primary" value="Update Cart" onclick="update_cart()" style="margin-top: -10px;">
                                    <input type="button" class="btn error" value="Clear" style="margin-top: -10px" onclick="clear_cart()">
                                </div>

                            </fieldset>

                        </form>

                        <?php
                        if(isset($_GET['msg_op']) && $_GET['msg_op'] == 1){
                            echo '<div class="msg success">Success : barang berhasil ditambahkan ke database !</div>';
                        }
                        ?>



                        <form name="form1" method="post" onsubmit="return on_submit(this)">
                            <input type="hidden" name="pid" />
                            <input type="hidden" name="command" />
                        <table border="0" cellpadding="5px" cellspacing="1px" style="font-size:13px; background: #fff;" width="100%">
                            <tr>
                                <th>Nama</th>
                                <th>Harga</th>
                                <th>Jumlah</th>
                                <th>Subtotal</th>
                            </tr>

                            <?php
                            if( isset($_SESSION['cart']) && is_array($_SESSION['cart']) && count($_SESSION['cart']) > 0) {

                                $max = count($_SESSION['cart']);
                                $i = 0;
                                $total = 0;
                                while ($i < $max) {
                                    $pid = $_SESSION['cart'][$i]['productid'];
                                    $q = $_SESSION['cart'][$i]['qty'];
                                    if ($q == 0) continue;
                                    $total += get_price($pid);
                                    ?>

                                    <tr>
                                        <td><?php echo get_product_name($pid); ?>
                                        <a href="javascript:del(<?= $pid ?>)" style="color: #E8442F; font-weight:bold;">(x Delete )</a>
                                        </td>
                                        <td><?php echo number_format(get_price($pid), 0, ',', '.'); ?></td>

                                        <td>
                                            <input type="text" name="product<?=$pid?>" value="<?=$q?>" maxlength="3" size="2" style="width: 40px; padding: 0; margin: 0;" /></td>


                                        <td>Rp. <?php echo number_format($q * get_price($pid), 0, ',', '.'); ?></td>



                                    </tr>

                                    <?php
                                    $i++;
                                }
                            }else{
                                echo '<tr><td colspan=5>Silahkan pilih barang yang ingin di jual....</td></td>';
                            }
                            if(isset($_SESSION['cart'])){ ?>

                                <tr style="background: #F0EB8C">
                                    <td colspan="3" style="text-align: right"><strong>Grand Total Belanja (Rp.) :</strong></td>
                                    <td colspan="2">Rp. <span id="grand_total"><?php echo number_format (get_order_total(), 0, ',', '.'); ?></span></td>
                                </tr>


                             <tr>
                                <td colspan="3" style="text-align: right"><strong>Uang Bayar (Rp.) :</strong></td>

                                <td><input type="text" name="uang_bayar" id="uang_bayar" style="width: 100%; font-size: 16px; padding: 2px; margin: 2px 0; border: solid 1px #D76636;" autocomplete="off"></td>

                             </tr>

                                <tr>
                                    <td colspan="3" style="text-align: right"><strong>Uang Kembalian (Rp.) :</strong></td>
                                    <td>
                                        <input type="text" name="uang_kembali" id="uang_kembali" style="width: 100%; font-size: 20px; color:darkblue; background: #D6FFD0; padding: 2px; margin: 2px 0; border: solid 1px #D76636;" readonly="true"></td>

                                    </td>


                                </tr>


                            <?php }
                            ?>

                        </table>
                            <br>
                            <input type="hidden" name="total_belanja" value="<?php echo get_order_total(); ?>">
                            <input type="submit" value="Simpan transaksi" style="padding:4px 0;margin: 0; width: 150px;">
                        </form>
                    </div>


    </div>

<script>

    function ChoosePemilik() {
        window.open("panel_barang.php?choose=yes", "_blank",
            "height=600, width=800, top=100, left=100, tab=no, " +
            "location=no, menubar=no, status=no, toolbar=no", false);
    }


</script>
<?php
include_once 'template/footer.php'; ?>



