/*function ChoosePg(id) {
    window.open("pg_choose_tanggung_jawab.php?choose=yes&id=" + id, "_blank",
        "height=600, width=800, top=10, left=100, tab=no, " +
        "location=no, menubar=no, status=no, toolbar=no", false);
}
function ClearField(id) {
    $('input[name="id_tanggung_jawab"]').attr('value','0');
    $('#nama_penanggung_jawab').val('');
}
function HaveChoice(id, result, label) {
    $('input[name="id_tanggung_jawab"]').attr('value',result);
    $('#nama_penanggung_jawab').val(label);
}
*/

function Choose_brg(id) {
    window.open("choose_barang.php?choose=yes&id=" + id, "_blank",
        "height=600, width=900, top=10, left=100, tab=no, " +
        "location=no, menubar=no, status=no, toolbar=no", false);
}
function ClearField2(id) {
    $('input[name="barang_id"]').attr('value','0');
    $('#nama_barang').val('');

}
function HaveChoicePegawai(id, result, label) {
    $('input[name="barang_id"]').attr('value',result);
    $('#nama_barang').val(label);
}




