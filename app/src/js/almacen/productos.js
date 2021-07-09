
var app = angular.module('live_search_app', []);
    app.controller('live_search_controller',['$scope','$http', function($scope, $http) {

        $scope.Almacens=[{"id":"1","nombre":"almac Trujillo centro"},{"id":"2","nombre":"almacen victor larco"}];
        $scope.select_prods="";
        
        $scope.fetchProds = function() {
            $http({
                method: "POST",
                url: "app/src/ng/almacen/productos.ng.php",
                data: {
                    search_prods: $scope.search_prods,
                    id_almacen: $scope.select_prods,
                    
                }
            }).success(function(data) {
                console.log(data);
                $scope.sortBy = "";
                $scope.reverse = false;

                $scope.selectProds = data;
            });
        };
        $scope.fetchAlmacen=function(){
            $http({
                method: "POST",
                url: "app/src/ng/almacen/productos.ng.php",
                data: {
                    select_prods: $scope.select_prods
                }
            }).success(function(data) {
                console.log(data);
                $scope.sortBy = "";
                $scope.reverse = false;

                $scope.selectProds = data;
            });
        };
        $scope.select_prods="1";
    }]);

$(document).ready(function(){
    var idalmacen= $("#onloadAlmacen").val();
    if (idalmacen!=""&&idalmacen>0){
        $.ajax({
            url:"app/src/ajax/almacen/producto.ajax.php",
            method: "POST",
            data: {selectIdAlmProds:idalmacen},
            success: function(resproducts){
                //document.getElementById("idTableProds").innerHTML=resproducts;
            }
        });
    }    
});

function onSumaCantProd(){
    var total = 0;
    var cant = document.getElementById("idCantProd").value;
        if (cant==""|| cant<0) {cant=0;}
    var ini = document.getElementById("montoactual").value;
        if (ini==""|| ini<0) {ini=0;}
    let tot1= parseInt(cant);
    let tot2 =  parseInt(ini);
    total = tot1+tot2;
    document.getElementById("idCantactDep").value=total;
}
function onchangeAlmacenProds(){
    var idalmacen= $("#onloadAlmacen").val();
    if (idalmacen!=""&&idalmacen>0) {
        $.ajax({
            url:"app/src/ajax/almacen/producto.ajax.php",
            method: "POST",
            data: {selectIdAlmProds:idalmacen},
            success: function(resproducts){
                //document.getElementById("idTableProds").innerHTML="";
                //document.getElementById("idTableProds").innerHTML=resproducts;
            }
        });
    }
}
function delateImgAvatar(){
    document.getElementById("imgProducto").innerHTML="";
    document.getElementById("cargarImg").value="";
}
function mostrarImg(){
    let html = `
        <img id="imgProd" src="https://studio105art.com/files/2014/04/framing.png?w=316&h=316&a=t" class="img-thumbnail img-fluid" alt="">
            <span class="product-remove" onclick="delateImgAvatar()" title="remove"><i class="fa fa-close"></i></span>`;
    document.getElementById("imgProducto").innerHTML=html;
    var archivo = document.getElementById("cargarImg").files[0];
    var reader = new FileReader();
    reader.readAsDataURL(archivo );
        reader.onloadend = function () {
        document.getElementById("imgProd").src = reader.result;
        }
}
function ocDepositoAlm(){
    var idalmacen= $("#addAlmacenProd").val();
    if (idalmacen!=""&&idalmacen>0) {
        $.ajax({
            url:"app/src/ajax/almacen/producto.ajax.php",
            method: "POST",
            data: {depositosXalmacen:idalmacen},
            success: function(depositors){
                document.getElementById("idDepositoprod").innerHTML="";
                document.getElementById("idDepositoprod").innerHTML=depositors;
                $("#idaddDeposito").val("0");
                $("#idNombreDp").val("");
                $("#idTipoDep").val("");
                $("#montoactual").val("0");
                $("#idCantmaxDep").val("");
                $("#idDescripDep").val("");
                $("#idCantactDep").val("");
            }
        });
    } 
}
function mostrarDep(){
    function sumaT(){
        var total = 0;
        var cant = document.getElementById("idCantProd").value;
        if (cant==""|| cant<0) {cant=0;}
        var ini = document.getElementById("montoactual").value;
        if (ini==""|| ini<0) {ini=0;}
        let tot1= parseInt(cant);
        let tot2 =  parseInt(ini);
        total = tot1+tot2;
        return total;
    }
    var iddepo= $("#idDepositoprod").val();
    var datos = new FormData();
    datos.append("idDepositSelect", iddepo);
    if (iddepo!=""&&iddepo>0) {
        $.ajax({
            url:"app/src/ajax/almacen/producto.ajax.php",
            method: "POST",
            data: datos,
            cache: false,
            contentType: false,
            processData: false,
            dataType: "json",
            success: function(respuesta){
                $("#idaddDeposito").val(respuesta["id"]);
				$("#idNombreDp").val(respuesta["dep"]);
				$("#idTipoDep").val(respuesta["tipo"]);
				$("#montoactual").val(respuesta["cant_act"]);
                $("#idCantactDep").val(respuesta["cant_act"]);
                $("#idCantmaxDep").val(respuesta["cant_max"]);
                $("#idDescripDep").val(respuesta["descrip"]);
                document.getElementById("idCantactDep").value=sumaT();
            }
        })
    }else{
        $("#idaddDeposito").val("0");
		$("#idNombreDp").val("");
		$("#idTipoDep").val("");
        $("#montoactual").val("0");
        $("#idCantmaxDep").val("");
        $("#idDescripDep").val("");
        document.getElementById("idCantactDep").value=sumaT();
    }
    
}

