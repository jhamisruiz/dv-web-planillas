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
            $(".selectChangeAlmacen").on('change', function () {
                var idalmacen=$(this).attr('idalmacen');
                var selecttype=$(this);
                var nowtype=selecttype[0].value;
                changeTipo(idalmacen,nowtype);
            });
        }
    });
}

function changeTipo(idalmacen,nowtype){
    $.ajax({
        method: "POST",
        url: "app/src/ajax/almacen/change.tipo.almacen.ajax.php",
        data: { 'idalmacen': idalmacen,'nowtype': nowtype},
        success: function (respuesta) {
            $("#smsconfirmations").html(respuesta);         
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
     
     if (almacen[2] != "" && almacen[6] != "" && almacen[7] != "") {
         if (almacen[6] != "Seleccione"){
             if (almacen[1] != "" && almacen[7] >= "1") {
                $.ajax({
                    method: "POST",
                    url:"app/src/ajax/almacen/almacen.ajax.php",
                    data: {'addAlmacen': almacen},
                    success: function(respuesta){
                        selectAllalmacen();
                        let dn = document.getElementById("sucuarlPrincipal");//formater el swith alamcen temporal
                        let db = document.getElementById("sucuarlTemporal");//formater el swith alamcen temporal
                        dn.classList.remove("d-none");//formater el swith alamcen temporal
                        db.classList.add("d-none");//formater el swith alamcen temporal

                        $("#smsconfirmations").html(respuesta);//ingresa mensaje en html
                        $("#loadForm").load(" #loadForm");//refresca la tabla
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

  
 //   != diferente de ""