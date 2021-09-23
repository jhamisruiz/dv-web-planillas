function selecttipoingreso(search) {
    let tabla = "tipo_contabilidad";
    $.ajax({
        method: "POST",
        url: "app/src/ajax/contabilidad/tipo.ajax.php",
        data: { 'selecttipoingreso': tabla, 'search': search },
        success: function (respuesta) {
            $("#mostrartipoingreso").html(respuesta);//ingresa mensaje en html
        }
    });
}
/*==============================
SEARCH DEPAS
===============================*/
function searchtipoingreso() {
    var search = document.getElementById('searchtipoingreso').value;
    selecttipoingreso(search);
}
$(document).ready(function () {
    var search = '';
    selecttipoingreso(search);
    selectTipoGas(search);
});
/*============================== 
    CREAR/EDITAR GASTOS
===============================*/
$('#Addtipoingreso').click(function () {
    var depa = [];
    depa.push({
        'id': $(this).attr("idtipoingerso"),
        'nombre': document.getElementById("nomtipoingreso").value,
        'descripcion': document.getElementById("destipoingreso").value,
        'editar': $(this).attr("editartipoingreso")
    })

    if (depa[0]['nombre'] != "") {
        $.ajax({
            method: "POST",
            url: "app/src/ajax/contabilidad/tipo.ajax.php",
            data: { 'Addtipoingreso': depa },
            success: function (respuesta) {
                var search = '';
                selecttipoingreso(search);
                $("#smsconfirmations").html(respuesta);//ingresa mensaje en html]
                if ($('#Addtipoingreso').attr("editartipoingreso") == "NO") {
                    limpiarTINgForm();
                }
            }
        });
    } else {

        alertify.error('Complete  los campos');
    }

});
/* GET Editar DEPA */
function limpiarTINgForm() {
    $('#addFormtipoingreso')[0].reset();
    $("#Addtipoingreso").attr('editartipoingreso', 'NO')
    $("#Addtipoingreso").attr('idtipoingerso', '0')
}
function editarTipoIng(id, nom, desc) {
    limpiarTINgForm();
    $("#inlineForm").modal('show');
    $("#nomtipoingreso").val(nom);
    $("#destipoingreso").val(desc);
    $("#Addtipoingreso").attr('editartipoingreso', 'SI')
    $("#Addtipoingreso").attr('idtipoingerso', id)
}
///////////function eleminar
function eliminarTipoIng(id) {
    Swal.fire({
        title: 'Está seguro?',
        text: "Se eliminara el este tipo definitivamente!",
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
                url: "app/src/ajax/contabilidad/tipo.ajax.php",
                method: "POST",
                data: datos,
                cache: false,
                contentType: false,
                processData: false,
                success: function (respuesta) {
                    $("#smsconfirmations").html(respuesta);///
                    var search = '';
                    selecttipoingreso(search);
                }
            });

        }
    })
}

/* ========================================================== */
//    TIPO  GASTOS       //
/* ========================================================== */
function selectTipoGas(search) {
    let tabla = "tipo_contabilidad";
    $.ajax({
        method: "POST",
        url: "app/src/ajax/contabilidad/tipo.ajax.php",
        data: { 'selecttipogas': tabla, 'search': search },
        success: function (respuesta) {
            $("#mostrartipogastos").html(respuesta);//ingresa mensaje en html
        }
    });
}
/*==============================
SEARCH GASTO
===============================*/
function searchTipoGas() {
    var search = document.getElementById('searchTipoGas').value;
    selectTipoGas(search);
}

/*============================== 
    CREAR/EDITAR 
===============================*/
$('#Addtipogastos').click(function () {
    var empleo = [];
    empleo.push({
        'id': $(this).attr("idtipogasto"),
        'nombre': document.getElementById("nomtipogasto").value,
        'descripcion': document.getElementById("destipogasto").value,
        'editar': $(this).attr("editartipogasto")
    })

    if (empleo[0]['nombre'] != "") {
        $.ajax({
            method: "POST",
            url: "app/src/ajax/contabilidad/tipo.ajax.php",
            data: { 'Addtipogastos': empleo },
            success: function (respuesta) {
                var search = '';
                selectTipoGas(search);
                $("#smsconfirmations").html(respuesta);//ingresa mensaje en html]
                if ($('#Addtipogastos').attr("editartipogasto") == "NO") {
                    limpiarTipoGas();
                }
            }
        });
    } else {

        alertify.error('Complete  los campos');
    }

});
/* GET Editar DEPA */
function limpiarTipoGas() {
    $('#addtipogasto')[0].reset();
    $("#Addtipogastos").attr('editartipogasto', 'NO')
    $("#Addtipogastos").attr('idtipogasto', '0')
}
function editarTipoGas(id, nom, desc) {
    limpiarTipoGas();
    $("#inlineEmpForm").modal('show');
    $("#nomtipogasto").val(nom);
    $("#destipogasto").val(desc);
    $("#Addtipogastos").attr('editartipogasto', 'SI')
    $("#Addtipogastos").attr('idtipogasto', id)
}
///////////function eleminar
function eliminarTipoGas(id) {
    Swal.fire({
        title: 'Está seguro?',
        text: "Se eliminara el tipo gasto definitivamente!",
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
                url: "app/src/ajax/contabilidad/tipo.ajax.php",
                method: "POST",
                data: datos,
                cache: false,
                contentType: false,
                processData: false,
                success: function (respuesta) {
                    $("#smsconfirmations").html(respuesta);///
                    var search = '';
                    selectTipoGas(search);
                }
            });

        }
    })
}