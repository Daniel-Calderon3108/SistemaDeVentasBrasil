$(document).ready(function () {
    //Se encarga de cargar los datos de los productos, segun los parametros
    //establecidos por el usuario, lo carga en el select
    $('#Products').select2({
        placeholder: 'Seleccione un producto',
        ajax: {
            url: 'presentatorProducts.php?action=getProducts',
            dataType: 'json',
            delay: 250,
            processResults: function (data) {
                return {
                    results: data
                };
            },
            cache: true
        }
    });
});
//Función que se encarga de cargar los inputs de cantidad y precio
//de cada producto seleccionado
function infoProduct() {
    let result = $('#form_info_products').html()
    let product = $('#Products').text()
    let productCode = $('#Products').val()
    let infoProduct = $('#totalProducts').html()
    result += `<div class="products_info">
                        <h1>Datos Producto</h1>
                        <div class="form_items">
                            <input type="text" name="productName" id="productName" class="form_input" readonly="readonly" value="${product}">
                            <input type="hidden" name="productCode" id="productCode" value="${productCode}">
                        </div>
                        <div class="form_items margin">
                            <input type="number" name="quantity" id="quantity-${productCode}" class="form_input" placeholder="Cantidad" onchange="total('${productCode}')" onkeyup="total('${productCode}')">
                            <input type="text" name="price" id="price-${productCode}" class="form_input" placeholder="Precio Unidad" onkeyup="total('${productCode}')">
                        </div>
                    </div>`
    infoProduct += `<p>${product}: $ <span class="totalProduct" id="total-${productCode}">0</span></p>`
    $('#form_info_products').html(result)
    $('#totalProducts').html(infoProduct)
    $('#Products').val('')
    $('#Products').text('')

    $('.totalProduct').each(function () {
        $('.totalProduct').html(0)
    })

    $('#totalOrder').html(0)


}
//Función que se encarga actualizar el valor total de cada producto
//y el total de la compra
function total(productCode) {
    let totalProduct = 0
    let total = 0

    if ($(`#quantity-${productCode}`).val() != '' && $(`#price-${productCode}`).val() != '') {
        totalProduct = $(`#quantity-${productCode}`).val() * $(`#price-${productCode}`).val()
    } else {
        totalProduct = 0
    }

    $(`#total-${productCode}`).html(totalProduct)

    $('.totalProduct').each(function () {
        total = total + parseInt($(this).html())
    })

    $('#totalOrder').html(total)
}
//Función que se encarga de crear un arreglo con todos los códigos del producto
function productCode() {

    let productCode = {}
    let i = 0

    $('input[name="productCode"]').each(function () {
        productCode[i] = $(this).val();
        i++
    });

    return productCode
}
//Función que se encarga de crear un arreglo con todas la cantidades de los productos
function quantity() {

    let quantity = {}
    let i = 0

    $('input[name="quantity"]').each(function () {
        quantity[i] = $(this).val();
        i++
    });

    return quantity
}
//Función que se encarga de crear un arreglo con todos los precios de los productos
function price() {

    let price = {}
    let i = 0

    $('input[name="price"]').each(function () {
        price[i] = $(this).val();
        i++
    });

    return price
}
//Función la cual se encarga de enviar alerts personalizados
function message(type, message) {
    Swal.fire({
        icon: type,
        title: 'Sistema de Ventas',
        text: message,
    })
}
//Función que se encarga de validar que el total de la compra
//no supere el valor crédito limite de cada cliente
function validate() {

    if ((parseFloat($('#creditLimit').html()) < parseFloat($('#totalOrder').html())) || $('#totalOrder').html() == 0  ) {
        message('error', 'El valor total no puede ser igual 0 y no puede superar el valor del crédito')
        return false
    } else {
        return true
    }

}
//Función que se encarga de mandar la petición para crear una nueva orden de compra
function createNewOrder() {

    if (validate() == true) {

        var customerNumber = $('#customerNumber').val()

        var params = {
            'productCode': productCode(),
            'quantity': quantity(),
            'price': price(),
            'amountPending': $('#totalOrder').html()
        }

        $.ajax({
            url: 'presentatorOrders.php?action=createNewOrder&customerNumber=' + customerNumber,
            type: 'POST',
            dataType: 'json',
            data: params,
            success: function (response) {
                if (response.error == false) {
                    $('#orderNumber').val(response.data.orderNumber)
                    siguienteSeccion()
                }
            },
            error: function () {

            }
        })
    }

}
//Función que se encarga de cargar la siguiente fase, para realizar la
//creación de la nueva orden de compra
function siguienteSeccion() {
    $('#seleccionar_productos').fadeOut()
    $('#seleccionar_fechas').fadeIn()
}
//Función que se encarga de mandar la petición para guardar la fecha de
//llegada y fecha en la que debe ser recibido por el cliente
function addDate() {

    var params = {
        'shippedDate': $('#shippedDate').val(),
        'requiredDate': $('#requiredDate').val(),
        'orderNumber': $('#orderNumber').val(),
        'customerNumber': $('#customerNumber').val()
    }

    $.ajax({
        url: 'presentatorOrders.php?action=addDate',
        type: 'POST',
        dataType: 'json',
        data: params,
        success: function (response) {
            if (response.error == false) {
                window.location.href = response.data.url
            }
        },
        error: function () {

        }
    })
}
//Función para mandar una petición para actualizar la orden de compra
function updateOrder() {
    params = {
        'orderNumber': $('#orderNumber').val(),
        'requiredDate': $('#requiredDate').val(),
        'shippedDate': $('#shippedDate').val(),
        'status': $('#status').val(),
        'comments': $('#comments').val(),
        'customerNumber': $('#customerNumber').val()
    }

    $.ajax({
        url: 'presentatorOrders.php?action=saveUpdate',
        type: 'POST',
        dataType: 'json',
        data: params,
        success: function (response) {
            if (response.error == false) { 
                window.location.href = response.data.url
            }else {
                message('error',response.message)
            }
        },
        error: function () {
            message('error','fallo interno del servidor')
        }
    })
}

