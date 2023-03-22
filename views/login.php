<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../views/img/logoEmpresa.png" type="image/x-icon">
    <link rel="stylesheet" href="../views/css/login.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Sistema de Ventas - Login</title>
</head>

<body>
    <div class="login_container">
        <form action="" class="login_form">
            <div class="form_title">
                <h1>Iniciar Sesión</h1>
            </div>
            <div class="form_items">
                <input type="text" id="email" class="form_input" placeholder="Correo Electronico">
            </div>
            <div class="form_items">
                <input type="password" id="password" class="form_input" placeholder="Clave">
            </div>
            <div class="form_items">
                <input type="button" value="Iniciar Sesión" class="btn_login" onclick="login()">
            </div>
        </form>
    </div>
</body>
<script src="../views/js/mainLogin.js"></script>
</html>