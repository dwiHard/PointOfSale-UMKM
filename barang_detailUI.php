<?php
session_start();
$page_title = 'Barang';
$script = array('jquery.maskMoney.min.js','jquery-ean13.min.js');

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

                $brg = $barang->show(base64_decode($_GET['id']));
                ?>
                <form method="post" action="action_barang.php" accept-charset="utf-8">
                    <fieldset>
                        <legend>Detail Barang</legend>
                        <div>
                            <label for="kd_barang">Kode Barang:</label>
                            <input name="" id="kd_barang" disabled type="text" value="<?php echo $brg['kode_barang'] ?>" />
                        </div>
                        <div>
                            <label for="nm_barang">Nama Barang:</label>
                            <input name="nm_barang" id="nm_barang" type="text" required="on" value="<?php echo $brg['nama'] ?>"/>
                        </div>
                        <div>
                            <label for="harga_beli">Harga Beli :</label>
                            <input name="harga_beli" id="harga_beli" type="text" required="on" value="<?php echo $brg['harga_beli'] ?>" />
                        </div>

                        <div>
                            <label for="harga_jual">Harga Jual :</label>
                            <input name="harga_jual" id="harga_jual" type="text" required="on" value="<?php echo $brg['harga_jual'] ?>" />
                        </div>

                        <div>
                            <label for="stok">Stok :</label>
                            <input name="stok" id="stok" type="text" required="on" value="<?php echo $brg['stok'] ?>" /> /unit
                        </div>


                        <div>
                            <label for="lokasi">Lokasi :</label>

                            <select name="lokasi">
                                <?php
                                foreach($lokasi->getAll() as $k => $v){
                                    if($brg['lokasi_id'] == $v['lokasi_id']){
                                        echo '<option value="'. $v['lokasi_id'] .'" selected>'. strtoupper( $v['nama_lokasi'] ).'</option>';
                                    }else{
                                        echo '<option value="'. $v['lokasi_id'] .'">'. strtoupper( $v['nama_lokasi'] ).'</option>';
                                    }

                                }
                                ?>
                            </select>
                        </div>

                        <div>
                            <label for="ket">Keterangan Tambahan :</label>
                            <textarea name="ket" rows="3" style="width: 400px"><?php echo $brg['ket'] ?></textarea>
                        </div>
<input type="hidden" name="kd_barang" id="kd_barang" value="<?php echo $brg['kode_barang'] ?>" />
                        <input type="hidden" name="command" value="edit">
                        <input type="hidden" name="diajukan" value="1">
                        <input type="hidden" name="barang_ID" value="<?php echo $brg['barang_ID']; ?>">
                        <input type="submit" value="Simpan" >
                        <button onclick="history.go(-1);" >Batal</button>
                        
                    </fieldset>

                </form>

            </div>

            <div class="col span_1_of_2">
                    <fieldset>

                        <canvas id="ean" width="200" height="80"></canvas>
                        <legend>Informasi</legend>
                <div>
                    <label for="created">Di entry tanggal : <?php echo date("d-m-Y H:i", strtotime($brg['created_at'])) ?></label>
                    <label for="created">Terakhir diperbarui : <?php echo date("d-m-Y H:i", strtotime($brg['updated_at'])) ?></label>
                    <label for="created">Dibuat Oleh : <?php echo $user->getNama($brg['user_ID']) ?></label>
                </div>
                        </fieldset>
            </div>




        </div>
    </div>

    <script type="text/javascript">
        $("#ean").EAN13("<?php echo $brg['kode_barang'] ?>");
    </script>
<?php
include_once 'template/footer.php'; ?>