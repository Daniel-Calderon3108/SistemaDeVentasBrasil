<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../img/logoEmpresa.png" type="image/x-icon">
    <link rel="stylesheet" href="../views/css/styles.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
    <title>Sistema de Ventas</title>
</head>

<body>
    <header>
        <div class="container_header">
            <div class="logo_header">
                <figure>
                    <img src="../views/img/logoEmpresa.png" class="img_header">
                </figure>
                <h1>Sistema de Ventas</h1>
            </div>
            <ul class="nav_items">
                <li class="items"><a href="presentatorEmployees.php?action=index" class="menu_item">Inicio</a></li>
                <li class="items"><a href="presentatorCustomers.php?action=index" class="menu_item">Clientes</a></li>
                <li class="items"><a href="presentatorPayments.php?action=index" class="menu_item">Pagos</a></li>
                <li class="items"><a href="presentatorLogin.php?action=login" class="menu_item">Cerrar Sesión</a></li>
            </ul>
        </div>
    </header>
</body>

</html>