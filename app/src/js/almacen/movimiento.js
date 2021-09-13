function myFMovimiento(){
    $("#resSearchMov").html('');
    limpiarCarro();
}

function buscarProductoAlmacen(){
    var idalmacen = document.getElementById("id-alacen-salida").value;
    var value = document.getElementById("valueSearchProds").value;
    if (idalmacen != "" && parseInt(idalmacen) > 0) {
        $.ajax({
            method: "POST",
            url: "app/src/ajax/almacen/select.productos.ajax.php",
            data: { 'idselectMovProds': idalmacen,
                    'valueMovProds': value },
            success: function (respuesta) {
                $("#resSearchMov").html(respuesta);//ingresa mensaje en html
            }
        });
    }else{
        alertify.error('Seleccione un almacen');
    }
}
/*==========SELECT DETALLE MOVIMIENTO=========== */
function detalleMovimiento(id){

    var head = `<tr>
        <th></th>
        <th>Nro</th>
        <th>Nombre</th>
        <th>Categoria</th>
        <th>Descripcion</th>
        <th>Cantidad</th>
        <th>Condicion</th>
        <th></th>
    </tr>`;
    var idmov = new FormData();
    idmov.append("idMovimiento", id);
    $.ajax({
        method: "POST",
        url: "app/src/ajax/almacen/select.movimiento.ajax.php",
        data: idmov,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function (respuesta) {
            var resp = respuesta[0];
            var html='';
            var exel = '';
            for (let i = 0; i < resp.length; i++) {
                html += `<tr>
                    <th scope="row">`+(i+1)+`</th>
                    <td><img width=30" src="`+ resp[i]['imgUrl'] +`"></td>
                    <td>`+ resp[i]['nombre']+`</td>
                    <td>`+ resp[i]['categoria'] + `</td>
                    <td>`+ resp[i]['descripcion'] +`</td>
                    <td>`+ resp[i]['cantidad']+`</td>
                    <td>`+ resp[i]['condicion'] +`</td>
                    </tr>
                `;
                exel += `<tr>
                    <td></td>
                    <th scope="row">`+ (i + 1) + `</th>
                    <td>`+ resp[i]['nombre'] + `</td>
                    <td>`+ resp[i]['categoria'] + `</td>
                    <td>`+ resp[i]['descripcion'] + `</td>
                    <td>`+ resp[i]['cantidad'] + `</td>
                    <td>`+ resp[i]['condicion'] +`</td>
                    </tr>
                `;
            }
            var movimiento =` <tr>
                        <th></th>
                        <th>Usuario</th>
                        <th>Fecha movimiento</th>
                        <th>De</th>
                        <th>Accion</th>
                        <th>Para</th>
                        <th>Motivo</th>
                    </tr>
                    <tr>
                    <td></td>
                    <td style="background-color: #00f; color: #fff">`+ respuesta[2][0]['usuario'] + `</td>
                    <td>`+ respuesta[2][0]['fecha'] + `</td>
                    <td>`+ respuesta[2][0]['almSalida'] + `</td>
                    <td>`+ respuesta[2][0]['accion'] + `</td>
                    <td>`+ respuesta[2][0]['almEntrada'] + `</td>
                    <td>`+ respuesta[2][0]['motivo'] + `</td>
                </tr>
                <tr>
                <td></td>
                </tr>
            `;
            var csv= head+exel;
            $('#idtable1').html(movimiento);
            $('#idtable2').html(csv);
            Swal.fire({
                title: '<strong>Detalle Movimiento</strong>',
                html:
                    `<div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Img</th>
                                <th scope="col">Nombre</th>
                                <th scope="col">Categ.</th>
                                <th scope="col">Descrip.</th>
                                <th scope="col">Cantidad</th>
                                <th scope="col">Condicion</th>
                            </tr>
                        </thead>
                        <tbody>
                        `+ html+`
                        </tbody>
                    </table>
                    <di class="d-flex justify-content-center">
                        <button onClick="javascript:window.open('`+ respuesta[1]['web'] + `/movimientos/detalle-movmimiento-pdf/` + resp[0]['id_movimiento']+`', '_blank');" class="btn btn-sm btn-outline-warning mr-1">
                        <i class='fas fa-file-pdf' style='color:red'>
                        </i></button>
                        <button onclick="javascript:window.open('`+ respuesta[1]['web'] + `/movimientos/detalle-movmimiento-exel/` + resp[0]['id_movimiento'] +`', '_blank');" class="btn btn-sm btn-outline-success ml-1">
                        <i class='fas fa-file-csv' style='color:green'></i></button>
                    </di>
                    </div>`,
                showConfirmButton: false,
                showCloseButton: true,
                confirmButtonColor:false,
                showCancelButton: false,
                focusConfirm: false,
            })
        }
    });
}
///************************** */
function exportTableToEXEL(id) {
    $.ajax({
        method: "GET",
        url: "app/src/ajax/files/exel.php",
        data: {
            'idruta': id
        },
        success: function (respuesta) {
            console.log(respuesta)
        }
    });
}
function selectAllMovimientos(search){
    $.ajax({
        url: "app/src/ajax/almacen/movimiento.ajax.php",
        method: "POST",
        data: {
            'selectAllmovimientos': "mov",
            'search': search,
        },
        success: function (respuesta) {
            $("#mostrarMovimientos").html(respuesta);
        }
    });
}
/*==============================
SEARCH MOVIMIENTOS
===============================*/
function searchMovimiento() {
    var search = document.getElementById('searchMovimiento').value;
    selectAllMovimientos(search);
}
$(document).ready(function () {
    var search = '';
    selectAllMovimientos(search);
    //corregirCant();
});
// ************************************************
// GUARDAR MOVIMIENTO
$("#btnGuardarMovimiento").click(function () {
    var mov = [];
    var id = [];
    var cant = [];
    var env = [];
    mov.push($("#id-alacen-salida").val());
    mov.push($("#idAccionMovimient").val());
    mov.push($("#id-alacen-entrada").val());
    mov.push($("#idmotivomove").val());
     
    $("input[name='idprod']").each(function () {
        id.push(this.value);
    });

    $("input[name='catactual']").each(function () {
        cant.push(this.value);
    });

    $("input[name='cantenvio']").each(function () {
        env.push(this.value);
    });
    var element = [];
    for (let i = 0; i < id.length; i++) {
        element.push({ id: + id[i], cant_act: cant[i], cant_env: env[i] });
        
    }

    if (mov[0] != "" && mov[1] != "" && mov[2] != "") {
        if (id.length>0){
            $.ajax({
                url: "app/src/ajax/almacen/movimiento.ajax.php",
                method: "POST", data: { 'datosMovimiento': mov,
                    'detalleMovimiento':element},
                success: function (respuesta) {
                    $("#smsconfirmations").html(respuesta);//ingresa mensaje en html
                    document.getElementById("resSearchMov").innerHTML = "";//limpiar imput imagen
                    var search = '';
                    selectAllMovimientos(search)
                    limpiarCarro();
                }
            });
        }else{
            alertify.error('Agregar Productos');
        }
    }else{
        alertify.error('Seleccione todos los campos');
    }

});

