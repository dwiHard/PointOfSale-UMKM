<?php
session_start();
$page_title = 'Cari Barang';
$script = array('jquery.maskMoney.min.js');
require_once 'my_func.php';
include_once 'template/header.php';

if(req_http() && !empty($_POST['keyword'])){
    $cari =  htmlspecialchars( $_POST['keyword'] );
    $hasil = $barang->search($cari);
}else{
    die('pencarian tidak dapat di proses !');
}

?>
    <script>
        $(function () {
            $('#harga_beli,#harga_jual ').maskMoney({prefix:'', thousands:'.', decimal:',', precision:0});
        });
    </script>


    <div id="content">
        <div class="section group">
            <div class="col span_3_of_6">
                <h3 class="page-title"># Hasil Pencarian Barang <span class="badge"><?php echo count($hasil) ?></span> Record</h3>
                <a href="barangUI.php" class="btn-print">back</a>

            </div>
            <div class="col span_3_of_6">
                <form method="post">
                    <div style="display: inline; "><input type="text" name="keyword" placeholder="Cari kode/nama barang">
                    </div>

                    <input type="hidden" name="diajukan" value="1">
                    <input type="submit" value="Pencarian" style="padding:7px">
                </form>
            </div>
        </div>
        <!-- //top-page -->

        <div class="section group">
            <div class="col span_2_of_2">

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
                ?>
                <table style="font-size: 14px;">
                    <thead>
                    <tr>
                        <th>No</th>
                        <th>Barcode</th>
                        <th>Nama</th>
                        <th>Lokasi</th>
                        <th>Harga Beli</th>
                        <th>Harga Jual</th>
                        <th>Stok</th>
                        <th>terjual</th>

                        <th>Action </th>
                    </tr>
                    </thead>
                    <tbody>

                    <?php
                    $i = 1;
                    foreach($hasil as $k => $v){
                        echo '<tr>';
                        echo '<td>'.$i.'</td>';
                        echo "<td>".$v['kode_barang']."</td>";
                        echo "<td>".$v['nama']."</td>";
                        echo "<td>". Lokasi::getInstance()->show($v['lokasi_id']) ['nama_lokasi'] ."</td>";
                        echo "<td>".$v['harga_beli']."</td>";
                        echo "<td>".$v['harga_jual']."</td>";
                        echo "<td>".$v['stok']."</td>";
                        echo "<td>".$v['terjual']."</td>";


                        echo "<td><a href='barang_detailUI.php?id=". base64_encode($v['barang_ID']) ."' class='btn primary'>Detail</a> |
                        <a href='action_barang.php?command=delete&&id=". base64_encode($v['barang_ID']) ."' class='btn error' data-confirm='Are you sure to delete this item?'>Delete</a>
                        </td>";
                        echo '</tr>';

                        $i++;
                    }

                    ?>
                    </tbody>
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
