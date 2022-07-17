<?php
session_start();
$page_title = 'Tambah Supplier';
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
                <form method="post" action="action_supplier.php" accept-charset="utf-8">
                    <fieldset>
                        <legend>Tambah Supplier</legend>
                        <div>
                            <label for="nama">Nama:</label>
                            <input name="nama" id="nama" type="text" required="on" />
                        </div>

                        <div>
                            <label for="alamat">Alamat:</label>
                            <input name="alamat" id="alamat" type="text" required="on" />
                        </div>

                        <div>
                            <label for="alamat">no_hp:</label>
                            <input name="no_telpon" id="no_telpon" type="text" required="on" />
                        </div>

                        <input type="hidden" name="command" value="add">
                        <input type="hidden" name="diajukan" value="1">
                        <input type="submit" value="Simpan">
                        <button onclick="">Batal</button>
                    </fieldset>
                </form>
            </div>
        </div>
    </div>

<?php
include_once 'template/footer.php'; ?>