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
        <?php
        if(isset($_GET['msg_op']) && $_GET['msg_op'] == 1){
            echo '<div class="msg success">Success : transaksi berhasil ditambahkan ke database !</div>';
        }
        if(isset($_GET['msg_op']) && $_GET['msg_op'] == 2){
            echo '<div class="msg success">Success : data barang berhasil di perbarui !</div>';
        }
        if(isset($_GET['msg_op']) && $_GET['msg_op'] == 3){
            echo '<div class="msg success">Success : 1 record barang berhasil di hapus !</div>';
        }
        ?>
        <form method="post" action="" accept-charset="utf-8" id="form-inline">
            <fieldset style="background: #fff;">
                <legend>Select transaksi Penjualan</legend>
                <div>
                    <label for="dr_tgl">Dari Tanggal:</label>
                    <input name="dr_tgl" id="dr_tgl" type="text" required="on" placeholder="Tahun/bulan/tanggal" autocomplete="off" />
                </div>
                <div>
                    <label for="smp_tgl">Sampai Tanggal:</label>
                    <input name="smp_tgl" id="smp_tgl" type="text" required="on" placeholder="Tahun/bulan/tanggal" autocomplete="off" />
                </div>

                <div>
                    <label for="petugas">Petugas</label>
                    <select name="petugas_ID">
                        <option value="0">--Semua--</option>
                        <?php
                            foreach(users::getInstance()->getAll() as $k=> $v){
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

    <div class="section group">

        <div class="col span_1_of_1" style="border:solid 1px #c2c2c2; background: #fff; width: 90%;padding: 10px; 10px; margin-top: 0">
            <?php
                if(isset($_POST['command']) && $_POST['command'] == 'select' && isset($_POST['diajukan'])){

                    if(empty($_POST['dr_tgl']) || empty($_POST['smp_tgl'])){
                        echo '<h2>pilih tanggal per-Periode !</h2>';
                    }
                    $res = $nota->selectTransaksi($_POST['dr_tgl'], $_POST['smp_tgl'], $_POST['petugas_ID']);
                    if(count($res) == 0){
                        echo '<h4 class="msg error">tidak ada transaksi berdasarkan tanggal yang Anda masukkan !</h4>';
                    }else{

                       ?>

            <div id="info-select" style="margin-bottom: 10px">
                <p style="background:#f2f2f2; display: inline">Transaksi Dari Tanggal

                    <span style="background:#E5E8A5;"><?php echo date("d/m/Y", strtotime($_POST['dr_tgl'])) ?></span> S/d
                    <span style="background:#E5E8A5;"><?php echo date("d/m/Y", strtotime($_POST['smp_tgl'])) ?></span>
                    <a href="javascript:window.print()">Print</a>
                </p>

            </div>
            <table style="font-size: 15px">
                <thead>
                <tr>
                    <th>No</th>
                    <th>No.Nota</th>
                    <th>Tanggal</th>
                    <th>Jam</th>
                    <th>Di Proses Oleh</th>
                    <th>Total Belanja</th>
                </tr>
                </thead>
                <tbody>

                <?php
                $total = 0;

                $i = 1;
                foreach($res as $k => $v){
                    echo '<tr>';
                    echo '<td>'.$i.'</td>';
                    echo "<td>".$v['nota_ID']."</td>";
                    echo "<td>". date('d/m/Y', strtotime( $v['tanggal'] ))."</td>";
                    echo "<td>".$v['jam']."</td>";
                    echo "<td>".$user->getNama($v['user_ID'])."</td>";
                    echo "<td>Rp. ".number_format ($v['total'], 0, ',', '.')."</td>";
                    echo '</tr>';
                    $total += $v['total'];

                    $i++;
                }
                ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="5" style="text-align: right; background: #f2f2f2">Total Penjualan :</td>
                        <td colspan="2" style="background: #f2f2f2; font-weight: bold">Rp. <?php echo number_format ($total, 0, ',', '.');?></td>


                    </tr>
                </tfoot>
            </table>
                        Total Row : <?php echo count($res); ?> record








                    <?php
                    }
                }
            ?>
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



