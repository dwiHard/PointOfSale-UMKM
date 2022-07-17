<?php
session_start();
require_once 'my_func.php';
require_once 'function_barang_masuk.php';
require_once 'function_cart.php';

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN"
    "http://www.w3.org/TR/html4/strict.dtd">

<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Pilih Barang</title>

    <style>
        html, body, div, span, object, iframe,
        h1, h2, h3, h4, h5, h6, p, blockquote, pre,
        abbr, address, cite, code,
        del, dfn, em, img, ins, kbd, q, samp,
        small, strong, sub, sup, var,
        b, i,
        dl, dt, dd, ol, ul, li,
        fieldset, form, label, legend,
        table, caption, tbody, tfoot, thead, tr, th, td,
        article, aside, canvas, details, figcaption, figure,
        footer, header, hgroup, menu, nav, section, summary,
        time, mark, audio, video {
            margin:0;
            padding:0;
            border:0;
            outline:0;
            font-size:100%;
            vertical-align:baseline;
            background:transparent;
        }
        #table-1, td, tr, th{
            border:solid 1px #fff;
            background: #f2f2f2;
            padding: 4px 10px;
        }
        #table-1{
            border-collapse: collapse;
        }
        body{
            overflow: scroll;
            padding: 0 20px;
            margin:0;
        }

        mark{
            background: #DEEAB9;
            padding: 10px;
            border:solid 1px #EABB39;
        }
    </style>

    <script language="javascript">
        function del(pid){
            if(confirm('Apakah Anda ingin meng-hapus item ini ?')){
                document.form1.pid.value=pid;
                document.form1.control.value='delete';
                document.form1.submit();
            }
        }
    </script>



</head>
<body>
<div class="container" style="background:#78A930; padding-bottom: 20px;">

    <h2 style="color:#212121; font-size: 22px;">Pilih Barang ?</h2>
    <form action="" method="POST">
        Barcode/Nama Barang <input type="text" name="cari">
        <input type="hidden" name="diajukan" value="1">
        <input type="submit" value="Cari">
    </form>
</div>
<?php
//tambah transaksi pembelian
if(isset($_POST['command']) && $_POST['command'] == 'tambah_stok' && $_POST['barang_id'] != ""){

    if(empty($_POST['jumlah'])){
        die("jumlah tidak boleh kosong !");
    }
    $_POST['jumlah'] = (int) $_POST['jumlah'];
    if(strlen($_POST['harga_beli']) < 3 && $_POST['harga_jual'] < 3){
        die("<h2>field harga beli/jual tidak valid, mohon periksa kembali !");
    }else{
        if(strlen($_POST['jumlah']) < 1){
            die("jumlah tidak valid!");
        }
        if(!is_int($_POST['jumlah']) ){
            die("jumlah tidak valid!");
        }
        tambah_ke_transaksi($_POST['barang_id'], $_POST['jumlah'], $_POST['harga_beli'], $_POST['harga_jual']);
    }
}

if(isset($_REQUEST['control']) && $_REQUEST['control']=='delete' && $_REQUEST['pid']>0){
    remove_barang_transaksi($_REQUEST['pid']);
}

if(isset($_POST['command']) && $_POST['command'] == 'clear'){
    print 'command ::clear';
}



