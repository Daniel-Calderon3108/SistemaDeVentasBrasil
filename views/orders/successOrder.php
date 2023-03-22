<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../views/img/logoEmpresa.png" type="image/x-icon">
    <title>Sistema de ventas - orden de compra exitosa</title>
</head>
<body>
    <?php include('../views/menu.php') ?>
    <section class="container_section">
        <h1 class="welcome_title">
            Orden de compra guardada con exito
        </h1>
        <p>Recuerda pagar la totalidad de la deuda, para tener crédito disponible</p>
        <p>La orden de compra se ha realizado con exito, para ver o descargar la orden de servicio da click en ver pdf.</p>
        <a href="presentatorOrders.php?action=pdf&orderNumber=<?= $id ?>" target="_blank" class="btn_pdf">Ver PDF</a>
    </section>
</body>
</html>