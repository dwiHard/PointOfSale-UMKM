<?php
session_start();
$page_title = 'Product barcode';
require_once 'my_func.php';
$script= array("jquery.datetimepicker.full.min.js");
include_once 'template/header.php';
?>
<script type="text/javascript">
    function changeBoxes(action){
     var f=document.forms[0];
     var elms=f.elements;
     for(var i=0;i<elms.length;i++){
     if(elms[i].type!='checkbox'){continue;}
     if(action<0){
     elms[i].checked=elms[i].checked?0:1;
     } else {
     elms[i].checked=action;
     }
     }
     }
     
    function changeBoxes(action){
        var f=document.forms[0];
        var elms=f.elements;
        for(var i=0;i<elms.length;i++){
            if(elms[i].type!='checkbox'){continue;}
            elms[i].checked=action<0?(elms[i].checked?0:1):action;
        }
    }

</script>

<div id="content">
    <div class="section group" style="margin-bottom: 0;margin-top:20px">
        <div class="col span_1_of_1 no-print" style="width: 90%">
 <?php
 if ($_SESSION['__username'] == 'admin'){
     echo "<a href='menuUI.php'>Kembali</a>";
 }else{
     echo "<a href='dashboard.php'>Kembali</a>";
 }
?>
            <div style="overflow-x:auto">
                <fieldset style="background: #f2f2f2;">
                    <legend style="background: #fff; padding-left: 10px; color:#212121;">Print Barcode</legend>

            <table>
                        
                        <tbody>
                        <?php $hasil =  barang::getInstance()->getAll();
                            foreach ($hasil as $k=> $v):
                        ?>
                        <tr>
                            <form method="post" action="produk_barcode.php" accept-charset="utf-8" id="form-inline">
            
                            <td><?php echo '<a href="#">'.$v['kode_barang'].'</a><span style="color:blue;"> '.ucfirst($v['nama']).' ('. $v['stok'] .') ' ?> </span> </td>
                             <td>
                                <input type="hidden" name="id" value="<?php echo $v['kode_barang']; ?>">
                    <input type="hidden" name="diajukan" value="1">
                    <input type="submit" value="Tampilkan" class="btn btn-print" style="border: none;">
                             </td>  
            </form> 
                        </tr>
                        <?php endforeach; ?>

                        </tbody>
            </table>
                    <br>
                    <span style="color:#999;">* pilih salah satu, klik kanan lalu cetak barcode !</span>

                    
                </fieldset>
            </div>
        </div>

    </div>



</div>

<?php
include_once 'template/footer.php'; ?>



