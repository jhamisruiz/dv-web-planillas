
function selectAllproductos(search) {
    var idalmacen = $("#onloadAlmacen").val();
    if (idalmacen != "" && idalmacen >= 0) {
        $.ajax({
            method: "POST",
            url: "app/src/ajax/almacen/select.productos.ajax.php",
            data: { 'selectProductos': idalmacen, 'search': search },
            success: function (respuesta) {
                $("#mostrarProductos").html(respuesta);//ingresa mensaje en html
            }
        });
    }
}
/*==============================
SEARCH PRODUCTOS
===============================*/
function searchProducto() {
    $('#smsearch').html('')
    $('#allsearch').removeClass('border-danger');
    $('#allsearch').addClass('border-primary');
    var search = document.getElementById('searchProducto').value;
    var idalmacen = $("#onloadAlmacen").val();
    if (idalmacen == "" || idalmacen == 0){
        $('#allsearch').removeClass('border-primary');
        $('#allsearch').addClass('border-danger');
        $('#smsearch').html('Seleccione un Almacén')
    }else{
        selectAllproductos(search);
    }
}

$(document).ready(function(){
    var search = '';
    selectAllproductos(search);
    selectMarcaProducto();
});
function AlmacenProds() {
    var search = '';
    selectAllproductos(search);
}

function onSumaCantProd(){
    var total = 0;
    var cant = document.getElementById("idCantProd").value;
        if (cant==""|| cant<0) {cant=0;}
    var ini = document.getElementById("montoactual").value;
        if (ini==""|| ini<0) {ini=0;}
    let tot1= parseInt(cant);
    let tot2 =  parseInt(ini);
    total = tot1+tot2;
    document.getElementById("idCantactDep").value=total;
    let cantMax = document.getElementById("idCantmaxDep").value;
    let inv = document.getElementById("idCantmaxDep");
    inv.classList.remove("is-invalid");
    if (cantMax === "") { cantMax=0;}
    let a = parseInt(cant);
    let b = parseInt(cantMax);
    if (a > b) {
        inv.classList.add("is-invalid");
    }else{
        inv.classList.remove("is-invalid");
    }
}
//validar capasidad minima y maxima
function validmaxima(){
    let mx = document.getElementById("idCantmaxDep");
    let min = document.getElementById("idCantactDep").value;
    let max = document.getElementById("idCantmaxDep").value;
    if (max === "") { max = 0; }
    let a = parseInt(min);
    let b = parseInt(max);
    if (a > b) {
        mx.classList.add("is-invalid");
    } else {
        mx.classList.remove("is-invalid");
    }
}

function delateImgAvatar(){
    document.getElementById("imgProducto").innerHTML="";
    document.getElementById("cargarImg").value="";
    $("#ingresarImagen").val('SI');
    $('#imagenProdF').removeClass('d-none');
}
//mostrar imagen
function mostrarImg(){
    let html = `
        <img id="imgProd" src="https://studio105art.com/files/2014/04/framing.png?w=316&h=316&a=t" class="img-thumbnail img-fluid" alt="">
        <span class="product-remove" onclick="delateImgAvatar()" title="remove"><i class="bi bi-trash text-danger"></i></span>
        `;
    document.getElementById("imgProducto").innerHTML=html;
    var archivo = document.getElementById("cargarImg").files[0];
    var reader = new FileReader();
    reader.readAsDataURL(archivo );
        reader.onloadend = function () {
        document.getElementById("imgProd").src = reader.result;
        }
}
//mostrar deposito
function mostrarDep(){
    function sumaT(){
        var total = 0;
        var cant = document.getElementById("idCantProd").value;
        if (cant==""|| cant<0) {cant=0;}
        var ini = document.getElementById("montoactual").value;
        if (ini==""|| ini<0) {ini=0;}
        let tot1= parseInt(cant);
        let tot2 =  parseInt(ini);
        total = tot1+tot2;
        return total;
    }
    var iddepo= $("#idDepositoprod").val();
    var datos = new FormData();
    datos.append("idDepositSelect", iddepo);
    if (iddepo!=""&&iddepo>0) {
        $.ajax({
            url:"app/src/ajax/almacen/producto.ajax.php",
            method: "POST",
            data: datos,
            cache: false,
            contentType: false,
            processData: false,
            dataType: "json",
            success: function(respuesta){
                $("#idaddDeposito").val(respuesta["id"]);
				$("#idNombreDp").val(respuesta["dep"]);
				$("#idTipoDep").val(respuesta["tipo"]);
				$("#montoactual").val(respuesta["cant_act"]);
                $("#idCantactDep").val(respuesta["cant_act"]);
                $("#idCantmaxDep").val(respuesta["cant_max"]);
                $("#idDescripDep").val(respuesta["descrip"]);
                document.getElementById("idCantactDep").value=sumaT();
            }
        })
    }else{
        $("#idaddDeposito").val("0");
		$("#idNombreDp").val("");
		$("#idTipoDep").val("");
        $("#montoactual").val("0");
        $("#idCantmaxDep").val("");
        $("#idDescripDep").val("");
        document.getElementById("idCantactDep").value=sumaT();
    }
    
}

