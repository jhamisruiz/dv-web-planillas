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
    CREAR/EDITAR CATEGORIA
===============================*/
$('#AddCategoria').click(function () {
    var categoria = [];

	categoria.push(document.getElementById("nomCategoria").value);
	categoria.push(document.getElementById("desCategoria").value);
	categoria.push($(this).attr("editarCateg"));
	categoria.push($(this).attr("idCategoria"));
    if (categoria[0]!="" &&categoria[1]!="") {
      
      if (categoria[0]!="") {
        $.ajax({
            method: "POST",
            url:"app/src/ajax/almacen/categorias.ajax.php",
            data: {'addCategoria': categoria},
            success: function(respuesta){
				selectAllcategoria();
              	$("#smsconfirmations").html(respuesta);//ingresa mensaje en html]
				if ($('#AddCategoria').attr("editarcateg") == "NO") {
					limpiarForm();
				}
            }
        });
      } else {

        alertify.error('Seleccione una sucursal');
      }
    } else {
      
      alertify.error('Complete todos los campos');
    }
    
});
/* GET Editar categoria */
function limpiarForm(){
	$('#addFormCategorias')[0].reset();
	$("#AddCategoria").attr('editarCateg', 'NO')
	$("#AddCategoria").attr('idCategoria', '0')
}
function editarCategoria(id,nom,desc){
	limpiarForm();
	$("#inlineForm").modal('show');
	$("#nomCategoria").val(nom);
	$("#desCategoria").val(desc);
	$("#AddCategoria").attr('editarCateg', 'SI')
	$("#AddCategoria").attr('idCategoria', id)
}
///////////function eleminar almacen
function eliminarCategoria(id) {
	Swal.fire({
		title: 'Está seguro?',
		text: "La categoria se eliminara definitivamente!",
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
				url: "app/src/ajax/almacen/categorias.ajax.php",
				method: "POST",
				data: datos,
				cache: false,
				contentType: false,
				processData: false,
				success: function (respuesta) {
					$("#smsconfirmations").html(respuesta);///
					selectAllcategoria();
				}
			});

		}
	})
}

/*============================== 
    ACTIVAR CATEGORIAS
===============================*/
$(document).on("click", ".btnActivarCategoria", function () {
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
			var idcategoria = $(this).attr("idcategoria");
			var estadocategorias = $(this).attr("estadocategoria");
			function activar(){
				var resp= "";
				var datos = new FormData();
				datos.append("activarId", idcategoria);
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
					$(this).attr('estadocategoria', 1);

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
					$(this).attr('estadocategoria', 0);
					
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