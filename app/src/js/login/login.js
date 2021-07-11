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