function selectAlmacenPermiso(){
    let tabla = "almacen";
    $.ajax({
        method: "POST",
        url: "app/src/ajax/almacen/select.almacen.ajax.php",
        data: { 'selectAlmacenPermisos': tabla },
        success: function (respuesta) {
            $("#listAlmacenPermiso").html(respuesta);//ingresa mensaje en html
        }
    });
}
$(document).ready(function () {
    selectAlmacenPermiso();
});
function updatePermiso(id,value){
    $.ajax({
        method: "POST",
        url: "app/src/ajax/almacen/select.almacen.ajax.php",
        data: { 'updateIDPermisos': id,
            'updateVauePermisos': value  },
        success: function (respuesta) {
            selectAlmacenPermiso();
            $("#smsconfirmations").html(respuesta);
        }
    });
}

function checkPermisos(string){
    if (document.getElementById(string+"permiso").checked === true) {
        document.getElementById(string+"permiso").checked = false;
        updatePermiso(string,0);
    }else{
        document.getElementById(string+"permiso").checked = true;
        updatePermiso(string, 1);
    }
}

function openreset(id){
    $("#exampleModal").modal('show');
    $("#idbtnreset").attr('iduser',id);
}
$('#idbtnreset').click(function () {
    var data={
        'id': $(this).attr('iduser'),
        'pass': $("#passwordA").val(),
        'reppass': $("#passwordB").val(),
    }
    if (data['pass'] == '' && data['reppass'] == '') { alertify.error('Complete todos los campos *');return}
    if (data['pass'] == data['reppass']){
        $.ajax({
            url: "app/src/ajax/login/login.ajax.php",
            method: "POST",
            data: {'passordrest': data},
            success: function (respuesta) {
                $("#smsconfirmations").html(respuesta);
                $("#passwordA").val('');
                $("#passwordB").val('');
            }
        });
    }else{
        alertify.error('Passwords incorrectas');
    }
})

function getpermisos(id){
    if(id!=1){
        $("#exampleModalPerms").modal('show');
        $("#svepermisos").attr('iduser', id);
        for (let e = 1; e < 8; e++) {
            $("#cbox" + e).prop("checked", false);
            
        }

        $.ajax({
            method: "POST",
            url: "app/src/ajax/config.ajax.php",
            data: { 'selectpers': id },
            success: function (respuesta) {
                
                var params = new String;
                params = respuesta;
                let pars = params.split(' ');
                $("#smsconfirmations").html(respuesta);
                var num= pars.length-1;
                for (let i = 0; i < num; i++) {
                    $("#cbox"+pars[i]).prop("checked", true);
                    
                }

            }
        });
    }
    
}

$('#svepermisos').click(function () {
    var id = $(this).attr('iduser');
    var params=[];
    var checked = [];
    $("input[name='permisos[]']:checked").each(function () {
        checked.push($(this).val());
    });
    if (checked.length == 0) { alertify.error('Sin Permisos');}
    else{
        $.ajax({
            method: "POST",
            url: "app/src/ajax/config.ajax.php",
            data: { 'addPermisos': checked, 'idadmin': id  },
            success: function (respuesta) {
                $("#smsconfirmations").html(respuesta);
            }
        });
    }
});