$(document).ready (function () {
    //Función que se encarga de traer todas la ordenes de compra pendientes cuando se carga el documento
    getOrderPayments()
});
//Función que se encarga de enviar la petición para traer todos las ordenes de compra pendientes
//Segun los parametros establecidos por el usuario
function getOrderPayments() {
    
    params = {
        'action': 'search',
        'customerNumber': $('#customerNumber').val(),
        'contactLastName': $('#contactLastName').val(),
        'orderNumber': $('#orderNumber').val()
    }

    $.ajax({
        url: 'presentatorPayments.php',
        type: 'GET',
        dataType: 'json',
        data: params,
        success: function (response) {

            if(response.error == false){
                results = `<tr>
                                <th>ID Cliente</th>
                                <th>Nombre Cliente</th>
                                <th>Número de Orden</th>
                                <th>Fecha Orden</th>
                                <th>Fecha Envío</th>
                                <th>Fecha Recibe Cliente</th>
                                <th>Estado</th>
                                <th>Monto Pendiente</th>
                                <th></th>
                            </tr>`
                count = 0
                response.data.forEach(element => {
                    count++
                    results += `<tr>
                                    <td>${element.customerNumber}</td>
                                    <td>${element.customerCompleteName}</td>
                                    <td>${element.orderNumber}</td>
                                    <td>${element.orderDate}</td>
                                    <td>${element.shippedDate}</td>
                                    <td>${element.requiredDate}</td>
                                    <td>${element.status}</td>
                                    <td>${element.amountPending}</td>
                                    <td><a href="presentatorPayments.php?action=create&orderNumber=${element.orderNumber}" class="select_search">Realizar Pago</a></td>
                                </tr>`
                });
                $('#search').html(results)
                $('#total').html(count)
            }
        },
        error: function () {

        }
    })
}
//Función la cual se encarga de enviar alerts personalizados
function message(type,message){
    Swal.fire({
        icon: type,
        title: 'Sistema de Ventas',
        text: message,
      })
}
//Función que se encarga que todos los campos sean llenados y que el valor pendiente por pagar no sea
//superado por el valor que desea pagar el usuario
function validate() {
    
    if(($('#amount').val() == '') || (parseInt($('#amount').val()) > parseInt($('#amountPending').html()))){
        message('error','El campo cantidad a pagar no puede estar vacío y no puede superar el valor pendiente')
        $('#amount').css('border-color','red')
    }else if($('#methodPayment').val() == ''){
        message('error','Por favor seleccione un metodo de pago')
        $('#methodPayment').css('border-color','red')
    }else{
        return true;
    }
}
//Función que se encarga de enviar la petición para realizar el pago
function realizarPago() {
    if(validate() == true){
        
        var params = {
            'customerNumber': $('#customerNumber').val(),
            'orderNumber': $('#orderNumber').html(),
            'amount': $('#amount').val(),
            'methodPayment': $('#methodPayment').val()
        }


        $.ajax({
            url: 'presentatorPayments.php?action=savePayment',
            type: 'POST',
            dataType: 'json',
            data: params,
            success: function (response) {
                if(response.error == false){
                    window.location.href = response.data
                }else{
                    message('error',response.message)
                }
            },
            error: function () {

            }
        })
    }
}

function saveUpdate() {
    
    var params = {
        'customerNumber': $('#customerNumber').val(),
        'orderNumber': $('#orderNumber').html(),
        'amount': $('#amount').val(),
        'methodPayment': $('#methodPayment').val(),
        'olderAmount': $('#olderAmount').val(),
        'checkNumber': $('#checkNumber').val()
    }

    $.ajax({
        url: 'presentatorPayments.php?action=saveUpdate',
            type: 'POST',
            dataType: 'json',
            data: params,
            success: function (response) {
                if(response.error == false){
                    window.location.href = response.data.url
                }else{
                    message('error',response.message)
                }
            },
            error: function () {

            }
    })
}