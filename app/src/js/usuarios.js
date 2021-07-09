function Password(){

	var pass1 = document.getElementById("password").value;
	var pass2 = document.getElementById("rpassword").value;

	if(pass1==pass2){
		$("#password").removeClass("border border-danger");
		$("#rpassword").removeClass("border border-danger");
	}else{
		$("#password").addClass("border border-danger");
		$("#rpassword").addClass("border border-danger");
	}
}
/*============================== 
    CREAR USUARIOS
===============================*/
$('.addUsuarios').click(function () {

    var usuers = [];
    $("input[name='addUsers']").each(function() {
      usuers.push(this.value);
    });

    if (usuers[2]!="" &&usuers[3]!=""&&usuers[4]!="" &&usuers[5]!="") {
      
      if (usuers[5]==usuers[4]) {
        $.ajax({
            method: "POST",
            url:"app/src/ajax/usuarios.ajax.php",
            data: {'addUsuario': usuers},
            success: function(respuesta){

              $("#smsconfirmations").html(respuesta);
              $("#loadForm").load(" #loadForm");
              /* document.getElementById('addFormUsuarios').reset(); */
            	
            }
        });
      } else {

        alertify.error('Las contraseñas no son iguales');
      }
    } else {
      
      alertify.error('Complete todos los campos');
    }
    
});
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