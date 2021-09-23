function dataReniecDNI(){
    var datos = new FormData();
    var dni = document.getElementById('dniTrabajador').value;
    if(dni!=''){
        datos.append("searchdni", parseInt(dni));
        $.ajax({
            method: "POST",
            url: "app/src/ajax/planillas/DNI.php",
            data: datos,
            cache: false,
            contentType: false,
            processData: false,
            dataType: "json",
            success: function (respuesta) {
                if (respuesta=='error'){

                }else{
                    $('#nombTrabajador').val(respuesta['nombres'])
                    $('#apellTrabajador').val(respuesta['apellidoPaterno'] +' '+ respuesta['apellidoMaterno'])
                }
            }
        });
    }else{
        alertify.error('DNI invalido');
    }
}
/*==============================
SELECT EMPLOYES
===============================*/
function selectAllEmployes(search,st,pg) {
    let pages = {
        "star":st,
        "nitem": pg,
    };
    $.ajax({
        method: "POST",
        url: "app/src/ajax/planillas/select.trabajador.ajax.php",
        data: { 'selectEmployes': pages, 'search': search },
        success: function (respuesta) {
            $("#mostrarTrabajador").html(respuesta);//ingresa mensaje en html
        }
    });
}
/*==============================
SEARCH 
===============================*/
function searchTrabajador() {
    var search = document.getElementById('searchTrabajador').value;
    let pg = parseInt(document.getElementById("idtotal").innerHTML);
    selectAllEmployes(search,0,pg);
    
}
$(document).ready(function () {
    try {
        let pg = parseInt(document.getElementById("rowsemployes").value);
        //let st =parseInt(document.getElementById("rowsemployes").value);
        let search = '';
        selectAllEmployes(search, 0, pg);

        pagination(pg, 1);
    } catch (error) {
        error='';
    }
});
//// crear editar
$('#btnTrabajador').click(function () {
    var employe = [];

    employe.push({
        'id': $(this).attr("idtrabajador"),
        'id_sucursal': document.getElementById("idSucursal").value,
        'nombres': document.getElementById("nombTrabajador").value,
        'apellidos': document.getElementById("apellTrabajador").value,
        'dni': document.getElementById("dniTrabajador").value,
        'telefono': document.getElementById("telfTrabajador").value,
        'email': document.getElementById("emailTrabajador").value,
        'f_nacimiento': document.getElementById("datetimeEnd").value,
        'f_ingreso': document.getElementById("datetimeStart").value,
        'ubigeo': document.getElementById("ubigeo").value,
        'direccion': document.getElementById("direcTrabajador").value,
        'id_area': document.getElementById("idarea").value,
        'id_empleo': document.getElementById("idempleo").value,
        'salario': document.getElementById("salTrabajador").value,
        'sal_hora': document.getElementById("salarioXH").value,
        'editar': $(this).attr("editarTrabajador")
    });
    if (employe[0]['id_sucursal'] == "" || employe[0]['id_sucursal'] == 0) {
        alertify.error('Seleccione una sucursal');
    } else if (employe[0]['ubigeo'] == "" || employe[0]['ubigeo'] == 0){
        alertify.error('Seleccione una direccion ubigeo');
    } else if (employe[0]['nombres'] == "" && employe[0]['apellidos'] == "" && employe[0]['salario'] == "" && employe[0]['sal_hora'] == ""){
        alertify.error('Complete todos los campos *');
    }    else if (employe[0]['id_area'] == 0) {
        alertify.error('Seleccione una areo *');
    } else if (employe[0]['id_empleo'] == 0) {
        alertify.error('Seleccione un empleo *');
    }else{
        $.ajax({
            method: "POST",
            url: "app/src/ajax/planillas/empleado.ajax.php",
            data: { 'addEmpleados': employe[0] },
            success: function (respuesta) {
                var search = '';
                let pg = parseInt(document.getElementById("rowsemployes").value);
                selectAllEmployes(search,0,pg);
                $("#smsconfirmations").html(respuesta);//ingresa mensaje en html
            }
        });
    }
});

