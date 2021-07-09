
$("#idcheckSucursal").on('change', function () {
    var dn =document.getElementById("sucuarlPrincipal");
    var db = document.getElementById("sucuarlTemporal");
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
CREAR PRODUCTO
===============================*/
 $('#btnGuardarAlmacen').click(function () {

    var almacen =[];
    $("input[name='addAlmacen']").each(function() {
      almacen.push(this.value);
    });
    almacen.push(document.getElementById("ubigeo").value);
    almacen.push(document.getElementById("addDescripcion").value);
     console.log(almacen);
    /* if (almacen[1]!="" && almacen[2]!="" && almacen[3]!="" ) {
        
        if (almacen[0]!="") {

            $.ajax({
                method: "POST",
                url:"app/src/ajax/almacen/almacen.ajax.php",
                data: {'addAlmacen': almacen},
                success: function(respuesta){

                $("#smsconfirmations").html(respuesta);//ingresa mensaje en html
                $("#loadForm").load(" #loadForm");//refresca la tabla

                }
            });

        } else {
            alertify.error('Seleccione una sucursal'); 
        }

    } else {

       alertify.error('Complete todos los campos *'); 

    } */
 });
 //   != diferente de ""