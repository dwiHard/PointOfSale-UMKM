<?php
session_start();
$page_title = 'daftar transaksi pembelian Barang';
require_once 'my_func.php';
include_once 'template/header.php';
?>

<div id="content">

    <div class="section group">
        <div class="col span_2_of_1 judul-page">
            <a href="transaksiUI.php">Menu Transaksi</a>
            <h1 style="margin-top:15px;margin-bottom:15px"><img src="img/product.png" style=" width:40px; float: left"> Daftar Transaksi Pembelian Barang</h1>
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
        <a href="barang_masuk.php" class="btn success" style="padding:9px;">Tambah transaksi pembelian</a>
        <form id="cari" method="post" action="hasil_cari_transaksi_pembelian.php" style="margin-top:20px">
            <input type="text" name="keyword" placeholder="cari no nota" style="padding:7px;margin-top:2px;">
            <input type="submit" value="Pencarian " style="padding:9px">
        </form>

            <div style="overflow-x:auto;">
            <table style="font-size: 14px;margin-top:20px">
            <thead>
            <tr>
                <th>No</th>
                <th>No.Nota</th>
                <th>Supplier</th>
                <th>Tanggal</th>
                <th>Total Pembelian</th>
                <th>Ket</th>
                <th>Kasir</th>
                <th colspan="2">Action </th>
            </tr>
            </thead>
            <tbody>

            <?php
            $results_per_page=20;
            $pg_query="SELECT bm.no_nota, bm.user_ID, bm.supplier_ID, bm.tgl_masuk, bm.total, bm.ket, bm.ket, s.nama as nama_supplier
        FROM barang_masuk bm LEFT JOIN supplier s using (supplier_ID)";

            $pg=new Paging($pg_query,$results_per_page);
            $start=$pg->get_start();
            $query= $pg_query."  ORDER BY bm.created_at DESC LIMIT $start,$results_per_page ";
            $hasil = $nota->querySELECT($query);

            $i = $start + 1;
            foreach($hasil as $k => $v){
                echo '<tr>';
                echo '<td>'.$i.'</td>';
                echo "<td>".$v['no_nota']."</td>";
                echo "<td>".$v['nama_supplier']."</td>";
                echo "<td>". date('d-m-Y', strtotime( $v['tgl_masuk'] ))."</td>";
                echo "<td>Rp. ".number_format ($v['total'], 0, ',', '.')."</td>";
                echo "<td>".$v['ket']."</td>";
                echo "<td>".$user->getNama($v['user_ID'])."</td>";
                echo "<td><a class='primary' href='daftar_transaksi_pembelian_detail.php?no=". base64_encode($v['no_nota']) ."'>Detail</a></td>";
                echo"<td><a href='action_transaksi.php?command=delete_pembelian&&no=". base64_encode($v['no_nota']) ."' class='error' data-confirm='Are you sure to delete this item?'>Delete</a></td>";
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



