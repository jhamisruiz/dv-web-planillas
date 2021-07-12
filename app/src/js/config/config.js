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