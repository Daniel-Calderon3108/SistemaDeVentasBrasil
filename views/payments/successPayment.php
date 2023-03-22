<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../views/img/logoEmpresa.png" type="image/x-icon">
    <title>Sistema de ventas - pago exitoso</title>
</head>
<body>
    <?php include('../views/menu.php') ?>
    <section class="container_section">
        <h1 class="welcome_title">
            Pago realizado con exito
        </h1>
        <p>El pago se ha realizado con exito, para ver o descargar el recibo de pago da click en ver pdf.</p>
        <a href="presentatorPayments.php?action=pdf&checkNumber=<?= $id ?>" target="_blank" class="btn_pdf">Ver PDF</a>
    </section>
</body>
</html>