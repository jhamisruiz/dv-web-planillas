
function dataTimeNow() {
    let now = new Date();
    let Y = now.getFullYear();
    let MM = now.getMonth() + 1;
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
$(document).ready(function () {
    let date = dataTimeNow();
    $("#dateStart").val(date['date']);
    searchMes()
});

function asisEmployDNI() {
    $('#btncalcularp').addClass('d-none');
    $('#btncalcularF').addClass('d-none');
    var mes = $('#dateStart').val()
    var dni = $('#buscarXdni').val()
    var sucursal = '';
    if (dni.length == 8) {
        $.ajax({
            method: "POST",
            url: "app/src/ajax/planillas/asistencia.ajax.php",
            data: { 'idEmployes': dni, 'idsucursal': sucursal },
            success: function (respuesta) {
                $("#idemploye").html(respuesta);
                $("#nombreenploy").removeClass('d-none');
            }
        });
        $.ajax({
            method: "POST",
            url: "app/src/ajax/planillas/pagos.ajax.php",
            data: { 'dniEmployes': dni, 'fecha': mes },
            success: function (respuesta) {
                $("#idfaltas").html(respuesta);
                //$("#nombreenploy").removeClass('d-none');
            }
        });
        $.ajax({
            method: "POST",
            url: "app/src/ajax/planillas/pagos.ajax.php",
            data: { 'dniasistencia': dni, 'fechaa': mes },
            success: function (respuesta) {
                $("#idasistencias").html(respuesta);
                //$("#nombreenploy").removeClass('d-none');
            }
        });
        $.ajax({
            method: "POST",
            url: "app/src/ajax/planillas/pagos.ajax.php",
            data: { 'historial': dni,},
            success: function (respuesta) {
                $("#idhistorialpago").html(respuesta);
            }
        });
        $('#btncalcularp').removeClass('d-none');
        $('#btncalcularF').removeClass('d-none');
    }else{
        $("#idemploye").html('Sin datos...');
        $("#idfaltas").html('Sin datos...');
        $("#idasistencias").html('Sin datos...');
        $("#idhistorialpago").html('Sin datos...');
    }
}
function salarioFin(price) {
    var total = parseFloat($('#idpagomes').val());
    var res = 0;
    if (total < 1) {
        $('#idpagomes').val(parseFloat(0).toFixed(2))
    }
    if (price == -10 && total != 0) {
        let rest = parseInt(price);
        res = total - 10;
    } else {
        let sum = parseFloat(price);
        res = total + sum;
    }
    $('#idpagomes').val(parseFloat(res).toFixed(2))
}
function remuneraFin(price,id) {
    var total = parseFloat($('#idremunera').val());
    var res = 0;
    if (total == 0 || total <0 ){
        $('#idnutonfin').attr('disabled',true)
        $('#idremunera').val(parseFloat(0).toFixed(2))
    }else{
        $('#idnutonfin').attr('disabled', false)
    }
    if (price == -10 && total != 0) {
        let rest = parseInt(price);
        res = total - 10;
    } else {
        if (total >= 0 && id == 1) {
            let sum = parseFloat(price);
            res = total + sum;
            $('#idnutonfin').attr('disabled', false)
        }
    }
        $('#idremunera').val(parseFloat(res).toFixed(2))
    
    
}
function calcularPago(){
    $('#idremunera').val(parseFloat(0).toFixed(2));
    $('#comentario').val('')
    $("#calcularModal").modal('show');
    var salary = $("#idsalaryt").val();
    $("#idsalario").val(salary);
    var mes = $('#dateStart').val()
    var dni = $('#buscarXdni').val()
    $.ajax({
        method: "POST",
        url: "app/src/ajax/planillas/pagos.ajax.php",
        data: { 'dniEmpleado': dni, 'fechames': mes },
        success: function (respuesta) {
            console.log(respuesta)
            let salary = parseFloat(respuesta);
            $('#idpagomes').val(salary)
            $('#idcostohora').html($('#idsalhorat').val());
            $('#idhstrabaja').html($('#idtotalhoras').html());
        }
    });
}
/*============================== 
    CREAR/EDITAR
===============================*/
$('#Addpagos').click(function () {
    var data = {
        'dni': $('#buscarXdni').val(),
        'mes': $('#dateStart').val(),
        'salary': $('#idsalario').val(),
        'total_horas': $('#idhstrabaja').html(),
        'precio_hora': $('#idcostohora').html(),
        'total_salary': $('#idpagomes').val(),
        'remunera': $('#idremunera').val(),
        'coment': $('#comentario').val(),
        'id': $(this).attr('idpago'),
        'editar': $(this).attr('editar')

    }
    if (data['total_salary'] == "" || data['total_salary'] == 0 || data['total_salary'] == 0.00) {
        alertify.error('Complete  los campos');
    } else {
        $.ajax({
            method: "POST",
            url: "app/src/ajax/planillas/pagos.ajax.php",
            data: { 'createpagos': data },
            success: function (respuesta) {
                $("#smsconfirmations").html(respuesta);
                asisEmployDNI()
            }
        });
    }

});
function searchMes(){
    var fecha = new String($('#dateStart').val());
    if (fecha.length==10){
        fecha = fecha.substring(0, 7);
    }
    $.ajax({
        method: "POST",
        url: "app/src/ajax/planillas/pagos.ajax.php",
        data: { 'historial': fecha, },
        success: function (respuesta) {
            $("#verhistorypagos").html(respuesta);
            $('#idnonehis').addClass('d-none')
        }
    });
}

function exelreportes(){
    let mes = $('#dateStart').val()
    let url = "/planillas/detalle-reporte-exel/" + mes;
    javascript: window.open(url, '_blank');
}
function exelreportesCont() {
    let mes = $('#dateStart').val()
    let dni = $('#buscarXdni').val()
    let url = "/planillas/detalle-reporte-pdf/" + mes + "/" + dni+"/expor-file-pdf";
    javascript: window.open(url, '_blank');
}