// ACEPTAR MOVIMIENTO
$(document).on("click", ".btnAceptarMovimiento", function (){
    Swal.fire({
        title: 'Está seguro?',
        text: "El estado cambiara!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#28a745',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, Aceptar!',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {

            var id = $(this).attr("idMovimiento")
            var estado = $(this).attr("estado")
            if (estado ==2){
                $(this).attr('hidden', true)
                $('#aceptar'+id).addClass('btn-warning');
                $('#aceptar'+id).removeClass('btn-danger');
                $('#aceptar'+id).html('CANCELADO');
            }else if(estado ==1){
                $('#cancelar'+id).attr('hidden', true)
                $(this).addClass('btn-success');
                $(this).removeClass('btn-danger');
                $(this).html('INGRESADO');
            }
            
            $.ajax({
                method: "POST",
                url: "app/src/ajax/almacen/movimiento.ajax.php",
                data: { 'idMovimiento': id, 'estado': estado },
                success: function (respuesta) {
                    if (respuesta=="ok"){
                        if (estado == 2) {
                            alertify.warning('Movimiento Cancelado');
                        } else {
                            alertify.success('Movimiento Aceptado');
                        }
                   }else{
                        if (respuesta=="error") {
                           alertify.error('Movimiento no Aceptado');
                       } else {
                            alertify.error(respuesta);
                            $('#cancelar' + id).attr('hidden', false)
                            $('#aceptar' + id).removeClass('btn-success');
                            $('#aceptar' + id).addClass('btn-secondary');
                            $('#aceptar' + id).html('ACEPTAR');
                           console.log(respuesta);
                       }
                   }
                }
            });
        }
    });
});

