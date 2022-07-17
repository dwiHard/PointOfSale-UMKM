<?php
session_start();
$page_title = 'Supplier';
require_once 'my_func.php';
include_once 'template/header.php';
?>


    <div id="content">
        <div class="section group">
            <div class="col span_3_of_6 judul-page">
            <h1># Master Supplier <a href="supplier_add.php" class="btn success">Tambah</a><a href="menuUI.php" class="btn warning" style="margin-left:12px">Kembali ke menu</a></h1>

            </div>
            <div class="col span_3_of_6">
                <form method="get" action="supplier_pencarian.php" accept-charset="utf-8">
                    <div style="display: inline; margin-top: 10px">
                        <input type="text" name="keyword" placeholder="Cari Supplier" style="padding: 6px;">
                    </div>
                    <input type="hidden" name="diajukan" value="1">
                    <input type="submit" value="Pencarian" style="padding:9px">
                </form>
            </div>
        </div>
        <!-- //top-page -->

        <div class="section group">

            <?php
            if(isset($_GET['msg_op']) && $_GET['msg_op'] == 1){
                echo '<div class="msg success">Success :  berhasil ditambahkan ke database !</div>';
            }
            if(isset($_GET['msg_op']) && $_GET['msg_op'] == 2){
                echo '<div class="msg success">Success :  barang berhasil di perbarui !</div>';
            }
            if(isset($_GET['msg_op']) && $_GET['msg_op'] == 3){
                echo '<div class="msg success">Success : 1 record  berhasil di hapus !</div>';
            }
             if(isset($_GET['msg_op']) && $_GET['msg_op'] == 4){
                echo '<div class="msg error">error : gagal di hapus, masih terkait dengan bebrapa transaksi !</div>';
            }
            ?>
            <div style="overflow-x:auto">
            <table style="font-size: 15px;">
                <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Supplier</th>
                    <th>Alamat</th>
                    <th>No. Telpon</th>
                    <th colspan="2">Action </th>
                </tr>
                </thead>
                <tbody>

                <?php
                $results_per_page=20;
                $pg_query="SELECT * FROM ". supplier::$_table;
                $pg=new Paging($pg_query,$results_per_page);
                $start=$pg->get_start();
                $query= $pg_query." ORDER BY supplier_ID DESC LIMIT $start,$results_per_page ";
                $hasil = $barang->querySELECT($query);
                $i = $start + 1;
                foreach($hasil as $k => $v){
                    echo '<tr>';
                    echo '<td>'.$i.'</td>';
                    echo "<td>".$v['nama']."</td>";
                    echo "<td>".$v['alamat']."</td>";
                    echo "<td>".$v['no_telpon']."</td>";
                    echo "<td><a href='supplier_detail.php?id=". base64_encode($v['supplier_ID']) ."' class='btn primary'>Edit</a></td>";
                    echo "<td><a href='action_supplier.php?command=delete&&id=". base64_encode($v['supplier_ID']) ."' class='delete error' data-confirm='Are you sure to delete this item?'>Delete</a></td>";
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