function ocDepositoAlm(id) {
    var response = "";
    var idalmacen = "";
    if(id==0){
        idalmacen = $("#addAlmacenProd").val();
    }else{
        idalmacen=id;
    }
    function  respuestaDepo(){
        var resp = "";
        if (idalmacen != "" && idalmacen > 0) {
            $.ajax({
                url: "app/src/ajax/almacen/producto.ajax.php",
                method: "POST",
                data: { depositosXalmacen: idalmacen },
                async: false,
                success: function (depositors) {
                    resp = depositors;
                }
            });
        }
        return resp;
    }
    response = respuestaDepo();
    $("#idDepositoprod").html(response);
    if (id == 0) {
        $("#idaddDeposito").val("0");
        $("#idNombreDp").val("");
        $("#idTipoDep").val("");
        $("#montoactual").val("0");
        $("#idCantmaxDep").val("");
        $("#idDescripDep").val("");
        $("#idCantactDep").val("");
    }

    if (id == 0){
    $("#onloadAlmacen").find('option:selected').removeAttr("selected");
    $("#onloadAlmacen option[value='"+idalmacen+"']").attr("selected", "selected");
        var search = '';
        selectAllproductos(search);}
}

//select marca producto
function selectMarcaProducto(){
    let table ="marca";
    $.ajax({
        method: "POST",
        url: "app/src/ajax/almacen/select.productos.ajax.php",
        data: { 'selectMarca': table },
        success: function (respuesta) {
            $("#marcaProducto").html(respuesta);//ingresa mensaje en html
        }
    });
}

function addMarcaValue(value,id){
    document.getElementById("idMarcaProd").value = id;
    document.getElementById('addMarcaProd').value = value;
}
function limpiarIDmarca(){
    document.getElementById("idMarcaProd").value="0";
}
function agregardeposito() {
    if (document.getElementById('depositoSI').checked) {
        document.getElementById('depositoSI').value = "SI";
        $('#secciondeposito').removeClass('d-none');
    } else {
        $('#secciondeposito').addClass('d-none');
        document.getElementById('depositoSI').value = "NO";
    }
}

