//Función que se encarga de mandar los datos digitados por el usuario
//por medio de una petición, para realizar el inicio de sesión
function login() {
    var params = {
        'email': $('#email').val(),
        'password': $('#password').val()
    }

    $.ajax({

        url: 'presentatorLogin.php?action=validateLogin',
        type: 'POST',
        dataType: 'json',
        data: params,
        success: function(response) {
            if(response.error == false){
                window.location.href = response.data
            }else{
                Swal.fire({
                    icon: 'warning',
                    title: 'Sistema de Ventas',
                    text: 'Usuario ó contraseña incorrectos',
                  })
            }
        },
        error: function () {

        }
    });
}