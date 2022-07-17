$(function() {

    jQuery('#tgl_brg_masuk').datetimepicker({
        timepicker:false,
        format:'d-m-Y'
    });

    $("#barcode").focus();
    $("#uang_bayar").on('keyup',function(){
        $("#uang_bayar").maskMoney(
            {
                thousands:'.', decimal:'.', allowZero:true,
                precision :0,
                allowNegative: false
            }
        );

        var grand_total = $("#grand_total").text();
        var val_grand = grand_total.replace('.','');
        var i;
        var total = "";
        for(i = 0; i< val_grand.length; i++){
            total += val_grand.charAt(i).replace('.','');
        }
        var uang_format = $("#uang_bayar").val();
        var j;
        var dibayar = "";
        for(j = 0; j< uang_format.length; j++){
            dibayar += uang_format.charAt(j).replace('.','');
        }



        var uang_balik= dibayar - total;




            $("#uang_kembali").maskMoney(
                {
                    thousands:'.', decimal:'.', allowZero:true,
                    precision :0,
                    allowNegative: true
                }
            )
                .val(uang_balik);




        e.preventDefault();
        $("#uang_kembali").focus();


    });




});
