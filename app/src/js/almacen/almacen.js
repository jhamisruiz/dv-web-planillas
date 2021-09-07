/*==============================
SELECT ALMACEN
===============================*/
function selectAllalmacen(){
    let tabla="almacen";
    $.ajax({
        method: "POST",
        url: "app/src/ajax/almacen/select.almacen.ajax.php",
        data: { 'selectAlmacen': tabla },
        success: function (respuesta) {
            $("#mostrarAlmacen").html(respuesta);//ingresa mensaje en html
        }
    });
}


$(document).ready(function () {
    selectAllalmacen();
});

$("#idcheckSucursal").on('change', function () {
    let db = document.getElementById("sucuarlTemporal");
    if ($(this).is(':checked')) {
        db.classList.remove("d-none");
    }
    else {;
        db.classList.add("d-none");
        document.getElementById("datetimeEnd").value="";
    }
});
 /*==============================
CREAR ALMACEN
===============================*/
//***************editar almacen 
function limpiarFormAlmacen() {
    $('#addFormAlmacen')[0].reset();
    $("#btnGuardarAlmacen").attr('editaralmacen', 'NO')
    $('.form-control').find($('option')).attr('selected', false)//deselecciona selects
    document.getElementById('provincia').innerHTML="";
    document.getElementById('ubigeo').innerHTML = "";
    $("#provincia").html(` <option id="editarProvincia">Seleccione</option>`);//provincia
    $("#ubigeo").html(`<option id="editarDistrito" value="0">Seleccione</option>`);//distrito
    $("#idcheckSucursal").attr('checked', false)
    let db = document.getElementById("sucuarlTemporal");
    db.classList.add("d-none");
    $("#btnGuardarAlmacen").attr('editaralmacen', 'NO')
    $("#btnGuardarAlmacen").attr('idalmacen', '0')
}
//// crear editar
 $('#btnGuardarAlmacen').click(function () {
     var almacen =[];
    if ($('#idcheckSucursal').is(':checked')){
        almacen.push('TEMPORAL');//0 nombre almacen temporal
        almacen.push(document.getElementById("datetimeEnd").value);//1 fecha caducidad
    }else{
        almacen.push('PRINCIPAL');//0 valor 0 sin nombre
        //1 valor almacen fijo
        almacen.push(document.getElementById("idSucursal").value);
    }
    $("input[name='addAlmacen']").each(function () {
        almacen.push(this.value);
    });
    almacen.push(document.getElementById("addDescripcion").value);
    almacen.push(document.getElementById("ubigeo").value);

    almacen.push(document.getElementById("idSucursal").value);
    almacen.push($(this).attr("editaralmacen"));
    almacen.push($(this).attr("idalmacen"));
     
     if (almacen[2] != "" && almacen[6] != "" && almacen[7] != "") {
         if (almacen[6] != "Seleccione"){
             if (almacen[1] != "" && almacen[7] >= "1") {
                $.ajax({
                    method: "POST",
                    url:"app/src/ajax/almacen/almacen.ajax.php",
                    data: {'addAlmacen': almacen},
                    success: function(respuesta){
                        limpiarFormAlmacen();
                        selectAllalmacen();
                        let dn = document.getElementById("sucuarlPrincipal");//formater el swith alamcen temporal
                        let db = document.getElementById("sucuarlTemporal");//formater el swith alamcen temporal
                        dn.classList.remove("d-none");//formater el swith alamcen temporal
                        db.classList.add("d-none");//formater el swith alamcen temporal

                        $("#smsconfirmations").html(respuesta);//ingresa mensaje en html
                    }
                });

            } else {
                alertify.error('Seleccione una sucursal o Llene una fecha'); 
            }
        }else{
            alertify.error('Complete todos los campos *');
        }

    } else {

       alertify.error('Complete todos los campos *'); 

    }
 });
////////funcion get data para editar
function editarAlmacen(id){
    var datos = new FormData();

    datos.append("idSelectEditar", parseInt(id));
    $.ajax({
        url: "app/src/ajax/almacen/select.almacen.ajax.php",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function (respuesta) {
            limpiarFormAlmacen();
            $("#inlineForm").modal('show');
            //add data
            $("#idSucursal option[value='" + respuesta["sucursal"] + "']").attr("selected", "selected");
            if (respuesta["tipo"] ==='TEMPORAL') {
                let db = document.getElementById("sucuarlTemporal");
                db.classList.remove("d-none");
                $("#datetimeEnd").val(respuesta["fecha"]);
                $("#idcheckSucursal").attr('checked', true)
            }
            $("#nombreAlmacen").val(respuesta["nombre"]);

            let depa = respuesta["ubigeo"];
            $("#region option[value='" + depa.substr(0, 2) +"0000']").attr("selected", "selected");
            $("#editarProvincia").html(respuesta["provi"]);//provincia
            $("#editarDistrito").html(respuesta["dist"]);//distrito
            $("#editarDistrito").val(respuesta["ubigeo"]);//distrito

            $("#direcAlmacen").val(respuesta["direccion"]);
            $("#referAlmacen").val(respuesta["referencia"]);
            $("#addDescripcion").val(respuesta["descrip"]);

            $("#btnGuardarAlmacen").attr('editaralmacen', 'SI')
            $("#btnGuardarAlmacen").attr('idalmacen', id)
        }
    });
}
///////////function eleminar almacen
function eliminarAlmacen(id){
    Swal.fire({
        title: 'Está seguro?',
        text: "El almacén se eliminara definitivamente!",
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
                url: "app/src/ajax/almacen/almacen.ajax.php",
                method: "POST",
                data: datos,
                cache: false,
                contentType: false,
                processData: false,
                success: function (respuesta) {
                    $("#smsconfirmations").html(respuesta);///
                    selectAllalmacen();
                }
            });

        }
    })
}
 // **************ACTIVAR DESACTIVAR ALMACEN***********
$(document).on("click", ".btnActivarAlmacen", function () {

    Swal.fire({
        title: 'Está seguro?',
        text: "El estado almacén cambiara!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#28a745',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, cambiar!',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {

            var response = "";
            var idalmacen = $(this).attr("idalmacen");
            var estadoalmacen = $(this).attr("estadoalmacen");

            function activar() {
                var resp = "";
                var datos = new FormData();

                datos.append("activarId", idalmacen);
                datos.append("estadoAlmacen", estadoalmacen);

                $.ajax({

                    url: "app/src/ajax/almacen/almacen.ajax.php",
                    method: "POST",
                    data: datos,
                    async: false,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function (respuesta) {
                        resp = respuesta;
                    }
                });
                return resp;
            }

            response = activar();
            if (estadoalmacen == 0) {
                if (response == "ok") {

                    $(this).removeClass('btn-success');
                    $(this).addClass('btn-danger');
                    $(this).html('Desactivado');
                    $(this).attr('estadoalmacen', 1);

                    Swal.fire({
                        position: 'middle',
                        icon: 'warning',
                        title: 'El estado se ha desactivado',
                        showConfirmButton: false,
                        timer: 1500
                    })
                } else {
                    alertify.error('Error al cambiar estado');
                }

            } else {
                if (response == "ok") {

                    $(this).addClass('btn-success');
                    $(this).removeClass('btn-danger');
                    $(this).html('Activado');
                    $(this).attr('estadoalmacen', 0);

                    Swal.fire({
                        position: 'middle',
                        icon: 'success',
                        title: 'El estado se ha activado',
                        showConfirmButton: false,
                        timer: 1500
                    })
                } else {
                    alertify.error('Error al cambiar estado');
                }
            }
        }
    });

});