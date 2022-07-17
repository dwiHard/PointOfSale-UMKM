<?php
session_start();
$page_title = 'Barang';
$script = array('jquery.maskMoney.min.js');
require_once 'my_func.php';
include_once 'template/header.php';
?>
    <script>
        $(function () {
            $('#harga_beli,#harga_jual ').maskMoney({prefix:'', thousands:'.', decimal:',', precision:0});
        });
    </script>

    <div id="content">
        <div class="section group">
            <div class="col span_1_of_2">
                <?php
                if(isset($_GET['msg_op']) && $_GET['msg_op'] == 1){
                    echo '<div class="msg success">Success : barang berhasil ditambahkan ke database !</div>';
                }
                ?>
                <form method="post" action="action_barang.php" accept-charset="utf-8">
                    <fieldset>
                        <legend>Tambah Barang</legend>
                        <div>
                            <label for="kd_barang">Kode Barang (nomor harus 13 digit):</label>
                            <input name="kd_barang" id="kd_barang" type="text" maxlength="13" required="on" />
                        </div>
                        <div>
                            <label for="nm_barang">Nama Barang:</label>
                            <input name="nm_barang" id="nm_barang" type="text" required="on" />
                        </div>
                        <div>
                            <label for="harga_beli" style="color:red">Harga Beli :</label>
                            <input name="harga_beli" id="harga_beli" type="text" required="on" />
                        </div>

                        <div>
                            <label for="harga_jual" style="color:blue">Harga Jual :</label>
                            <input name="harga_jual" id="harga_jual" type="text" required="on" />
                        </div>

                        <div>
                            <label for="stok">Stok :</label>
                            <input name="stok" id="stok" type="text" required="on" /> /unit
                        </div>

                        <div>
                            <label for="lokasi">Lokasi :</label>

                            <select name="lokasi">
                                <?php
                                foreach(Lokasi::getInstance()->getAll() as $k => $v){
                                    echo '<option value="'. $v['lokasi_id'] .'">'. strtoupper( $v['nama_lokasi'] ).'</option>';
                                }
                                    ?>
                            </select>
                        </div>
                        <div>
                            <label for="ket">Keterangan Tambahan :</label>
                            <textarea name="ket" rows="3" style="width: 400px"></textarea>
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