<?php
session_start();
$page_title = 'Detail transaksi pembelian Barang';
require_once 'my_func.php';
require_once 'function_cart.php';
include_once 'template/header.php';
?>



<div id="content">

    <div class="section group">
        <div class="col span_12_of_12 judul-page">
            <h1>Detail Transaksi Pembelian <span style="color:#444; font-size: 27px; "> Nota<span style="color:blue;"># <?php echo base64_decode($_GET['no']); ?></span> </span>  <button onclick="history.go(-1);"><< Back</button></h1>
        </div>
    </div>
    <!-- //top-page -->

    <?php


    $val = barang_masuk::getInstance()->show(base64_decode($_GET['no']));
    if(empty($val) || count($val) == 0){
        die("data barang pembelian dengan no nota yang anda maksud tidak di temukan !");
    }


    ?>

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


        <table style="background: #fff; font-size: 15px; border:none;">
            <tr>
                <td>No Nota</td>
                <td><?php echo $val['no_nota'] ?></td>
            </tr>

            <tr>
                <td>Nama Supplier </td>
                <td><?php echo supplier::getInstance()->getCol($val['supplier_ID'],'nama') ?></td>
            </tr>

            <tr>
                <td>Tanggal Masuk </td>
                <td><?php echo date("d-m-Y", strtotime($val['tgl_masuk'])); ?></td>
            </tr>
            <tr>
                <td>ket </td>
                <td><?php echo nl2br($val['ket']); ?></td>
            </tr>
        </table><br>
        <table style="font-size: 15px; ">
            <thead>
            <tr>
                <th>No</th>
                <th>Nama Barang</th>
                <th style="background: #EBFCE5">Harga Beli</th>
                <th>Harga Jual</th>
                <th style="background: #EBFCE5">Jumlah</th>
                <th style="background: #EBFCE5">Sub Total</th>
            <th>action</th>
            </tr>
            </thead>
            <tbody>

            <?php
            $barang_masuk_detail = barang_masuk_detail::getInstance()->show(base64_decode($_GET['no']));
            $total = 0;
            $i = 1;
            foreach($barang_masuk_detail as $k => $v){
                $total += $v['harga_beli'] * $v['jumlah'];
                echo '<tr>';
                echo '<td>'.$i.'</td>';
                echo '<td>'. get_product_name( $v['barang_ID'] ).'</td>';
                echo "<td style='background: #EBFCE5'>Rp. ".number_format ( $v['harga_beli'], 0, ',', '.')."</td>";
                echo "<td>Rp. ".number_format ( $v['harga_jual'], 0, ',', '.')."</td>";
                echo '<td style="background: #EBFCE5">'. $v['jumlah'].' item</td>';
                echo "<td style='background: #EBFCE5'>Rp. ".number_format ($v['harga_beli'] * $v['jumlah'], 0, ',', '.')."</td>";
                echo "<td><a style='color:red;' href=action_transaksi.php?command=delete_item_transaksi&&barang_id=".  base64_encode( $v['barang_ID'] ) ."&&no_nota=". base64_encode($val['no_nota']) .">(x) Delete</a></td>";

                echo '</tr>';
                $i++;
            }
            ?>
            </tbody>
            <tfoot>
            <tr>
                <td colspan="5" style="text-align: right;">
                    <strong>Total Pembelian :</strong>
                </td>
                <td style="background: #EBFCE5">
                    Rp. <?php echo number_format ($total, 0, ',', '.'); ?>
                </td>


            </tr>
            </tfoot>

        </table>


    </div>



</div>

<?php
include_once 'template/footer.php'; ?>