$("#btnGuardarProducto").click(function() {

    var producto =[];
    var deposito =[];

    /* array add producto */
    var almacen= $("#addAlmacenProd").val();
    producto.unshift(almacen);
    
    $("input[name='addProducto']").each(function() {
      producto.push(this.value);
    });

    var categoria= $("#addCatProd").val();
    producto.splice(2, 0,categoria);
    producto.push(document.getElementById("addProdDescrip").value);
    if( $('#idRecordar').is(':checked') ) {
         producto.push("1");
    }else{
        producto.push("0");
    }
    var nomalmacen= $('select[name="selectalmacen"] option:selected').text();
    producto.push(nomalmacen);
    /* array add producto */
    $("input[name='addDeposito']").each(function() {
      deposito.push(this.value);
    });

    var image = document.getElementById('cargarImg').files;
    var imageFile = $('#cargarImg').val();
    var files = $("#cargarImg")[0].files[0];
    if(image.length ==0 && imageFile==""){
        files="0";
    }
    
    var formProd = new FormData();
    formProd.append('addProducts',producto);
    formProd.append('imageFile',files);
    formProd.append('addidDeposit',deposito);

    if (producto[0]!=""&&producto[1]!=""&&producto[3]!=""&&producto[4]!="") {
        if (producto[0]!="") {
            if (producto[2]!="") {
                $.ajax({
                    url:"app/src/ajax/almacen/producto.ajax.php",
                    method: "POST",
                    data : formProd,
                    contentType: false,
                    processData: false,
                    success: function (respuesta) {
                        $("#smsconfirmations").html(respuesta);//ingresa mensaje en html
                        document.getElementById("imgProducto").innerHTML="";

                        var idalmacen= $("#onloadAlmacen").val();
                        $.ajax({
                            url:"app/src/ajax/almacen/producto.ajax.php",
                            method: "POST",
                            data: {selectIdAlmProds:producto[0]},
                            success: function(resproducts){
                                //document.getElementById("idTableProds").innerHTML="";
                                //document.getElementById("idTableProds").innerHTML=resproducts;
                                $("#"+producto[0]+"alm").attr("selected","selected");
                            }
                        });
                    }
                });
                
            } else {
                alertify.error('Seleccione una categoria');
            }
        } else {
            alertify.error('Seleccione un Almacén');
        }
    } else {
        alertify.error('Complete todos los campos');
    }
    
});