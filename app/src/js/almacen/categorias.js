function selectAllcategoria() {
	let tabla = "categorias";
	$.ajax({
		method: "POST",
		url: "app/src/ajax/almacen/select.categoria.ajax.php",
		data: { 'selectCategoria': tabla },
		success: function (respuesta) {
			$("#mostrarCategorias").html(respuesta);//ingresa mensaje en html
		}
	});
}
$(document).ready(function () {
	selectAllcategoria();
});
/*============================== 
    CREAR CATEGORIA
===============================*/
$('.AddCategoria').click(function () {
    var categoria = [];

	categoria.push(document.getElementById("nomCategoria").value);
	categoria.push(document.getElementById("desCategoria").value);

    if (categoria[0]!="" &&categoria[1]!="") {
      
      if (categoria[0]!="") {
        $.ajax({
            method: "POST",
            url:"app/src/ajax/almacen/categorias.ajax.php",
            data: {'addCategoria': categoria},
            success: function(respuesta){
				selectAllcategoria();
              $("#smsconfirmations").html(respuesta);//ingresa mensaje en html
            }
        });
      } else {

        alertify.error('Seleccione una sucursal');
      }
    } else {
      
      alertify.error('Complete todos los campos');
    }
    
});
/*============================== 
    ACTIVAR CATEGORIAS
===============================*/
$(document).on("click", ".btnActivarCategorias", function () {

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

			var response="";
			
			var idcategorias = $(this).attr("idcategorias");
			var estadocategorias = $(this).attr("estadocategorias");

			function activar(){
				var resp= "";

				var datos = new FormData();

				datos.append("activarId", idcategorias);
				datos.append("estadoCategoria", estadocategorias);

				$.ajax({

					url: "app/src/ajax/almacen/categorias.ajax.php",
					method: "POST",
					data: datos,
					async:false,
					cache: false,
					contentType: false,
					processData: false,
					success: function (respuesta) {
                        
						resp=respuesta;
					}
				});
				return resp;
			}
			
			response=activar();
			if (estadocategorias == 0) {
				if(response=="ok"){

					$(this).removeClass('btn-success');
					$(this).addClass('btn-danger');
					$(this).html('Desactivado');
					$(this).attr('estadocategorias', 1);

					Swal.fire({ 
						position: 'middle',
						icon: 'warning',
						title: 'El estado se ha desactivado',
						showConfirmButton: false,
						timer: 1500
					})
				}else{
					alertify.error('Error al cambiar estado');
				}
				
			} else {
				if(response=="ok"){

					$(this).addClass('btn-success');
					$(this).removeClass('btn-danger');
					$(this).html('Activado');
					$(this).attr('estadocategorias', 0);
					
					Swal.fire({
						position: 'middle',
						icon: 'success',
						title: 'El estado se ha activado',
						showConfirmButton: false,
						timer: 1500
					})
				}else{
					alertify.error('Error al cambiar estado');
				}
			}
    	}
    });

});