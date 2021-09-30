
function dataTimeNowP() {
    var now = new Date();
    let Y = now.getFullYear();
    let MM = now.getMonth() + 1;
    let DD = now.getDate();
    let M = String(MM);
    let D = String(DD);
    if (M.length == 1) { M = '0' + M }
    if (D.length == 1) { D = '0' + D }
    let date = Y + '-' + M + '-' + D;
    var mes = Y + '-' + M + '-01';
    //hora
    let string = String(now);
    let hora = string.split(' ');
    let HH = hora[4]
    return { 'date': date, 
            'hora': HH, 
            'mes': mes,}
}
$(document).ready(function () {
    let date = dataTimeNowP();
    $("#datetimeStart").val(date['mes']);
    $("#datetimeEnd").val(date['date']);
    searchMes()
});

function asisEmployDNI() {
    $('#btncalcularp').addClass('d-none');
    $('#btncalcularF').addClass('d-none');
    var dia1 = $('#datetimeStart').val()
    var dia2 = $('#datetimeEnd').val()
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
            data: { 'dniEmployes': dni, 'fecha1': dia1, 'fecha2': dia2 },
            success: function (respuesta) {
                $("#idfaltas").html(respuesta);
                //$("#nombreenploy").removeClass('d-none');
            }
        });
        $.ajax({
            method: "POST",
            url: "app/src/ajax/planillas/pagos.ajax.php",
            data: { 'dniasistencia': dni, 'fecha1': dia1, 'fecha2': dia2 },
            success: function (respuesta) {
                $("#idasistencias").html(respuesta);
                //$("#nombreenploy").removeClass('d-none');
            }
        });
        let data={
            'dni': dni
        }
        $.ajax({
            method: "POST",
            url: "app/src/ajax/planillas/pagos.ajax.php",
            data: { 'historial': data,},
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
    $("#iddominical").attr("checked", false);
    $('#idrespuestacal').html(`
    <label>Costo h. s/.<strong>
            <l id="idcostohora">0.00</l>
        </strong>
        x<strong>
            <l id="idhstrabaja">00:00</l>
        </strong>Horas T.
    </label>`);
    $('#idremunera').val(parseFloat(0).toFixed(2));
    $('#comentario').val('')
    $("#calcularModal").modal('show');
    var salary = $("#idsalaryt").val();
    $("#idsalario").val(salary);
    var dia1 = $('#datetimeStart').val()
    var dia2 = $('#datetimeEnd').val()
    var dni = $('#buscarXdni').val()
    $.ajax({
        method: "POST",
        url: "app/src/ajax/planillas/pagos.ajax.php",
        data: { 'dniEmpleado': dni, 'fecha1': dia1, 'fecha2': dia2},
        success: function (respuesta) {
            let salary = parseFloat(respuesta.replace(/,/g, ""));
            $('#idpagomes').val(salary)
            if ($('#idtotalhoras').html()=='MES'){
                $('#idrespuestacal').html(`
                PAGO MENSUAL
                <div class="d-none">
                <l id="idhstrabaja">00:00</l>
                <l id="idcostohora">0.00</l>
                </div>
                `);
            }else{
            $('#idcostohora').html($('#idsalhorat').val());
            $('#idhstrabaja').html($('#idtotalhoras').html());}
        }
    });
}
/*============================== 
    CREAR/EDITAR
===============================*/
$('#Addpagos').click(function () {
    let dominic='';
    if (document.getElementById("iddominical").checked === true) {
        dominic = 'SI';
    }else{
        dominic = '';
    }
    var data = {
        'dni': $('#buscarXdni').val(),
        'dia1': $('#datetimeStart').val(),
        'dia2': $('#datetimeEnd').val(),
        'salary': $('#idsalario').val(),
        'total_horas': $('#idhstrabaja').html(),
        'precio_hora': $('#idcostohora').html(),
        'total_salary': $('#idpagomes').val(),
        'remunera': $('#idremunera').val(),
        'coment': $('#comentario').val(),
        'id': $(this).attr('idpago'),
        'dominic': dominic,
        'dias': $('#idnumasist').val(),
        'faltas': $('#idnumfaltas').val(),
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
    let fecha ={
        'dni': 0,
        'dia1': $('#datetimeStart').val(),
        'dia2': $('#datetimeEnd').val()
    }
    $.ajax({
        method: "POST",
        url: "app/src/ajax/planillas/pagos.ajax.php",
        data: { 'historial': fecha,},
        success: function (respuesta) {
            console.log(fecha)
            $("#verhistorypagos").html(respuesta);
            $('#idnonehis').addClass('d-none')
        }
    });
}
///////////function eleminar
function eliminarPago(id){
    Swal.fire({
        title: 'Está seguro?',
        text: "Se Pago se eliminara definitivamente!",
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
                url: "app/src/ajax/planillas/pagos.ajax.php",
                method: "POST",
                data: datos,
                cache: false,
                contentType: false,
                processData: false,
                success: function (respuesta) {
                    $("#smsconfirmations").html(respuesta);///
                    asisEmployDNI()
                }
            });

        }
    })
}
function exelreportes(){
    var dia1 = $('#datetimeStart').val()
    var dia2 = $('#datetimeEnd').val()
    if (dia1 == '' || dia2==''){
        alertify.error('Selecciona una fecha');
    }else{
        let url = "/planillas/detalle-reporte-exel/" + dia1 + '/' + dia2;
        javascript: window.open(url, '_blank');
    }
}
function pdfreportesCont(id,host) {
    let mes = $('#datetimeStart').val()
    let dni = $('#buscarXdni').val()
    let url = "/planillas/detalle-reporte-pdf/" + id + "/" + dni+"/expor-file-pdf";
    javascript: window.open(url, '_blank');
}