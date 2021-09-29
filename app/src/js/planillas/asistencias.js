function dataTimeNow() {
    let now = new Date();
    let Y = now.getFullYear();
    let MM = now.getMonth()+1;
    let DD = now.getDate();
    let M = String(MM);
    let D = String(DD);
    if (M.length == 1) { M = '0' + M }
    if (D.length == 1) { D = '0' + D }
    let date = Y + '-' + M + '-' + D;
    //hora
    let string = String(now);
    let hora = string.split(' ');
    let HH = hora[4]
    return { 'date': date, 'hora': HH, }
}

function buscarEmployDNI(){
    var dni = $('#buscarXdni').val()
    var sucursal='';
    if(dni.length==8){
        $.ajax({
            method: "POST",
            url: "app/src/ajax/planillas/asistencia.ajax.php",
            data: { 'idEmployes': dni, 'idsucursal': sucursal },
            success: function (respuesta) {
                $("#mostrarEmployAsis").html(respuesta);//ingresa mensaje en html
            }
        });
    }
    //alertify.error('El DNI ingresado es incorrecto *');
}
function asistEmploye(id) {
    let date = dataTimeNow();
    $("#examplePayModal").modal('show');

    $("#datetimeStart").val(date['date']);
    $("#timeStar").val(date['hora']);
    onchangeDate()
}
$(document).on("click", ".asistencia", function () {
    var hora='';
    if ($(this).attr("asistencia") == 'ENTRADA' || $(this).attr("asistencia") == 'FALTA'){
        hora = $('#timeStar').val();
    }else{
        if ($('#timeStarDos').val()==''){
            alertify.error('Ingresa hora salida*');
            exit()
        }
        hora = $('#timeStarDos').val();
    }
    var data= {
        "asist": $(this).attr("asistencia"),
        "hora": hora,
        "fecha": $('#datetimeStart').val(),
        "dni": $('#idemploy').val(),
    }
    $.ajax({
        method: "POST",
        url: "app/src/ajax/planillas/asistencia.ajax.php",
        data: { 'addAsistencia': data },
        success: function (respuesta) {
            $("#smsconfirmations").html(respuesta);//ingresa mensaje en html]
            onchangeDate2()
        }
    });
});

function onchangeDate(){
    var fecha = $('#datetimeStart').val();
    var dni=$('#idemploy').val();
    var datos = new FormData();
    datos.append("selecporfecha", fecha);
    datos.append("dni", parseInt(dni));
    $.ajax({
        url: "app/src/ajax/planillas/asistencia.ajax.php",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function (respuesta) {
            if (respuesta['entrada']=='ENTRADA') {
                $('#entrada').removeClass('btn-outline-success')
                $('#entrada').addClass('bg-success text-white')
                $('#falta').removeClass('bg-danger text-white')
                $('#falta').addClass('btn-outline-danger')
                $('#timeStarDos').val('');
                $('#horaentrada').html(respuesta['hora_entrada']);
                $('#eliminarasistencia').removeClass('d-none')
                $('#horastotal').html('00:00');
                $('#horastotal').removeClass('text-danger');
            }

            if (respuesta['asistencia'] == 'FALTA') {
                $('#entrada').removeClass('bg-success text-white')
                $('#entrada').addClass('btn-outline-success')
                $('#horaentrada').html('00:00');
                $('#falta').removeClass('btn-outline-danger')
                $('#falta').addClass('bg-danger text-white')
                $('#salida').removeClass('bg-warning text-dark')
                $('#salida').addClass('btn-outline-warning')
                $('#horasalida').html('00:00');
                $('#timeStarDos').val('');
                $('#horastotal').html('Registro Falta');
                $('#horastotal').addClass('text-danger');
                $('#eliminarasistencia').removeClass('d-none')
            }
            if (respuesta['salida'] == 'SALIDA') {
                $('#salida').removeClass('btn-outline-warning')
                $('#salida').addClass('bg-warning text-dark')
                $('#horasalida').html(respuesta['hora_salida']);
                $('#timeStarDos').val(respuesta['hora_salida']);
                $('#horastotal').html(respuesta['total_horas']);
                $('#eliminarasistencia').removeClass('d-none');
                $('#horastotal').removeClass('text-danger');
            }

        }
    });
    
}
function onchangeDate2() {
    $('#entrada').removeClass('bg-success text-white')
    $('#entrada').addClass('btn-outline-success')
    $('#horaentrada').html('00:00');
    $('#falta').removeClass('bg-danger text-white')
    $('#falta').addClass('btn-outline-danger')
    $('#salida').removeClass('bg-warning text-dark')
    $('#salida').addClass('btn-outline-warning')
    $('#eliminarasistencia').addClass('d-none')
    $('#horasalida').html('00:00');
    for (let i = 0; i < 1; i++) {
        setTimeout(onchangeDate, 50);
        i = i + 1;
    }
}

//eliminar asistencia
function eliminarasistencia(){
    var fecha = $('#datetimeStart').val();
    var dni = $('#idemploy').val();
    var datos = new FormData();
    datos.append("idEliminar", dni);
    datos.append("fecha", fecha);
    $.ajax({
        url: "app/src/ajax/planillas/asistencia.ajax.php",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        success: function (respuesta) {
            // console.log(respuesta);
            $("#smsconfirmations").html(respuesta);///

            $('#entrada').removeClass('bg-success text-white')
            $('#entrada').addClass('btn-outline-success')
            $('#falta').removeClass('bg-danger text-white')
            $('#falta').addClass('btn-outline-danger')
            $('#salida').removeClass('bg-warning text-dark')
            $('#salida').addClass('btn-outline-warning')
            $('#horasalida').html('00:00');
            $('#horastotal').html('00:00');
            $('#horaentrada').html('00:00');
            $('#eliminarasistencia').addClass('d-none')
        }
    });
}