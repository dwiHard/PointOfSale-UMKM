<?php
session_start();
$page_title = 'Select transaksi';
require_once 'my_func.php';
$script= array("jquery.datetimepicker.full.min.js");
include_once 'template/header.php';
?>

<link rel="stylesheet" href="css/jquery.datetimepicker.min.css">
<style>
    @media print {
        table{
            width: 100%;
            font-size: 13px;
        }
        .no-print{
            visibility: hidden;
            display: none;
        }

    }
</style>

<div id="content">
    <div class="section group" style="margin-bottom: 0;">
        <div class="col span_1_of_1 no-print" style="width: 90%">

            <div style="overflow-x:auto">
            <form method="post" action="laporan_penjualan_barang_res.php" accept-charset="utf-8" id="form-inline">
                <fieldset style="background: #C5EA96;">
                    <legend style="background: #547C8C; padding-left: 10px; color:#f2f2f2;">Laporan Hasil Penjualan Barang</legend>
                    <div>
                        <label for="dr_tgl">Dari Tanggal:</label>
                        <input name="dr_tgl" id="dr_tgl" type="text" required="on" placeholder="Tahun/bulan/tanggal" autocomplete="off" />
                    </div>
                    <div>
                        <label for="smp_tgl">Sampai Tanggal:</label>
                        <input name="smp_tgl" id="smp_tgl" type="text" required="on" placeholder="Tahun/bulan/tanggal" autocomplete="off" />
                    </div>
                    <div>
                        <label for="petugas">Kasir</label>
                        <select name="petugas_ID">
                            <option value="0">--Semua--</option>
                            <?php
                            foreach($user->getAll() as $k=> $v){
                                echo '<option value="'. $v['user_ID'] .'">'. $v['nama'] .'</option>';

                            }
                            ?>

                        </select>
                    </div>
                    <input type="hidden" name="command" value="select">
                    <input type="hidden" name="diajukan" value="1">
                    <input type="submit" value="Tampilkan" class="btn btn-print" style="border: none;">
                    <a href="penjualan_barangUI.php"><< batal</a>
                </fieldset>

            </form>
            </div>
        </div>

    </div>



</div>
<script>

    $.datetimepicker.setLocale('id');
    $('#dr_tgl, #smp_tgl').datetimepicker(
        {
//            format: $("#datetimepicker_format_value").val(),
            format: 'Y/m/d',
            timepicker:false
        });
</script>

<?php
include_once 'template/footer.php'; ?>
