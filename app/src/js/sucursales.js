/*==============================
SELECT SUCURSALES
===============================*/
function selectAllSucursales(search) {
    let tabla = "sucursales";
    $.ajax({
        method: "POST",
        url: "app/src/ajax/sucursales.ajax.php",
        data: { 'selectSucursales': tabla, 'search': search },
        success: function (respuesta) {
            $("#mostrarSucursal").html(respuesta);//ingresa mensaje en html
        }
    });
}

/*==============================
SEARCH SUCURSALES
===============================*/
function searchSucursal() {
    var search = document.getElementById('searchSucursal').value;
    selectAllSucursales(search);
}

$(document).ready(function () {
    var search = '';
    selectAllSucursales(search);
});

function limpiarFormSucursal() {
    $('#addFormSucursal')[0].reset();
    $('.form-control').find($('option')).attr('selected', false)//deselecciona selects
    document.getElementById('provincia').innerHTML = "";
    document.getElementById('ubigeo').innerHTML = "";
    $("#provincia").html(` <option id="editarProvincia">Seleccione</option>`);//provincia
    $("#ubigeo").html(`<option id="editarDistrito" value="0">Seleccione</option>`);//distrito
    $("#btnGuardarSucursal").attr('editarSucursal', 'NO')
    $("#btnGuardarSucursal").attr('idSucursal', '0')
}
//// crear editar
$('#btnGuardarSucursal').click(function () {
    var sucursal = [];

    sucursal.push({
        'id':$(this).attr("idSucursal"),
        'nombre': document.getElementById("nombreSucursal").value,
        'ubigeo': document.getElementById("ubigeo").value,
        'direccion': document.getElementById("direcSucursal").value,
        'referencia': document.getElementById("referSucursal").value,
        'editar': $(this).attr("editarSucursal")
    });
    if (sucursal[0]['nombre'] != "" && sucursal[0]['direccion'] != "" && sucursal[0]['ubigeo'] != 0 && sucursal[0]['ubigeo'] != '') {
        $.ajax({
            method: "POST",
            url: "app/src/ajax/sucursales.ajax.php",
            data: { 'addSucursal': sucursal[0] },
            success: function (respuesta) {
                var search = '';
                selectAllSucursales(search);
                $("#smsconfirmations").html(respuesta);//ingresa mensaje en html
            }
        });

    } else {
        alertify.error('Complete todos los campos *');
    }
});

////////funcion get data para editar
function editarSucursal(id) {
    var datos = new FormData();

    datos.append("idSelectEditarSuc", parseInt(id));
    $.ajax({
        url: "app/src/ajax/sucursales.ajax.php",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function (respuesta) {
            limpiarFormSucursal();
            $("#inlineForm").modal('show');
            //add data

            $("#nombreSucursal").val(respuesta["nombre"]);

            let depa = respuesta["ubigeo"];
            $("#region option[value='" + depa.substr(0, 2) + "0000']").attr("selected", "selected");
            $("#editarProvincia").html(respuesta["provi"]);//provincia
            $("#editarDistrito").html(respuesta["dist"]);//distrito
            $("#editarDistrito").val(respuesta["ubigeo"]);//distrito
            $("#direcSucursal").val(respuesta["direccion"]);
            $("#referSucursal").val(respuesta["referencia"]);
            $("#btnGuardarSucursal").attr('editarSucursal', 'SI')
            $("#btnGuardarSucursal").attr('idSucursal', id)
        }
    });
}
///////////function eleminar
function eliminarSucursal(id) {
    Swal.fire({
        title: 'Está seguro?',
        text: "La sucursal se eliminara definitivamente!",
        icon: 'error',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#dd6b55',
        confirmButtonText: 'Si, eliminar!'
    }).then((result) => {
        if (result.isConfirmed) {

            var datos = new FormData();

            datos.append("idEliminar", id);

            $.ajax({
                url: "app/src/ajax/sucursales.ajax.php",
                method: "POST",
                data: datos,
                cache: false,
                contentType: false,
                processData: false,
                success: function (respuesta) {
                    $("#smsconfirmations").html(respuesta);///
                    var search = '';
                    selectAllSucursales(search);
                }
            });

        }
    })
}