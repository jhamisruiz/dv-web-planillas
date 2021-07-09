$("#region").change(function(){
    $("#ubigeo").html("");
    var parametros= "id="+$("#region").val();
    $.ajax({
       data:  parametros,
       url:   'app/src/ajax/ubigeo.ajax.php',
       type:  'post',
       beforeSend: function () { },
       success:  function (response) {  
                        	
           $("#provincia").html(response);
       },
       error:function(){
           alertify.error('error');
       }
   });
})

$("#provincia").change(function(){
    var parametros= "idp="+$("#provincia").val();
    $.ajax({
       data:  parametros,
       url:   'app/src/ajax/ubigeo.ajax.php',
       type:  'post',
       beforeSend: function () { },
       success:  function (data) {  
                         	
           $("#ubigeo").html(data);
       },
       error:function(){
           alertify.error('error');
       }
   });
})