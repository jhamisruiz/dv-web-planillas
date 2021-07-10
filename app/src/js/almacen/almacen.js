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
    let dn =document.getElementById("sucuarlPrincipal");
    let db = document.getElementById("sucuarlTemporal");
    if ($(this).is(':checked')) {
        dn.classList.add("d-none");
        db.classList.remove("d-none");
    }
    else {
        dn.classList.remove("d-none");
        db.classList.add("d-none");
    }
});
 /*==============================
CREAR ALMACEN
===============================*/
 $('#btnGuardarAlmacen').click(function () {
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
     
     if (almacen[2] != "" && almacen[6] != "") {
         if (almacen[6] != "Seleccione"){
            if (almacen[1] != "" ) {
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