// ************************************************
// Shopping Cart API
// ************************************************

var shoppingCart = (function () {
    // =============================
    // Private methods and propeties
    // =============================
    cart = [];

    // Constructor
    function Item(name, price,descp,id, count) {
        this.name = name;
        this.price = price;
        this.descp = descp;
        this.id = id;
        this.count = count;
    }

    // Save cart
    function saveCart() {
        sessionStorage.setItem('shoppingCart', JSON.stringify(cart));
    }

    // Load cart
    function loadCart() {
        cart = JSON.parse(sessionStorage.getItem('shoppingCart'));
    }
    if (sessionStorage.getItem("shoppingCart") != null) {
        loadCart();
    }


    // =============================
    // Public methods and propeties
    // =============================
    var obj = {};

    // Add to cart
    obj.addItemToCart = function (name, price, descp, id, count) {
        for (var item in cart) {
            if (cart[item].name === name) {
                cart[item].count++;
                saveCart();
                return;
            }
        }
        var item = new Item(name, price, descp, id, count);
        cart.push(item);
        saveCart();
    }
    // Set count from item
    obj.setCountForItem = function (name, count) {
        for (var i in cart) {
            if (cart[i].name === name) {
                cart[i].count = count;
                break;
            }
        }
    };
    // Remove item from cart
    obj.removeItemFromCart = function (name) {
        for (var item in cart) {
            if (cart[item].name === name) {
                cart[item].count--;
                if (cart[item].count === 0) {
                    cart.splice(item, 1);
                }
                break;
            }
        }
        saveCart();
    }

    // Remove all items from cart
    obj.removeItemFromCartAll = function (name) {
        for (var item in cart) {
            if (cart[item].name === name) {
                cart.splice(item, 1);
                break;
            }
        }
        saveCart();
    }

    // Clear cart
    obj.clearCart = function () {
        cart = [];
        saveCart();
    }

    // Count cart 
    obj.totalCount = function () {
        var totalCount = 0;
        for (var item in cart) {
            totalCount += cart[item].count;
        }
        return totalCount;
    }

    // Total cart
    obj.totalCart = function () {
        var totalCart = 0;
        for (var item in cart) {
            totalCart += cart[item].price * cart[item].count;
        }
        return Number(totalCart.toFixed(2));
    }

    // List cart
    obj.listCart = function () {
        var cartCopy = [];
        for (i in cart) {
            item = cart[i];
            itemCopy = {};
            for (p in item) {
                itemCopy[p] = item[p];

            }
            itemCopy.total = Number(item.price * item.count).toFixed(2);
            cartCopy.push(itemCopy)
        }
        return cartCopy;
    }

    return obj;
})();


// *****************************************
// Triggers / Events
// ***************************************** 
// Add item

function addcartmov(nam, pric, descpp, idd) {
    var name = nam;
    var price = Number(pric);
    var descp = descpp;
    var id = Number(idd);
    shoppingCart.addItemToCart(name, price, descp, id, 1);
    displayCart();
}

