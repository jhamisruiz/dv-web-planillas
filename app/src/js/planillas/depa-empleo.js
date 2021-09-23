function selectDepartamentos(search){
    let tabla = "departamento";
    $.ajax({
        method: "POST",
        url: "app/src/ajax/planillas/select.depa.ajax.php",
        data: { 'selectDepartamentos': tabla, 'search': search },
        success: function (respuesta) {
            $("#mostrarDepartamentos").html(respuesta);//ingresa mensaje en html
        }
    });
}
/*==============================
SEARCH DEPAS
===============================*/
function searchDepartamentos() {
    var search = document.getElementById('searchDepartamentos').value;
    selectDepartamentos(search);
}
$(document).ready(function () {
    var search = '';
    selectDepartamentos(search);
});
/*============================== 
    CREAR/EDITAR DEPARTAMENTOS
===============================*/
$('#AddDepartamentos').click(function () {
    var depa = [];
    depa.push({
        'id': $(this).attr("idDepartamento"),
        'nombre': document.getElementById("nomDepartamentos").value,
        'descripcion': document.getElementById("desDepartamentos").value,
        'editar': $(this).attr("editarDepartamentos")
    })
    
    if (depa[0]['nombre'] != "") {
        $.ajax({
            method: "POST",
            url: "app/src/ajax/planillas/depa-empleo.ajax.php",
            data: { 'AddDepartamentos': depa },
            success: function (respuesta) {
                var search = '';
                selectDepartamentos(search);
                $("#smsconfirmations").html(respuesta);//ingresa mensaje en html]
                if ($('#AddDepartamentos').attr("editarDepartamentos") == "NO") {
                    limpiarForm();
                }
            }
        });
    } else {

        alertify.error('Complete  los campos');
    }

});
/* GET Editar DEPA */
function limpiarForm() {
    $('#addFormDepartamentos')[0].reset();
    $("#AddDepartamentos").attr('editarDepartamentos', 'NO')
    $("#AddDepartamentos").attr('idDepartamento', '0')
}
function editarDepartamento(id, nom, desc) {
    limpiarForm();
    $("#inlineForm").modal('show');
    $("#nomDepartamentos").val(nom);
    $("#desDepartamentos").val(desc);
    $("#AddDepartamentos").attr('editarDepartamentos', 'SI')
    $("#AddDepartamentos").attr('idDepartamento', id)
}
///////////function eleminar
function eliminarDepartamento(id) {
    Swal.fire({
        title: 'Está seguro?',
        text: "Se eliminara el departamento definitivamente!",
        icon: 'error',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#dd6b55',
        confirmButtonText: 'Si, eliminar!'
    }).then((result) => {
        if (result.isConfirmed) {
            var datos = new FormData();
            datos.append("idEliminarD", id);
            $.ajax({
                url: "app/src/ajax/planillas/depa-empleo.ajax.php",
                method: "POST",
                data: datos,
                cache: false,
                contentType: false,
                processData: false,
                success: function (respuesta) {
                    $("#smsconfirmations").html(respuesta);///
                    var search = '';
                    selectDepartamentos(search);
                }
            });

        }
    })
}

/* ========================================================== */
            //    EMPLEOS       //
/* ========================================================== */
function selectEmpleos(search) {
    let tabla = "empleo";
    $.ajax({
        method: "POST",
        url: "app/src/ajax/planillas/select.empleo.ajax.php",
        data: { 'selectEmpleo': tabla, 'search': search },
        success: function (respuesta) {
            $("#mostrarEmpleos").html(respuesta);//ingresa mensaje en html
        }
    });
}
/*==============================
SEARCH EMPLEOS
===============================*/
function searchEmpleo() {
    var search = document.getElementById('searchEmpleo').value;
    selectEmpleos(search);
}
$(document).ready(function () {
    var search = '';
    selectEmpleos(search);
});
/*============================== 
    CREAR/EDITAR EMPLEOS
===============================*/
$('#AddEmpleos').click(function () {
    var empleo = [];
    empleo.push({
        'id': $(this).attr("idEmpleo"),
        'nombre': document.getElementById("nomEmpleo").value,
        'descripcion': document.getElementById("desEmpleo").value,
        'editar': $(this).attr("editarEmpleo")
    })

    if (empleo[0]['nombre'] != "") {
        $.ajax({
            method: "POST",
            url: "app/src/ajax/planillas/depa-empleo.ajax.php",
            data: { 'AddEmpleos': empleo },
            success: function (respuesta) {
                var search = '';
                selectEmpleos(search);
                $("#smsconfirmations").html(respuesta);//ingresa mensaje en html]
                if ($('#AddEmpleos').attr("editarEmpleo") == "NO") {
                    limpiarEmpleoForm();
                }
            }
        });
    } else {

        alertify.error('Complete  los campos');
    }

});
/* GET Editar DEPA */
function limpiarEmpleoForm() {
    $('#addFormEmpleo')[0].reset();
    $("#AddEmpleos").attr('editarEmpleo', 'NO')
    $("#AddEmpleos").attr('idEmpleo', '0')
}
function editarEmpleo(id, nom, desc) {
    limpiarEmpleoForm();
    $("#inlineEmpForm").modal('show');
    $("#nomEmpleo").val(nom);
    $("#desEmpleo").val(desc);
    $("#AddEmpleos").attr('editarEmpleo', 'SI')
    $("#AddEmpleos").attr('idEmpleo', id)
}
///////////function eleminar
function eliminarEmpleo(id) {
    Swal.fire({
        title: 'Está seguro?',
        text: "Se eliminara el departamento definitivamente!",
        icon: 'error',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#dd6b55',
        confirmButtonText: 'Si, eliminar!'
    }).then((result) => {
        if (result.isConfirmed) {
            var datos = new FormData();
            datos.append("idEliminarE", id);
            $.ajax({
                url: "app/src/ajax/planillas/depa-empleo.ajax.php",
                method: "POST",
                data: datos,
                cache: false,
                contentType: false,
                processData: false,
                success: function (respuesta) {
                    $("#smsconfirmations").html(respuesta);///
                    var search = '';
                    selectEmpleos(search);
                }
            });

        }
    })
}