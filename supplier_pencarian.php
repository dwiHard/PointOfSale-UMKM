<?php
session_start();
$page_title = 'Supplier';
require_once 'my_func.php';
include_once 'template/header.php';
?>
    <div id="content">
        <div class="section group">
            <div class="col span_3_of_6 judul-page">
                <h1># Hasil Pencarian Supplier <a href="supplier_add.php" class="btn btn-add">Tambah</a></h1>
            </div>
            <div class="col span_3_of_6">
                <form method="get" action="supplier_pencarian.php" accept-charset="utf-8">
                    <div style="display: inline; margin-top: 10px">
                        <input type="text" name="keyword" placeholder="Cari Supplier" style="padding: 6px;">
                    </div>
                    <input type="hidden" name="diajukan" value="1">
                    <input type="submit" value="Pencarian" style="margin-top: 0">
                </form>
            </div>
        </div>
        <!-- //top-page -->

        <div class="section group">

            <table style="font-size: 15px;">
                <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Supplier</th>
                    <th>Alamat</th>
                    <th>No. Telpon</th>
                    <th>Action </th>
                </tr>
                </thead>
                <tbody>

                <?php
                $hasil = supplier::getInstance()->search($_GET['keyword']);
                $i = 1;
                foreach($hasil as $k => $v){
                    echo '<tr>';
                    echo '<td>'.$i.'</td>';
                    echo "<td>".$v['nama']."</td>";
                    echo "<td>".$v['alamat']."</td>";
                    echo "<td>".$v['no_telpon']."</td>";
                    echo "<td><a href='supplier_detail.php?id=". base64_encode($v['supplier_ID']) ."'>Detail</a> |
                        <a href='action_supplier.php?command=delete&&id=". base64_encode($v['supplier_ID']) ."' class='delete' data-confirm='Are you sure to delete this item?'>Delete</a>
                        </td>";
                    echo '</tr>';

                    $i++;
                }

                ?>
                </tbody>
                <tfoot>
                <tr>
                    <td colspan="6">total : <?php echo count($hasil); ?> record</td>
                </tr>
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