function limpiarFormEmploye() {
    $('#addFormTrabajador')[0].reset();
    $('.form-control').find($('option')).attr('selected', false)//deselecciona selects
    document.getElementById('provincia').innerHTML = "";
    document.getElementById('ubigeo').innerHTML = "";
    $("#provincia").html(` <option id="editarProvincia">Seleccione</option>`);//provincia
    $("#ubigeo").html(`<option id="editarDistrito" value="0">Seleccione</option>`);//distrito
    $("#btnTrabajador").attr('editarTrabajador', 'NO')
    $("#btnTrabajador").attr('idtrabajador', '0')
}
////////funcion get data para editar
function editarEmploye(id) {
    let pg = parseInt(document.getElementById("idtotal").innerHTML);

    var datos = new FormData();
    datos.append("editSelectEmploy", pg);
    datos.append("idSelectEmploys", parseInt(id));
    $.ajax({
        url: "app/src/ajax/planillas/select.trabajador.ajax.php",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function (respuesta) {
            limpiarFormEmploye();
            $("#inlineForm").modal('show');
            //add data
            $("#idSucursal option[value='" + respuesta["id_sucursal"] + "']").attr("selected", "selected");
            $("#nombTrabajador").val(respuesta["nombre"]);
            $("#apellTrabajador").val(respuesta["apellidos"]);
            $("#dniTrabajador").val(respuesta["dni"]);
            $("#telfTrabajador").val(respuesta["telf"]);
            $("#emailTrabajador").val(respuesta["email"]);
            $("#datetimeEnd").val(respuesta["birthday"])
            $("#datetimeStart").val(respuesta["f_star"])
            let depa = respuesta["ubigeo"];
            $("#region option[value='" + depa.substr(0, 2) + "0000']").attr("selected", "selected");
            $("#editarProvincia").html(respuesta["provi"]);//provincia
            $("#editarDistrito").html(respuesta["dist"]);//distrito
            $("#editarDistrito").val(respuesta["ubigeo"]);//distrito
            $("#direcTrabajador").val(respuesta["direcc"]);
            $("#idarea option[value='" + respuesta["id_departamento"] + "']").attr("selected", "selected");
            $("#idempleo option[value='" + respuesta["id_empleo"] + "']").attr("selected", "selected");
            $("#salTrabajador").val(respuesta["salario"]);
            $("#salarioXH").val(respuesta["sal_hora"]);
            $("#btnTrabajador").attr('editarTrabajador', 'SI')
            $("#btnTrabajador").attr('idtrabajador', id)
        }
    });
}

///////////function eleminar
function eliminarEmploye(id) {
    Swal.fire({
        title: 'Está seguro?',
        text: "El Empleado se eliminara definitivamente!",
        icon: 'error',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#dd6b55',
        confirmButtonText: 'Si, eliminar!'
    }).then((result) => {
        if (result.isConfirmed) {

            var datos = new FormData();

            datos.append("idEliminarT", id);

            $.ajax({
                url: "app/src/ajax/planillas/empleado.ajax.php",
                method: "POST",
                data: datos,
                cache: false,
                contentType: false,
                processData: false,
                success: function (respuesta) {
                    $("#smsconfirmations").html(respuesta);///
                    var search = '';
                    selectAllEmployes(search,0,10);
                }
            });

        }
    })
}

function rowsemployes(){
    var id = parseInt(document.getElementById("rowsemployes").value);
    pagination(id, 1);
}
function paginationT(pg){
    var id = parseInt(document.getElementById("rowsemployes").value);
    pagination(id, pg);
}
function pagination(id,pg) {
    var all_row = parseInt(document.getElementById("idtotal").innerHTML);
    var start='';
    if (all_row >0){
        var page = pg;
        if (page==1) {
            start = 0;
        } else {
            start = (page - 1) * id;
        }
    }
    var total = Math.ceil(all_row / id)
    let search = '';
    selectAllEmployes(search, start, id);
    if (id >= all_row){
        id = all_row - 1;
        total=1;
    }
    var prev='';
    var now ='';
    var nex = '';
    if(total>=1){
        if (page !=1) {//prev = `<li class="page-item"><a class="page-link" onclick="paginationT(`+ (page - 1)+`)"><span aria-hidden="true">Previous</span></a></li>`;
            prev = `<li class="page-item ">
                          <a class="page-link" onclick="paginationT(`+ (page - 1) +`)">Previous</a>
                        </li>`;
        }else{
            prev = `<li class="page-item disabled">
                          <a class="page-link" href="#" tabindex="-1">Previous</a>
                        </li>`;
        }
        for (let i = 1; i <= total; i++) {
            if (page == i) {
                now += '<li class="page-item active"><a class="page-link" ">'+page+ '</a></a></li>';
            } else {
                now +='<li class="page-item"><a class="page-link" onclick="paginationT('+i+')">'+i+'</a></li>';
            }
        }
        if (page != total) {
            nex = `<li class="page-item ">
                          <a class="page-link" onclick="paginationT(`+ (page + 1) + `)">Next</a>
                        </li>`;
        }else{
            nex = `<li class="page-item disabled">
                          <a class="page-link" href="#" tabindex="-1">Next</a>
                        </li>`;
        }
    }
    var html = prev + now + nex;
    document.getElementById("pagination").innerHTML=html;
}

function salario(price){
    var total = parseFloat($('#salTrabajador').val());
    var res = 0;
    if (total<1){
        $('#salTrabajador').val(parseFloat(0).toFixed(2))
    }
    if (price == -10 && total != 0) {
        let rest = parseInt(price);
        res = total - 10;
    } else {
        let sum = parseFloat(price);
        res = total + sum;
    }

    $('#salTrabajador').val(parseFloat(res).toFixed(2))
}
function salarioXH(price) {
    var total = parseFloat($('#salarioXH').val());
    var res = 0;
    if (total < 1) {
        $('#salarioXH').val(parseFloat(0).toFixed(2))
    }
    if (price == -10 && total != 0) {
        let rest = parseInt(price);
        res = total - 10;
    } else {
        let sum = parseFloat(price);
        res = total + sum;
    }

    $('#salarioXH').val(parseFloat(res).toFixed(2))
}
function pagarEmploye(id){
    // $("#examplePayModal").modal('show');
}