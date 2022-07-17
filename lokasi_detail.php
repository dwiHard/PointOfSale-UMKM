<?php
session_start();
$page_title = 'Detail Lokasi';
require_once 'my_func.php';
include_once 'template/header.php';
$val = lokasi::getInstance()->show(base64_decode($_GET['id']));
?>

    <div id="content">
        <div class="section group">
            <div class="col span_1_of_2">
                <form method="post" action="action_lokasi.php" accept-charset="utf-8">
                    <fieldset>
                        <legend>Detail Lokasi</legend>
                        <div>
                            <label for="nama">Nama:</label>
                            <input name="nama" id="nama" type="text" value="<?php echo $val['nama_lokasi'] ?>" required="on" />
                        </div>

                        
                        <input type="hidden" name="command" value="edit">
                        <input type="hidden" name="diajukan" value="1">
                        <input type="hidden" name="id" value="<?php echo $val['lokasi_id'] ?>">
                        <input type="submit" value="Simpan">
                        <button onclick="">Batal</button>
                    </fieldset>
                </form>
            </div>
        </div>
    </div>

<?php
include_once 'template/footer.php'; ?>