/// GUARDAR EDITAR /
$("#btnGuardarProducto").click(function () {
    selectMarcaProducto();
    var producto =[];
    var deposito =[];
    /* array add producto */
    var nomalmcc = $('select[name="selectalmacen"] option:selected').text();
    var nomalmc = nomalmcc.split('-');
    producto.push({ 
        editProd: $(this).attr("editarProd"),
        ingresarImagen: $("#ingresarImagen").val(),
        idimagen: $("#idImagen").val(),
        idalmacen: $("#addAlmacenProd").val(),
        nombreAlm: nomalmc[0],
        idProd: $("#idproducto").val(),
        nombreProd: $("#nombreProd").val(),
        idcategory: $("#addCatProd").val(),
        cantidad: $("#idCantProd").val(),
        condicion: $("#addCondicion").val(),
        idunidad: $("#idUnidadMed").val(),
        unidadmed: $("#unimedidaProd").val(),
        abrevSunat: $("#abrevSunat").val(),
        fechaingreso: $("#datetimeStart").val(),
        fechavenci: $("#datetimeEnd").val(),
        idmarca: $("#idMarcaProd").val(),
        nombremarca: $("#addMarcaProd").val(),
        descrip: $("#addProdDescrip").val(),
    });

    deposito.push({
        deposito: $("#depositoSI").val(),
        id: $("#idaddDeposito").val(),
        nombre: $("#idNombreDp").val(),
        tipo: $("#idTipoDep").val(),
        cantActual: $("#idCantactDep").val(),
        capaciMax: $("#idCantmaxDep").val(),
        descrip: $("#idDescripDep").val(),
    });

    var image = document.getElementById('cargarImg').files;
    var imageFile = $('#cargarImg').val();
    var files = $("#cargarImg")[0].files[0];
    if(image.length ==0 && imageFile==""){
        files="0";
    }

    if (producto[0]['idalmacen'] < "1"){alertify.error('Seleccione un Almacén');
    }else if (producto[0]['nombreProd'] == "") {alertify.error('Ingresa un nombre');
    } else if (producto[0]['idcategory'] == "" || producto[0]['idcategory'] < "1"){ alertify.error('Seleccione una categoria');
    } else if (producto[0]['cantidad'] == "" || producto[0]['cantidad'] < 1){alertify.error('Ingresa cantidad');
    } else if (producto[0]['unidadmed'] == ""){alertify.error('Ingresa unidad medida');
    } else if (producto[0]['fechaingreso'] == "") {alertify.error('Ingresa una fecha');
    } else if (producto[0]['nombremarca'] == "") {alertify.error('Ingresa una marca');
    }else{
        if (deposito[0]['deposito'] == 'SI' && deposito[0]['nombre'] == '' && deposito[0]['cantActual'] == '' && deposito[0]['capaciMax'] == ''){
            alertify.error('Completa todos los campos requeridos');
        }else{
            var formProd = new FormData();
            formProd.append('addProducts', JSON.stringify(producto[0]));
            formProd.append('imageFile', files);
            formProd.append('addidDeposit', JSON.stringify(deposito[0]));
            $.ajax({
                contentType: false,
                data: formProd,
                enctype: 'multipart/form-data',
                processData: false,
                method: "POST",
                url: "app/src/ajax/almacen/producto.ajax.php",
                success: function (respuesta) {
                    var search = '';
                    selectAllproductos(search);
                    $("#smsconfirmations").html(respuesta);//ingresa mensaje en html
                    document.getElementById("imgProducto").innerHTML = "";//limpiar imput imagen
                }
            });
        }
    }
});


