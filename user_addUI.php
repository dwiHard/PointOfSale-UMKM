<?php
session_start();
$page_title = 'Tambah User';
require_once 'my_func.php';
include_once 'template/header.php';
?>

    <div id="content">
        <div class="section group">
            <div class="col span_1_of_2">
                <?php
                if(isset($_GET['msg_op']) && $_GET['msg_op'] == 1){
                    echo '<div class="msg success">Success : barang berhasil ditambahkan ke database !</div>';
                }
                ?>
                <form method="post" action="action_user.php" accept-charset="utf-8">
                    <fieldset>
                        <legend>Tambah User</legend>
                        <div>
                            <label for="nama">Nama Lengkap:</label>
                            <input name="nama" id="nama" type="text" required="on" />
                        </div>

                        <div>
                            <label for="email">Email:</label>
                            <input name="email" id="email" type="email" required="on" />
                        </div>


                        <div>
                            <label for="peran">Peran Pengguna :</label>
                            <input name="peran" id="peran" type="radio" value="1,2" checked/> Kelola Barang, Transaksi<br>
                           
                            <input name="peran" id="peran" type="radio" value="1,2,3,4"/> Full Akses<br>

                        </div>
                        <br>


                        <div>
                            <label for="username">Username : (min 6 karakter)</label>
                            <input name="username" id="username" type="text" required="on" />
                        </div>

                        <div>
                            <label for="pass">Password : (min 6 karakter)</label>
                            <input name="pass" id="pass" type="text" required="on" />
                        </div>

                        <input type="hidden" name="command" value="add">
                        <input type="hidden" name="diajukan" value="1">
                        <input type="submit" style="padding:8px" value="Simpan">
                        <button onclick="" class="btn error">Batal</button>
                    </fieldset>

                </form>

            </div>



        </div>
    </div>

<?php
include_once 'template/footer.php'; ?>
