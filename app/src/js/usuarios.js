
/*============================== 
    ACTIVAR USUARIOS
===============================*/
$(document).on("click", ".btnActivarUsuarios", function () {

    Swal.fire({
    	title: 'Está seguro?',
    	text: "El estado de el usuario cambiara!",
    	icon: 'warning',
    	showCancelButton: true,
    	confirmButtonColor: '#28a745',
    	cancelButtonColor: '#d33',
		confirmButtonText: 'Si, cambiar!',
		cancelButtonText: 'Cancelar'
    }).then((result) => {
    	if (result.isConfirmed) {

			var response="";
			
			var idusuario = $(this).attr("idusuarios");
			var estadousuario = $(this).attr("estadousuarios");

			function activar(){
				var resp= "";

				var datos = new FormData();

				datos.append("activarId", idusuario);
				datos.append("estadoUsuario", estadousuario);

				$.ajax({

					url: "app/src/ajax/usuarios.ajax.php",
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
			if (estadousuario == 0) {
				if(response=="ok"){

					$(this).removeClass('btn-success');
					$(this).addClass('btn-danger');
					$(this).html('Desactivado');
					$(this).attr('estadousuarios', 1);

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
					$(this).attr('estadousuarios', 0);
					
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