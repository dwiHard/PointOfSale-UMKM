<?php
session_start();
$page_title = 'Tambah Penjualan Barang';
require_once 'my_func.php';
include_once 'template/header.php';
?>



<div id="content">

        <div class="section group">
            <div class="col span_2_of_1 judul-page">
                <h1><img src="img/cart_48.png" style="float: left">Transaksi Penjualan Barang
                    <a href="penjualan_addUI.php" class="btn success">Tambah transaksi</a>
                    <a href="penjualan_barangUI.php" class="btn primary">Refresh</a>

                </h1>
            </div>

        </div>

        <!-- //top-page -->

                <form method="post" action="">
                    <input type="text" name="keyword" placeholder="Pencarian No.Nota/ Tgl.penjualan (dddd-mm-yy)">
                    <input type="hidden" name="diajukan" value="1">
                    <input type="hidden" name="command" value="cari">
                    <input type="submit" value="Pencarian" style="padding: 7px">
                </form>

    <?php
    if(req_http() && $_POST['command'] == 'cari'){


        ?>
        <div style="overflow-x:auto">
        <table style="margin-top:20px">
                <thead>
                <tr>
                    <th>No</th>
                    <th>No.Nota</th>
                    <th>Tanggal</th>
                    <th>Jam</th>
                    <th style="background: #E8E881">Total Belanja</th>
                    <th>Di Proses Oleh</th>
                    <th colspan="2">Action</th>
                </tr>
                </thead>
                <tbody>

                <?php
                $hasil = nota::getInstance()->search($_POST['keyword']);
                $i=1;
                foreach ($hasil as $k => $v) {
                    echo '<tr>';
                    echo '<td>' . $i . '</td>';
                    echo "<td>" . $v['nota_ID'] . "</td>";
                    echo "<td>" . date('d/m/Y', strtotime($v['tanggal'])) . "</td>";
                    echo "<td>" . $v['jam'] . "</td>";
                    echo "<td style='background: #E8E881'>Rp. " . number_format($v['total'], 0, ',', '.') . "</td>";

                    echo "<td>" . $user->getNama($v['user_ID']) . "</td>";

                    echo "<td><a class='btn primary' href='nota_detailUI.php?id=" . base64_encode($v['nota_ID']) . "'>Detail</a></td>";
                    echo "<td><a href='action_nota.php?command=delete&&id=" . base64_encode($v['nota_ID']) . "' class='btn error' data-confirm='Are you sure to delete this item?'>Delete</a></td>";
                    echo '</tr>';

                    $i++;
                }

                ?>
                </tbody>
            </table>
            </div>
    <?php
    }else {
        ?>
        <div class="section group">
            <?php
            if (isset($_GET['msg_op']) && $_GET['msg_op'] == 1) {
                echo '<div class="msg success">Success : transaksi berhasil ditambahkan ke database !</div>';
            }
            if (isset($_GET['msg_op']) && $_GET['msg_op'] == 2) {
                echo '<div class="msg success">Success : data barang berhasil di perbarui !</div>';
            }
            if (isset($_GET['msg_op']) && $_GET['msg_op'] == 3) {
                echo '<div class="msg success">Success : 1 record transaksi berhasil di hapus !</div>';
            }
?>
            <div style="overflow-x:auto">
            <table style="margin-top:20px">
                <thead>
                <tr>
                    <th>No</th>
                    <th>No.Nota</th>
                    <th>Tanggal</th>
                    <th>Jam</th>
                    <th style="background: #E8E881">Total Belanja</th>
                    <th>Di Proses Oleh</th>
                    <th colspan="2">Action</th>
                </tr>
                </thead>
                <tbody>

                <?php
                $results_per_page = 20;
                $pg_query = "SELECT *  FROM nota";
                $pg = new Paging($pg_query, $results_per_page);
                $start = $pg->get_start();
                $query = $pg_query . "  ORDER BY nota_ID DESC LIMIT $start,$results_per_page ";
                $hasil = $nota->querySELECT($query);
                $i = $start + 1;
                foreach ($hasil as $k => $v) {
                    echo '<tr>';
                    echo '<td>' . $i . '</td>';
                    echo "<td>" . $v['nota_ID'] . "</td>";
                    echo "<td>" . date('d/m/Y', strtotime($v['tanggal'])) . "</td>";
                    echo "<td>" . $v['jam'] . "</td>";
                    echo "<td style='background: #E8E881'>Rp. " . number_format($v['total'], 0, ',', '.') . "</td>";

                    echo "<td>" . $user->getNama($v['user_ID']) . "</td>";

                    echo "<td><a class='btn primary' href='nota_detailUI.php?id=" . base64_encode($v['nota_ID']) . "'>Detail</a></td>";
                    echo "<td><a href='action_nota.php?command=delete&&id=" . base64_encode($v['nota_ID']) . "' class='btn error' data-confirm='Are you sure to delete this item?'>Delete</a></td>";
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
                            <div style="float:right">Pages: <?php echo $pg->render_pages()?></div>
                            <br style="clear:both"/>
                        </div>
                    </td>
                </tr>
                </tfoot>
            </table>
            </div>

        </div>

    <?php
    }
    ?>
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



