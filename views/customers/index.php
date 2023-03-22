<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../views/img/logoEmpresa.png" type="image/x-icon">
    <title>Sistemas de Ventas - Customers</title>
</head>
<body>
    <?php include('../views/menu.php') ?>
    <section class="container_section">
        <h1 class="welcome_title">
            Administrar Clientes
        </h1>
        <a href="presentatorCustomers.php?action=create" class="btn-new-register">Registrar nuevo cliente</a>
        <h1 class="search_title">
            Buscar por:
        </h1>
        <div class="form_search">
            <input type="text" name="customerNumber" id="customerNumber" class="input_search input_id" placeholder="ID">
            <input type="text" name="contactFirstName" id="contactFirstName" class="input_search" placeholder="Nombre">
            <input type="text" name="contactLastName" id="contactLastName" class="input_search" placeholder="Apellido">
            <input type="button" id="btn_search" value="Buscar" class="input_search btn_search" onclick="search()">
        </div>
        <p class="total_register"><span id="total"> </span>-Registros en Total</p>
        <table class="table_search" id="search"></table>
    </section>
</body>
<script src="../views/js/mainAdminCustomers.js"></script>
</html>