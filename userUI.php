<?php
session_start();
$page_title = 'User';
require_once 'my_func.php';
include_once 'template/header.php';

?>
    <script>
        $(function () {
            $('#harga_beli,#harga_jual ').maskMoney({prefix:'', thousands:'.', decimal:',', precision:0});
        });
    </script>

    <div id="content">
        <div class="section group" style="margin-top:20px">
            <a href="menuUI.php">Kembali</a>
            <div class="col span_2_of_2">
                <h1 ># User <a href="user_addUI.php" class="btn success">Tambah</a>
                    <?php


                    echo "<a class='btn primary' href='user_detailUI.php?uid=". base64_encode($_SESSION['__userID']) ."&my=1'>change mypass</a>
                        "; ?></h1><br>

                <?php
                if(isset($_GET['msg_op']) && $_GET['msg_op'] == 1){
                    echo '<div class="msg success">Success : berhasil ditambahkan ke database !</div>';
                }
                if(isset($_GET['msg_op']) && $_GET['msg_op'] == 2){
                    echo '<div class="msg success">Success : berhasil di perbarui !</div>';
                }
                if(isset($_GET['msg_op']) && $_GET['msg_op'] == 3){
                    echo '<div class="msg success">Success : 1 record berhasil di hapus !</div>';
                }
                ?>
                <div style="overflow-x:auto">
                <table>
                    <thead>
                    <tr>
                        <th>No</th>
                        <th>Username</th>
                        <th>Nama Lengkap</th>
                        <th>Email</th>
                        <th>Level</th>
                        <th>Created At</th>
                        <th colspan="2">Action </th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $hasil = $user->getAll();
                    $i = 1;

                    foreach($hasil as $k => $v){
                        
                        echo '<tr>';
                        echo '<td>'.$i.'</td>';
                        echo "<td>".$v['username']."</td>";
                        echo "<td>".$v['nama']."</td>";
                        echo "<td>".$v['email']."</td>";
                        echo "<td>".$v['level']."</td>";
                        echo "<td>". date("d-m-Y", strtotime($v['created_at'])) ."</td>";
                        echo "<td><a href='user_detailUI.php?uid=". base64_encode($v['user_ID']) ."' class='btn primary'>Edit</a></td>";
                        echo "<td><a href='action_user.php?command=delete&&uid=". base64_encode($v['user_ID']) ."' class='btn error' data-confirm='Are you sure to delete this item?'>Delete</a></td>";
                        echo '</tr>';

                        $i++;
                    }

                    ?>
                    </tbody>
                </table>
                </div>
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