if(isset($_POST['diajukan']) && strlen($_POST['cari']) > 3){
$dt = $barang->search($_POST['cari']);

if(count($dt) == 0){
    echo "<div style='background-color:#FFB4AC; padding:4px 8px; color:#212121;'>tidak di temukan nama yang bersangkutan, silahkan masukkan kata kunci yang lain..</div>";
}else{ ?>

    <table>
        <tr>
            <td colspan="2" style="background: #EACD44; color:#212121;"><strong>Tambah stoct barang</strong>
                <p>perubahan pada harga beli dan harga jual, akan mempengaruhi data pada master barang</p></td>
        </tr>
    </table>
    <?php
    foreach($dt as $k=> $v){ ?>
        <div style="border: solid 1px #EA9127; margin-bottom: 20px; ">
<table id="table-1" style="width: 100%">
        <tr>
            <td style="width: 160px;">barcode</td>
            <td><?php echo $v['kode_barang']; ?></td>
        </tr>
        <tr>

            <td>nama</td>
            <td><?php echo $v['nama']; ?></td>
        </tr>

        <tr>

            <td>stok akhir/tersedia</td>
            <td><?php echo $v['stok']; ?></td>
        </tr>
        <tr>
            <td>jumlah terjual</td>
            <td><?php echo $v['terjual']; ?></td>
        </tr>


        <tr>
            <td>Jumlah :</td>

            <td>
                <form method="post" action="">
                    <input type="text" name="jumlah" style="width: 80px;" maxlength="3">
                    <input type="hidden" name="barang_id" value="<?php echo $v['barang_ID']; ?>">
                    <input type="hidden" name="command" value="tambah_stok">
            </td>
        </tr>
        <tr>
            <td>Harga Beli :</td>
            <td>    <input type="text" name="harga_beli" value="<?php echo $v['harga_beli'] ?>"></td>
        </tr>

        <tr>
            <td>Harga Jual :</td>
            <td>    <input type="text" name="harga_jual" value="<?php echo $v['harga_jual'] ?>"></td>
        </tr>
        <tr>
            <td></td>
            <td>
                <input type="submit" value="tambah stok barang" style="background: #08910F; padding: 4px; color:#fff; border:none;">
                </form>
                </td>
        </tr>

    </table></div>
    <?php }



    }

    }else{
        if(isset($_SESSION['beli']) && is_array($_SESSION['beli']) && count($_SESSION['beli']) > 0){
            ?>

    <form name="form1" method="post" onsubmit="return on_submit(this)">
        <input type="hidden" name="pid" />
        <input type="hidden" name="control" />
    <table id="table-1">
        <tr>
            <th>Nama</th>
            <th>Jumlah</th>
            <th>Harga Beli</th>
            <th>Harga Jual</th>
            <th>Subtotal</th>
        </tr>
    <?php
            $max = count($_SESSION['beli']);
    $total = 0;
            $i = 0;
            while($i < $max){
                $pid = $_SESSION['beli'][$i]['productid'];
                $q = $_SESSION['beli'][$i]['qty'];
                $harga_beli = $_SESSION['beli'][$i]['harga_beli'];
                $harga_jual = $_SESSION['beli'][$i]['harga_jual'];
            $total += $harga_beli;
                ?>
        <tr>
            <td>
                <a href="javascript:del(<?= $pid ?>)" style="color: #E8442F;">(x)</a>
                <?php echo get_product_name($pid); ?>
            </td>
            <td style="background: #DDEAC1"><?php echo $q; ?></td>
            <td style="background: #DDEAC1"><?php echo number_format($harga_beli, 0, ',', '.'); ?></td>
            <td><?php echo number_format($harga_jual, 0, ',', '.'); ?></td>

            <td style="background: #DDEAC1"><?php echo number_format($harga_beli * $q, 0, ',', '.'); ?></td>

        <?php
                $i++;
            }

    echo '
    <tr>
    <td style="text-align:right;font-weight:bold; color:blue;" colspan=4>Total Pembelian Barang Masuk :</td>
    <td>'. number_format(get_total_beli(), 0, ',', '.') .'</td>
    </tr>
    </table>';
        }

    }
    ?>

</form><!-- //form-1  -->

</table>
    <br><mark>jika barang sudah di tambahkan silahkan tutup jendela dan kemudian refresh untuk load barang masuk.</mark>
<script src="js/jquery.min.js"></script>
<script src="js/jquery-ean13.min.js"></script>

<script type="text/javascript">
    function MadeChoice(id, result, label) { // executes in popup
        window.opener.HaveChoicePegawai(id, result, label);
        window.close();
    }
</script>
</body>
</html>
