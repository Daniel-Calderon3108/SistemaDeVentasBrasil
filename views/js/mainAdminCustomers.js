$(document).ready(function () {
    //Cuando el documento ya esta cargada, ejecuta la funcion search, 
    //la cual se encarga de traer todos los clientes
    search()
});
//Función la cual se encarga de enviar alerts personalizados
function message(type,message){
    Swal.fire({
        icon: type,
        title: 'Sistema de Ventas',
        text: message,
      })
}
//Función que se encarga de enviar la petición para listar los clientes
//Segun los parametros que envia el usuario
function search() {

    var params = {
        'action': 'search',
        'id': $('#customerNumber').val(),
        'nombre': $('#contactFirstName').val(),
        'apellido': $('#contactLastName').val()
    }

    $.ajax({

        url: 'presentatorCustomers.php',
        type: 'GET',
        dataType: 'json',
        data: params,
        success: function (response) {
            var count = 0
                var result = `<tr>
                                <th>ID</th>
                                <th>Alias</th>
                                <th>Nombre</th>
                                <th>Teléfono</th>
                                <th>Dirección</th>
                                <th>Ciudad</th>
                                <th>País</th>
                                <th>Estado</th>
                                <th>Código Postal</th>
                                <th>Atendido Por</th>
                                <th>Limite de Crédito</th>
                                <th></th>
                               </tr>`
            if (response.error == false) {
                response.data.forEach(element => {
                    count++;
                    address = element.addressLine1
                    employee = element.employee == null ? "" : element.employee
                    state = element.state == null ?  "" : element.state
                    postalCode = element.postalCode == null ? "" : element.postalCode
                    if(element.addressLine2 != null){
                        address += " "+element.addressLine2
                    }
                    result += `<tr>
                                    <td>${element.customerNumber}</td>
                                    <td>${element.customerName}</td>
                                    <td>${element.customerCompleteName}</td>
                                    <td>${element.phone}</td>
                                    <td>${address}</td>
                                    <td>${element.city}</td>
                                    <td>${element.country}</td>
                                    <td>${state}</td>
                                    <td>${postalCode}</td>
                                    <td>${employee}</td>
                                    <td>${element.creditLimit}</td>
                                    <td><a href="presentatorCustomers.php?action=infoCustomer&customerNumber=${element.customerNumber}" class="select_search">Seleccionar</a></td>
                                <tr>`
                });            

            }else{
                console.log(response.message)
                $('#search').html(result)
            }
            $('#search').html(result)
            $('#total').html(count)
        },
        error: function () {
            console.log('Hubo un error al buscar los clientes');
        }
    });
}
//Función que se encarga de validar, que todos los inputs,
//esten totalmente llenos, manda un mensaje si algun campo esta vacio
function validate() {
    
    if($('#contactFirstName').val() == ""){
        message('error','El campo nombre no puede estar vacío')
        $('#contactFirstName').css('border-color','red')
    }else if($('#contactLastName').val() == ""){
        message('error','El campo apellido no puede estar vacío')
        $('#contactLastName').css('border-color','red')
    }else if($('#customerName').val() == ""){
        message('error','El campo alias no puede estar vacío')
        $('#customerName').css('border-color','red')
    }else if($('#phone').val() == ""){
        message('error','El campo teléfono no puede estar vacío')
        $('#phone').css('border-color','red')
    }else if($('#address1').val() == ""){
        message('error','El campo dirección linea 1 no puede estar vacío')
        $('#address1').css('border-color','red')
    }else if($('#address2').val() == ""){
        message('error','El campo dirección linea 2 no puede estar vacío')
        $('#address2').css('border-color','red')
    }else if($('#postalCode').val() == ""){
        message('error','El campo código postal no puede estar vacío')
        $('#postalCode').css('border-color','red')
    }else if($('#state').val() == ""){
        message('error','El campo estado no puede estar vacío')
        $('#state').css('border-color','red')
    }else if($('#city').val() == ""){
        message('error','El campo ciudad no puede estar vacío')
        $('#city').css('border-color','red')
    }else if($('#country').val() == ""){
        message('error','El campo país no puede estar vacío')
        $('#country').css('border-color','red')
    }else if($('#creditLimit').val() == ""){
        message('error','El campo crédito limite no puede estar vacío')
        $('#creditLimit').css('border-color','red')
    }else{
        return true
    }
}
//Función que se encarga de mandar los datos por medio de una petición
//para crear un nuevo cliente
function create(){
    if(validate() == true){
        params = {
            'contactFirstName': $('#contactFirstName').val(),
            'contactLastName': $('#contactLastName').val(),
            'customerName': $('#customerName').val(),
            'phone': $('#phone').val(),
            'address1': $('#address1').val(),
            'address2': $('#address2').val(),
            'postalCode': $('#postalCode').val(),
            'state': $('#state').val(),
            'city': $('#city').val(),
            'country': $('#country').val(),
            'creditLimit': $('#creditLimit').val()
        }

        $.ajax({
            url: 'presentatorCustomers.php?action=create',
            type: 'POST',
            dataType: 'json',
            data: params,
            success: function(response) {
                if(response.error == false){
                    message('success','Se registro Cliente con id '+response.data.id)
                    
                    setTimeout(function() {
                        window.location.href = response.data.url
                      }, 3000);
                    
                }else{
                    message('error',response.message)
                }
            },
            error: function (){
                message('error','Ocurrio un error interno')
            }
        })
    }
}
//Función que se encarga de mandar los datos por medio de una petición
//para modificar un cliente
function update(){
    if(validate() == true){
        params = {
            'contactFirstName': $('#contactFirstName').val(),
            'contactLastName': $('#contactLastName').val(),
            'customerName': $('#customerName').val(),
            'phone': $('#phone').val(),
            'address1': $('#address1').val(),
            'address2': $('#address2').val(),
            'postalCode': $('#postalCode').val(),
            'state': $('#state').val(),
            'city': $('#city').val(),
            'country': $('#country').val(),
            'creditLimit': $('#creditLimit').val(),
            'customerNumber': $('#customerNumber').val()
        }

        $.ajax({
            url: 'presentatorCustomers.php?action=updateSave',
            type: 'POST',
            dataType: 'json',
            data: params,
            success: function(response) {
                if(response.error == false){
                    window.location.href = response.data.url  
                }else{
                    message('error',response.message)
                }
            },
            error: function (){
                message('error','Ocurrio un error interno')
            }
        })
    }
}