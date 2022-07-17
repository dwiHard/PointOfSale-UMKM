<?php
session_start();
$page_title = 'daftar transaksi pembelian Barang';
require_once 'my_func.php';
include_once 'template/header.php';
?>

<div id="content">

    <div class="section group">
        <div class="col span_2_of_1 judul-page">
            <h1>Hasil Pencarian Transaksi Pembelian Barang Pada Supplier</h1>
        </div>
    </div>
    <div class="section group">
        <?php
        if(isset($_GET['msg_op']) && $_GET['msg_op'] == 1){
            echo '<div class="msg success">Success : transaksi berhasil ditambahkan ke database !</div>';
        }
        if(isset($_GET['msg_op']) && $_GET['msg_op'] == 2){
            echo '<div class="msg success">Success : data barang berhasil di perbarui !</div>';
        }
        if(isset($_GET['msg_op']) && $_GET['msg_op'] == 3){
            echo '<div class="msg success">Success : 1 item transaksi pembelian berhasil di hapus !</div>';
        }
        ?>
        <form id="cari" method="post" action="hasil_cari_transaksi_pembelian.php">
            <input type="text" name="keyword" placeholder="cari no nota" >
            <input type="submit" value="Pencarian ">
            <a href="daftar_transaksi_pembelian.php" class="btn-add">Back</a>
        </form>
        <table style="font-size: 14px;">
            <thead>
            <tr>
                <th>No</th>
                <th>No.Nota</th>
                <th>Supplier</th>
                <th>Tanggal</th>
                <th>Total Pembelian</th>
                <th>Ket</th>
                <th>Di Entry Oleh</th>
                <th>Action </th>
            </tr>
            </thead>
            <tbody>

            <?php
            $hasil = barang_masuk::getInstance()->search($_POST['keyword']);
            $i = 1;
            foreach($hasil as $k => $v){
                echo '<tr>';
                echo '<td>'.$i.'</td>';
                echo "<td>".$v['no_nota']."</td>";
                echo "<td>".$v['nama_supplier']."</td>";

                echo "<td>". date('d-m-Y', strtotime( $v['tgl_masuk'] ))."</td>";

                echo "<td>Rp. ".number_format ($v['total'], 0, ',', '.')."</td>";
                echo "<td>".$v['ket']."</td>";
                echo "<td>".$user->getNama($v['user_ID'])."</td>";


                echo "<td><a class='btn-print' href='daftar_transaksi_pembelian_detail.php?no=". base64_encode($v['no_nota']) ."'>Detail</a>
                        <a class='btn-delete' href='action_transaksi.php?command=delete_pembelian&&no=". base64_encode($v['no_nota']) ."' class='delete' data-confirm='Are you sure to delete this item?'>Delete</a>
                        </td>";
                echo '</tr>';

                $i++;
            }

            ?>
            </tbody>
            <tfoot>
            </tfoot>
        </table>


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



