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
    <div class="section group" style="margin-bottom: 0">
        <div class="col span_1_of_1 no-print" style="width: 90%">

            <div style="overflow-x:auto">
            <form method="post" action="laporan_stok_res.php" accept-charset="utf-8" id="form-inline">
                <fieldset style="background: #FFBAE8;">
                    <legend style="background: #547C8C; padding-left: 10px; color:#fff;">Laporan Stok Barang</legend>

                    <div>
                        <label for="min_stok">Stok :</label>
                        <select name="jum_stok">
                            <option value="0"> == 0</option>
                            <option value="10"> <= 10</option>
                            <option value="20"> <= 20</option>
                            <option value="30"> <= 30</option>
                            <option value="31"> >= 31</option>
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



