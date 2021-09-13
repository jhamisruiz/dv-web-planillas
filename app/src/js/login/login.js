$(document).on("click", ".btnActivaAdmin", function () {
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

            var response = "";

            var idusuario = $(this).attr("idadmin");
            var estadoadmin = $(this).attr("estadoadmin");

            function activar() {
                var resp = "";

                var datos = new FormData();

                datos.append("activarId", idusuario);
                datos.append("estadoadmin", estadoadmin);

                $.ajax({

                    url: "app/src/ajax/login/login.ajax.php",
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
            if (estadoadmin == 0) {
                if (response == "ok") {

                    $(this).removeClass('btn-success');
                    $(this).addClass('btn-danger');
                    $(this).html('Desactivado');
                    $(this).attr('estadoadmin', 1);

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
                    $(this).attr('estadoadmin', 0);

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

$('.btnRegistro').click(function () {

    var registro = [];

    $("input[name='userRegistro']").each(function () {
        registro.push(this.value);
    });
    if (registro[1] != registro[2]) {
        $("#resLogin").html('Las contraseñas no son iguales');
    } else {
        $.ajax({
            method: "POST",
            url: "app/src/ajax/login/login.ajax.php",
            data: { 'userRegistro': registro },
            success: function (respuesta) {
                if (respuesta == 'Usuario Registrado'){
                    $("#resLogin").html('');
                    $("#resRegistro").html(respuesta);
                }else{
                    $("#resLogin").html(respuesta);//ingresa mensaje en html
                }
            }
        });
    }
});


$('.btnLogin').click(function () {
    
    var login =[];

    $("input[name='loginUsuario']").each(function () {
        login.push(this.value);
    });
    $.ajax({
        method: "POST",
        url: "app/src/ajax/login/login.ajax.php",
        data: { 'usuerLogin': login },
        success: function (respuesta) {
            console.log(respuesta);
            $("#resLogin").html(respuesta);//ingresa mensaje en html
        }
    });

});

///////////function eleminar admin
function eliminarAdmin(id) {
    Swal.fire({
        title: 'Está seguro?',
        text: "El usuario se eliminara definitivamente!",
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
                url: "app/src/ajax/login/login.ajax.php",
                method: "POST",
                data: datos,
                cache: false,
                contentType: false,
                processData: false,
                success: function (respuesta) {
                    console.log(respuesta)
                    $('#idrow'+id).addClass('d-none');
                    $("#smsconfirmations").html(respuesta);///
                }
            });

        }
    })
}