<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../views/img/logoEmpresa.png" type="image/x-icon">
    <title>Sistema de Ventas - Editando Orden de Compra</title>
</head>
<body>
    <?php include('../views/menu.php') ?>
    <section class="container_section">
        <h1 class="welcome_title">Editando Orden de Compra</h1>
        <form class="form">
            <h1 class="form_title">Datos Orden de Compra</h1>
            <div class="form_items">
                <div class="form_item">
                    <input type="date" id="requiredDate" class="form_input" value="<?= $data['requiredDate'] ?>" min="<?= $fecha ?>">
                    <input type="hidden" id="orderNumber" value="<?= $data['orderNumber'] ?>">
                    <input type="hidden" id="customerNumber" value="<?= $data['customerNumber'] ?>">
                </div>
                <div class="form_item">
                    <input type="date" id="shippedDate" class="form_input" value="<?= $data['shippedDate'] ?>" min="<?= $fecha ?>">
                </div>
                <div class="form_item">
                    <input type="text" id="status" class="form_input" value="<?= $data['status'] ?>" min="<?= $fecha ?>">
                </div>
            </div>
            <div class="form_items">
                <div class="form_item">
                    <textarea id="comments" class="form_input"><?= $data['comments'] == '' ? 'Agregar un breve comentario' : $data['comments'] ?></textarea>
                </div>
            </div>
            <div class="form_items">
                <div class="form_item">
                    <input type="button" value="Guardar" class="form_btn" onclick="updateOrder()">
                </div>
            </div>
        </form>
    </section>
</body>
<script src="../views/js/mainOrders.js"></script>
</html>