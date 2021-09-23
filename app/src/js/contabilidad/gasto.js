function selectgasto(search) {
    let tabla = $("#iddnone").val();
    $.ajax({
        method: "POST",
        url: "app/src/ajax/contabilidad/ingreso.ajax.php",
        data: { 'selectgasto': tabla, 'search': search },
        success: function (respuesta) {
            //console.log(respuesta)
            $("#mostrargasto").html(respuesta);//ingresa mensaje en html
        }
    });
}
/*==============================
SEARCH DEPAS
===============================*/
function searchgasto() {
    var search = document.getElementById('dateStart').value;
    selectgasto(search);
}
$(document).ready(function () {
    try {
        var search = document.getElementById('dateStart').value;
        selectgasto(search);
    } catch (error) {
        //
    }
});
/*============================== 
    CREAR/EDITAR GASTOS
===============================*/
$('#Addgasto').click(function () {
    var depa = {
        'id': $(this).attr("idgasto"),
        'id_tipo': $('#idgastotipo').val(),
        'fecha': $('#datetimeStart').val() + " " + $('#timeStar').val(),
        'cantidad': $('#salTrabajador').val(),
        'descripcion': $('#idescribeing').val(),
        'editar': $(this).attr("editargasto"),
    };

    if (depa['nombre'] != "") {
        $.ajax({
            method: "POST",
            url: "app/src/ajax/contabilidad/ingreso.ajax.php",
            data: { 'Addgasto': depa },
            success: function (respuesta) {
                var search = document.getElementById('dateStart').value;
                selectgasto(search);
                $("#smsconfirmations").html(respuesta);//ingresa mensaje en html]
                if ($('#Addgasto').attr("editargasto") == "NO") {
                    limpiarGasForm();
                }
            }
        });
    } else {

        alertify.error('Complete  los campos');
    }

});
/* GET Editar DEPA */
function limpiarGasForm() {
    $('#addFormgasto')[0].reset();
    $("#Addgasto").attr('editargasto', 'NO')
    $("#Addgasto").attr('idgasto', '0')
}
function editarGasto(id, tipo, cant, fecha, desc) {
    limpiarGasForm();
    $("#inlineForm").modal('show');
    let string = String(fecha);
    let date = string.split(' ');
    $("#idgastotipo option[value='" + tipo + "']").attr("selected", "selected");
    $("#timeStar").val(date[1]);
    $("#datetimeStart").val(date[0]);
    $("#salTrabajador").val(cant);
    $("#idescribeing").val(desc);
    $("#Addgasto").attr('editargasto', 'SI')
    $("#Addgasto").attr('idgasto', id)
}
///////////function eleminar
function eliminarGasto(id) {
    
    Swal.fire({
        title: 'Está seguro?',
        text: "Se eliminara el Gasto definitivamente!",
        icon: 'error',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#dd6b55',
        confirmButtonText: 'Si, eliminar!'
    }).then((result) => {
        if (result.isConfirmed) {
            var datos = new FormData();
            datos.append("idEliminarG", id);
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
                    selectgasto(search);
                }
            });

        }
    })
}