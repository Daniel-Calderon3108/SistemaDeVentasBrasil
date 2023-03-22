<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../views/img/logoEmpresa.png" type="image/x-icon">
    <title>Sistema de ventas - Lista de ordenes pendiente pago</title>
</head>

<body>
    <?php include('../views/menu.php') ?>
    <section class="container_section">
        <h1 class="welcome_title">
            Administrar Ordenes de Pago Pendiente
        </h1>
        <h1 class="search_title margin_payment">Buscar Por:</h1>
        <div class="form_search">
            <input type="text" id="customerNumber" class="input_search" placeholder="ID del Cliente">
            <input type="text" id="contactLastName" class="input_search" placeholder="Apellido del Cliente">
            <input type="text" id="orderNumber" class="input_search" placeholder="Número Orden de Compra">
            <input type="button" id="btn_search" value="Buscar" class="input_search btn_search" onclick="getOrderPayments()">
        </div>
        <p class="total_register"><span id="total"> </span>-Registros en Total</p>
        <table class="table_search" id="search"></table>
    </section>
</body>
<script src="../views/js/mainPayments.js"></script>

</html>