<?php
session_start();
$page_title = 'Lokasi';
require_once 'my_func.php';
include_once 'template/header.php';
?>


    <div id="content">
        <div class="section group">
            <div class="col span_3_of_6 judul-page">
                <h1># Master Lokasi <a href="lokasi_add.php" class="btn success">Tambah</a></h1>

            </div>
            
        </div>
        <!-- //top-page -->

        <div class="section group">

            <?php
            if(isset($_GET['msg_op']) && $_GET['msg_op'] == 1){
                echo '<div class="msg success">Success : lokasi berhasil ditambahkan ke database !</div>';
            }
            if(isset($_GET['msg_op']) && $_GET['msg_op'] == 2){
                echo '<div class="msg success">Success : data lokasi berhasil di perbarui !</div>';
            }
            if(isset($_GET['msg_op']) && $_GET['msg_op'] == 3){
                echo '<div class="msg success">Success : 1 record lokasi berhasil di hapus !</div>';
            }

            if(isset($_GET['msg_op']) && $_GET['msg_op'] == 4){
                echo '<div class="msg error">maaf, ada beberapa data masih berkaitan dengan lokasi ini !</div>';
            }
            ?>
            <div style="overflow-x:auto">
            <table style="font-size: 15px;">
                <thead>
                <tr>
                    <th>No</th>
                    <th>Lokasi Barang</th>
                    <th>Aktif</th>
                    <th colspan="2">Action </th>
                </tr>
                </thead>
                <tbody>

                <?php
                $results_per_page=20;
                $pg_query="SELECT * FROM ". lokasi::$_table;
                $pg=new Paging($pg_query,$results_per_page);
                $start=$pg->get_start();
                $query= $pg_query." ORDER BY lokasi_id DESC LIMIT $start,$results_per_page ";
                $hasil = $barang->querySELECT($query);
                $i = $start + 1;
                foreach($hasil as $k => $v){
                    if($v['aktif']){
                        $a='ya';
                    }else{
                        $a='tidak';
                    }
                    echo '<tr>';
                    echo '<td>'.$i.'</td>';
                    echo "<td>".$v['nama_lokasi']."</td>";
                    echo "<td>". $a ."</td>";
                    echo "<td><a class='btn btn-primary success' href='lokasi_detail.php?id=". base64_encode($v['lokasi_id']) ."'>Detail</a></td>";
                    echo "<td><a href='action_lokasi.php?command=delete&&id=". base64_encode($v['lokasi_id']) ."' class='btn error delete' data-confirm='Are you sure to delete this item?'>Delete</a></td>";
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
