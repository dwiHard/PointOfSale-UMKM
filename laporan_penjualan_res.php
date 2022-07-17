<?php
session_start();
$page_title = 'hasil laporan stok barang';
require_once 'my_func.php';
$script= array("jquery.datetimepicker.full.min.js");
?>

<html>
<head>
    <title>Hasil Laporan Stok Barang</title>
</head>
<style>
    html, body{
        width: 900px; 
        margin:0 auto;
        font-family: 'Titillium Web', sans-serif;
    }

    table, td, tr{
        padding: 10px !important;
        border: solid 1px #ccc;
    }
    td{
        padding: 2px 10px;

    }
    table{
        border-collapse: collapse;
    }
    table thead{
        background: #f2f2f2;
    }

    table thead tr td,
    table thead tr{
        border:solid 1px #fff;
    }
    .msg{
        background: rgba(201, 234, 226, 0.89);
        border:solid 1px #A4E1EA;
        padding: 4px 10px;
    }

    table thead tr th{
        padding: 4px;
        background: #f2f2f2;
        border:solid 1px #999;
    }

</style>
<body>
<?php
if(isset($_POST['command']) && $_POST['command'] == 'select' && isset($_POST['diajukan'])){

    $res = nota::getInstance()->selectTransaksi( $_POST['dr_tgl'], $_POST['smp_tgl'], $_POST['petugas_ID'] );
    if(count($res) == 0){
        echo '<h2 class="msg error">tidak ada transaksi berdasarkan tanggal yang Anda masukkan !</h2>';
    }else{
        ?>

        <div id="info-select" style="margin-bottom: 10px">
            <hr>
            <h3 style="background:#f2f2f2; display: inline">Laporan Transaksi Penjualan
                <span style="background:#E5E8A5;"><?php echo date("d-m-Y", strtotime($_POST['dr_tgl'])) ?></span> S/d
                <span style="background:#E5E8A5;"><?php echo date("d-m-Y", strtotime($_POST['smp_tgl'])) ?></span>
                <a href="javascript:window.print()">Print</a>
            </h3>
<hr>
        </div>


        <table>
            <thead>
            <tr>
                <th>No</th>
                <th>No.Nota</th>
                <th>Kasir</th>
                <th>Tanggal</th>
                <th>Jam</th>
                <th>Total Belanja</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>

            <?php

            $total = 0;
            $i = 1;
            foreach ($res as $k => $v) {
                $total +=$v['total'];
                echo '<tr>';
                echo '<td>' . $i . '</td>';
                echo "<td>" . $v['nota_ID'] . "</td>";
                echo "<td>" . $user->getNama($v['user_ID']) . "</td>";
                echo "<td>" . date('d/m/Y', strtotime($v['tanggal'])) . "</td>";
                echo "<td>" . $v['jam'] . "</td>";
                echo "<td>Rp. " . number_format($v['total'], 0, ',', '.') . "</td>";



                echo "<td><a target='blank' class='btn-print' href='nota_detailUI.php?id=" . base64_encode($v['nota_ID']) . "'>Detail</a>

                        </td>";
                echo '</tr>';

                $i++;
            }

            ?>
            </tbody>
            <tfoot>
            <tr style="background: #eee;">
                <td colspan="5" style="text-align: right">GRANT TOTAL :</td>
                <?php echo "<td style='font-weight:bold;'>Rp. " . number_format($total, 0, ',', '.') . "</td>"; ?>

            </tr>
            </tfoot>

        </table>


        Total Row : <?php echo count($res); ?> record


    <?php
    }
}
?>
</body>
</html>