/*==============================
    //get data editar Productos
===============================*/
function limpiarFormProd(id) {
    if (id==0){
        $("#addFormProdualm").load(" #addFormProdualm");
        $("#btnGuardarProducto").attr('editarProd', 'NO')
        $('#secciondeposito').addClass('d-none');
        $("#idDepositoprod").html(`<option value="0">Crear Nuevo Deposito</option>`);
    }else{
    }
    $('#addFormProductos')[0].reset();
    $("#idproducto").val('NO');
    $("#idImagen").val('0');//
    $("#imgProducto").html(``);
    $("#inlineForm").modal('show');
    $("#addAlmacenProd").attr('disabled', false)
    $('#addAlmacenProd').find($('option')).attr('selected', false)
    $('#addCatProd').find($('option')).attr('selected', false)
    $('#idDepositoprod').find($('option')).attr('selected', false)
    $('#imagenProdF').removeClass('d-none');
    $("#ingresarImagen").val('SI');
    document.getElementById('depositoSI').value = "NO";
    $("#depositoSI").attr('checked', false)
    document.getElementById('idUnidadMed').value = "NO";
}
function editarProducto(id){
    $("#btnGuardarProducto").attr('editarProd', 'SI')
    limpiarFormProd(1);
    var datos = new FormData();
    datos.append("idSelectEditar", parseInt(id));
    $.ajax({
        url: "app/src/ajax/almacen/select.productos.ajax.php",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function (respuesta) {
            $("#addAlmacenProd option[value='" + respuesta['Aid']+ "']").attr("selected", "selected");
            $("#addAlmacenProd").attr('disabled', true)
            $("#idselectAlmacen").html('...');

            $("#idproducto").val(id);
            $("#nombreProd").val(respuesta['Pnom']);//nombre

            $("#addCatProd option[value='" + respuesta['idcat'] + "']").attr("selected", "selected");

            $("#idCantProd").val(respuesta['Pcant']);//cantidad

            $("#idUnidadMed").val(respuesta['idunidad']);//id unidad de medida
            $("#unimedidaProd").val(respuesta['Unom']);//
            $("#abrevSunat").val(respuesta['Uasun']);//
            $("#addCondicion option[value='" + respuesta['condicion'] + "']").attr("selected", "selected");
            $("#datetimeStart").val(respuesta['Pfini']);//
            $("#datetimeEnd").val(respuesta['Pfend']);//
            $("#addProdDescrip").val(respuesta['Pdesc']);//

            $("#idMarcaProd").val(respuesta['idmarca']);//
            $("#addMarcaProd").val(respuesta['Nmarca']);//
            
            if (respuesta['Fnom'] =="false"){
                $("#imgProducto").html(`SIN IMAGEN...`);
            }else{
                $("#imgProducto").html(`<img id="imgProd" src="` + respuesta['Fimg'] + `" class="img-thumbnail img-fluid" alt="">
            <span class="product-remove" onclick="delateImgAvatar()" title="remove">
            <i class="bi bi-trash text-danger"></i></span>
            `);$('#imagenProdF').addClass('d-none');
                $("#ingresarImagen").val('NO');
                
            }
            $("#idImagen").val(respuesta['idimg']);//
            /////////deposito
            ocDepositoAlm(respuesta['Aid']);
            $("#idDepositoprod option[value='" + respuesta['iddepo'] + "']").attr("selected", "selected");
            $("#idaddDeposito").val(respuesta['iddepo']);//
            $('#secciondeposito').removeClass('d-none');
            document.getElementById('depositoSI').value = "SI";
            $("#depositoSI").attr('checked', true)
            if (respuesta['Inom'] == null) {
                document.getElementById('depositoSI').value = "NO";
                $('#secciondeposito').addClass('d-none');
                $("#depositoSI").attr('checked', false)}
            $("#idNombreDp").val(respuesta['Inom']);//
            $("#idTipoDep").val(respuesta['tipo']);//
            $("#idCantactDep").val(0);//
            $("#idCantmaxDep").val(respuesta['capMax']);//
            $("#idDescripDep").val(respuesta['idescrip']);//
        }
    });
}
/*==============================
    ACTIVAR ELIMINAR PRODUCTO
===============================*/
function eliminarProducto(id){
    Swal.fire({
        title: 'Está seguro?',
        text: "El producto eliminara definitivamente!",
        icon: 'error',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#dd6b55',
        confirmButtonText: 'Si, eliminar!'
    }).then((result) => {
        if (result.isConfirmed) {

            var datos = new FormData();

            datos.append("idEliminarProd", id);

            $.ajax({
                url: "app/src/ajax/almacen/producto.ajax.php",
                method: "POST",
                data: datos,
                cache: false,
                contentType: false,
                processData: false,
                success: function (respuesta) {
                    console.log(respuesta)
                    console.log(id)
                    $("#smsconfirmations").html(respuesta);///
                    var search = '';
                    selectAllproductos(search);
                }
            });

        }
    })
}
/*============================== 
    ACTIVAR PRODUCTO
===============================*/
$(document).on("click", ".btnActivarProducto", function () {
    Swal.fire({
        title: 'Está seguro?',
        text: "El estado cambiara!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#28a745',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, cambiar!',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            var response = "";
            var idproducto = $(this).attr("idproducto");
            var estadoproducto = $(this).attr("estadoproducto");
            function activar() {
                var resp = "";
                var datos = new FormData();
                datos.append("activarId", idproducto);
                datos.append("estadoproducto", estadoproducto);
                $.ajax({
                    url: "app/src/ajax/almacen/producto.ajax.php",
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
            if (estadoproducto == 0) {
                if (response == "ok") {

                    $(this).removeClass('btn-success');
                    $(this).addClass('btn-danger');
                    $(this).html('Desactivado');
                    $(this).attr('estadoproducto', 1);

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
                    $(this).attr('estadoproducto', 0);

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