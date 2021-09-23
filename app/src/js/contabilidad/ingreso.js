function selectingreso(search) {
    let tabla = $("#iddnone").val();
    $.ajax({
        method: "POST",
        url: "app/src/ajax/contabilidad/ingreso.ajax.php",
        data: { 'selectingreso': tabla, 'search': search },
        success: function (respuesta) {
            $("#mostraringreso").html(respuesta);//ingresa mensaje en html
        }
    });
}
/*==============================
SEARCH DEPAS
===============================*/
function searchingreso() {
    var search = document.getElementById('dateStart').value;
    selectingreso(search);
}
$(document).ready(function () {
    try {
        var search = document.getElementById('dateStart').value;
        selectingreso(search);
    } catch (error) {
        //
    }
});
/*============================== 
    CREAR/EDITAR GASTOS
===============================*/
$('#Addingreso').click(function () {
    var depa = {
        'id': $(this).attr("idingerso"),
        'id_tipo': $('#idingresotipo').val(),
        'fecha': $('#datetimeStart').val() + " " + $('#timeStar').val(),
        'cantidad': $('#salTrabajador').val(),
        'descripcion': $('#idescribeing').val(),
        'editar': $(this).attr("editaringreso"),
    };

    if (depa['nombre'] != "") {
        $.ajax({
            method: "POST",
            url: "app/src/ajax/contabilidad/ingreso.ajax.php",
            data: { 'Addingreso': depa },
            success: function (respuesta) {
                var search = document.getElementById('dateStart').value;
                selectingreso(search);
                $("#smsconfirmations").html(respuesta);//ingresa mensaje en html]
                if ($('#Addingreso').attr("editaringreso") == "NO") {
                    limpiarINgForm();
                }
            }
        });
    } else {

        alertify.error('Complete  los campos');
    }

});
/* GET Editar DEPA */
function limpiarINgForm() {
    $('#addFormingreso')[0].reset();
    $("#Addingreso").attr('editaringreso', 'NO')
    $("#Addingreso").attr('idingerso', '0')
}
function editarIngres(id, tipo,cant,fecha,desc) {
    limpiarINgForm();
    $("#inlineForm").modal('show');
    let string = String(fecha);
    let date = string.split(' ');
    $("#idingresotipo option[value='" + tipo + "']").attr("selected", "selected");
    $("#timeStar").val(date[1]);
    $("#datetimeStart").val(date[0]);
    $("#salTrabajador").val(cant);
    $("#idescribeing").val(desc);
    $("#Addingreso").attr('editaringreso', 'SI')
    $("#Addingreso").attr('idingerso', id)
}
///////////function eleminar
function eliminarIng(id) {
    Swal.fire({
        title: 'Está seguro?',
        text: "Se eliminara el Ingreso definitivamente!",
        icon: 'error',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#dd6b55',
        confirmButtonText: 'Si, eliminar!'
    }).then((result) => {
        if (result.isConfirmed) {
            var datos = new FormData();
            datos.append("idEliminarI", id);
            $.ajax({
                url: "app/src/ajax/contabilidad/ingreso.ajax.php",
                method: "POST",
                data: datos,
                cache: false,
                contentType: false,
                processData: false,
                success: function (respuesta) {
                    $("#smsconfirmations").html(respuesta);///
                    var search = document.getElementById('dateStart').value;
                    selectingreso(search);
                }
            });

        }
    })
}

function exelreportesCont(){
    let mes = $('#dateStart').val()
    let url = "/contabilidad/detalle-reporte-exel/" + mes;
    javascript: window.open(url, '_blank');
}