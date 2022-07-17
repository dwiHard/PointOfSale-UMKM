<?php
session_start();
$page_title = 'Detail Supplier';
require_once 'my_func.php';
include_once 'template/header.php';
$val = supplier::getInstance()->show(base64_decode($_GET['id']));
?>

    <div id="content">
        <div class="section group">
            <div class="col span_1_of_2">
                <form method="post" action="action_supplier.php" accept-charset="utf-8">
                    <fieldset>
                        <legend>Detail Supplier</legend>
                        <div>
                            <label for="nama">Nama:</label>
                            <input name="nama" id="nama" type="text" value="<?php echo $val['nama'] ?>" required="on" />
                        </div>

                        <div>
                            <label for="alamat">Alamat:</label>
                            <input name="alamat" id="alamat" value="<?php echo $val['alamat'] ?>" type="text" required="on" />
                        </div>

                        <div>
                            <label for="alamat">no_hp:</label>
                            <input name="no_telpon" id="no_telpon" value="<?php echo $val['no_telpon'] ?>" type="text" required="on" />
                        </div>

                        <input type="hidden" name="command" value="edit">
                        <input type="hidden" name="diajukan" value="1">
                        <input type="hidden" name="id" value="<?php echo $val['supplier_ID'] ?>">
                        <input type="submit" value="Simpan">
                        <button onclick="">Batal</button>
                    </fieldset>
                </form>
            </div>
        </div>
    </div>

<?php
include_once 'template/footer.php'; ?>