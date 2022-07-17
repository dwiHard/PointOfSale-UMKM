<?php
session_start();
$page_title = 'Detail User';
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
                $uid = base64_decode($_GET['uid']);


                $data = $user->show($uid);

                if(empty($data)){
                   die('data user tidak di temukan di database !');
                }
                ?>
                <form method="post" action="action_user.php" accept-charset="utf-8">
                    <fieldset>
                        <legend>Detail User</legend>
                        <div>
                            <label for="nama">Nama Lengkap:</label>
                            <input name="nama" id="nama" type="text" required="on" value="<?php echo $data['nama']; ?>" />
                        </div>

                        <div>
                            <label for="email">Email:</label>
                            <input name="email" id="email" type="email" required="on" value="<?php echo $data['email']; ?>" />
                        </div>


                        <div>
                            <label for="peran">Peran Pengguna :</label>
                            <input name="peran" id="peran" type="radio" value="1,2" checked/> Kelola Barang, Transaksi<br>
                           
                            <input name="peran" id="peran" type="radio" value="1,2,3,4"/> Full Akses<br>
                        </div>
                        <br>


                        <div>
                            <label for="username">Username : (min 6 karakter)</label>
                            <input name="username" id="username" type="text" disabled required="on" value="<?php echo $data['username']; ?>" />
                        </div>


                        <div>
                            <label for="pass">Password baru :</label>
                            <input name="pass" id="pass" type="text" required="on" />
                        </div>

                        <input type="hidden" name="command" value="edit">
                        <input type="hidden" name="diajukan" value="1">

                        <input type="hidden" name="user_ID" value="<?php echo $data['user_ID'] ?>">

                        <input type="submit" value="Simpan">
                        <button onclick="">Batal</button>
                    </fieldset>

                </form>

            </div>



        </div>
    </div>

<?php
include_once 'template/footer.php'; ?>