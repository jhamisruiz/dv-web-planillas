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
/*==========detalle movimiento=========== */
function detalleMovimiento(id){

}
///************************** */
function selectAllMovimientos(){
    $.ajax({
        url: "app/src/ajax/almacen/movimiento.ajax.php",
        method: "POST",
        data: {
            'selectAllmovimientos': "mov",
        },
        success: function (respuesta) {
            $("#mostrarMovimientos").html(respuesta);
        }
    });
} $(document).ready(function () {
    selectAllMovimientos();
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
                    selectAllMovimientos()
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


function displayCart() {
    var cartArray = shoppingCart.listCart();
    var output = "";
    for (var i in cartArray) {
        output += "<tr>"
            + "<td><input type='hidden' name='idprod' value='" + cartArray[i].id + "'>" + cartArray[i].name + "</td>"
            + "<td>" + cartArray[i].descp + "</td>"
            + "<td><input type='hidden' name='catactual' value='" + cartArray[i].price + "'>" + cartArray[i].price + "</td>"
            + `<td><div class='input-group'><button onclick="minusitem('` + cartArray[i].name + `')" class='minus-item input-group-addon btn btn-primary'>-</button>`
            + "<input type='number' name='cantenvio' class='item-count form-control' data-name='" + cartArray[i].name + "' value='" + cartArray[i].count + "'>"
            + `<button onclick="plusitem('` + cartArray[i].name + `')" class='plus-item btn btn-primary input-group-addon'>+</button></div></td>`
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
