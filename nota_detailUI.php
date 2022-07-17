<?php
session_start();
$page_title = 'Detail Barang Belanja';
require_once 'my_func.php';
require_once 'function_cart.php';
include_once 'template/header.php';
?>



<div id="content">

    <div class="section group">
        <div class="col span_1_of_2 judul-page">
            <h1>Transaksi <span style="color:#444; font-size: 27px; ">Penjualan ID # <?php echo base64_decode($_GET['id']); ?></span>  <button onclick="history.go(-1);"><< Back</button></h1>

        </div>

    </div>
    <!-- //top-page -->


    <div class="section group">
        <?php
        if(isset($_GET['msg_op']) && $_GET['msg_op'] == 1){
            echo '<div class="msg success">Success : transaksi berhasil ditambahkan ke database !</div>';
        }
        if(isset($_GET['msg_op']) && $_GET['msg_op'] == 2){
            echo '<div class="msg success">Success : data barang berhasil di perbarui !</div>';
        }
        if(isset($_GET['msg_op']) && $_GET['msg_op'] == 3){
            echo '<div class="msg success">Success : 1 record barang berhasil di hapus !</div>';
        }
        ?>
        <table>
            <thead>
            <tr>
                <th>No</th>
                <th>Nama Barang</th>
                <th>Harga Jual</th>
                <th>Jumlah yang di beli</th>
                <th>Sub Total</th>
            </tr>
            </thead>
            <tbody>

            <?php
            $transaksi = $transaksi_barang->show(base64_decode($_GET['id']));

            $total = 0;
            $i = 1;
            foreach($transaksi as $k => $v){
                $total += $v['harga_jual'] * $v['qty'];
                echo '<tr>';
                echo '<td>'.$i.'</td>';
                echo '<td>'. get_product_name( $v['barang_ID'] ).'</td>';
                echo "<td>Rp. ".number_format ( $v['harga_jual'] , 0, ',', '.')."</td>";
                echo '<td>'. $v['qty'].' item</td>';
                echo "<td>Rp. ".number_format ($v['harga_jual'] * $v['qty'], 0, ',', '.')."</td>";
                echo '</tr>';
                $i++;
            }

            ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="4" style="text-align: right">
                        <strong>Total Bayar :</strong>
                    </td>
                    <td>
                        Rp. <?php echo number_format ($total, 0, ',', '.'); ?>
                    </td>


                </tr>
            </tfoot>

        </table>


    </div>



</div>

<?php
include_once 'template/footer.php'; ?>