function limpiarCarro(){
    shoppingCart.clearCart();
    displayCart();
}
// Clear items
$('.clear-cart').click(function () {
    shoppingCart.clearCart();
    displayCart();
});

function corregirCant(id){
    var c = document.getElementById('idcantactual'+id).value;
    var d = document.getElementById('idcantenv'+id).value;
    let a = parseInt(c);
    let b = parseInt(d);
    if(b==a || b>a){
        $('#idbuttonplus'+id).attr('disabled', true);
    }else{
        $('#idbuttonplus'+id).attr('disabled', false);
    }
    if (b > a || b < 1){
        if ( b <1) {
            document.getElementById('idcantenv'+id).value = '1';
        }else{
            document.getElementById('idcantenv'+id).value = a;
        }
    }
    console.log(a+b)
}

function displayCart() {
    var cartArray = shoppingCart.listCart();
    var output = "";
    for (var i in cartArray) {
        output += "<tr>"
            + "<td><input type='hidden' name='idprod' value='" + cartArray[i].id + "'>" + cartArray[i].name + "</td>"
            + "<td>" + cartArray[i].descp + "</td>"
            + "<td><input type='hidden' id='idcantactual" + cartArray[i].id +"' name='catactual' value='" + cartArray[i].price + "'>" + cartArray[i].price + "</td>"
            + `<td><div class='input-group'><button onclick="minusitem('` + cartArray[i].name + `'),corregirCant(` + cartArray[i].id + `)" class='minus-item input-group-addon btn btn-primary'>-</button>`
            + "<input id='idcantenv" + cartArray[i].id +"' onchange='corregirCant(" + cartArray[i].id + ")' onkeyup='corregirCant(" + cartArray[i].id + ")' type='number' name='cantenvio' class='item-count form-control' data-name='" + cartArray[i].name + "' value='" + cartArray[i].count + "'>"
            + `<button id="idbuttonplus` + cartArray[i].id +`" onclick="plusitem('` + cartArray[i].name + `'),corregirCant(` + cartArray[i].id + `)" class='plus-item btn btn-primary input-group-addon'>+</button></div></td>`
            + `<td><button class="delete-item btn btn-danger text-danger" data-name=` + cartArray[i].name + `>X</button></td>`
            + " = "
            + "</tr>";
    }
    $('.show-cart').html(output);
}

// Delete item button

$('.show-cart').on("click", ".delete-item", function (event) {
    var name = $(this).data('name')
    shoppingCart.removeItemFromCartAll(name);
    displayCart();
})


// -1
function minusitem(nam){
    var name = nam;
    shoppingCart.removeItemFromCart(name);
    displayCart();
}

// +1

function plusitem(nam){
    var name = nam;
    shoppingCart.addItemToCart(name);
    displayCart();
}

// Item count input
$('.show-cart').on("change", ".item-count", function (event) {
    var name = $(this).data('name');
    var count = Number($(this).val());
    shoppingCart.setCountForItem(name, count);
    displayCart();
});

displayCart();

// download exel
function downloadCSV(csv, filename) {
    var csvFile;
    var downloadLink;

    // CSV file
    csvFile = new Blob([csv], {
        type: "text/csv"
    });

    // Download link
    downloadLink = document.createElement("a");

    // File name
    downloadLink.download = filename;

    // Create a link to the file
    downloadLink.href = window.URL.createObjectURL(csvFile);

    // Hide download link
    downloadLink.style.display = "none";

    // Add the link to DOM
    document.body.appendChild(downloadLink);

    // Click download link
    downloadLink.click();
}

function exportTableToCSV(filename) {
    var csv = [];
    var rows = document.querySelectorAll(".idtablaclase tr");

    for (var i = 0; i < rows.length; i++) {
        var row = [],
            cols = rows[i].querySelectorAll("td, th");

        for (var j = 0; j < cols.length; j++)
            row.push(cols[j].innerText);

        csv.push(row.join(","));
    }

    // Download CSV file
    downloadCSV(csv.join("\n"), filename);
}
