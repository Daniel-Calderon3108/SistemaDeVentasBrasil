<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../views/img/logoEmpresa.png" type="image/x-icon">
    <title>Sistema de ventas - <?= $data == '' ? 'Nuevo' : 'Editando'  ?> Cliente</title>
</head>
<body>
    <?php include('../views/menu.php') ?>
    <section class="container_section">
        <h1 class="welcome_title">
            <?= $data == '' ? 'Añadiendo Nuevo' : 'Editando' ?> Cliente
        </h1>
        <form class="form">
            <h1 class="form_title">Datos Cliente</h1>
            <div class="form_items">
                <div class="form_item">
                    <input type="text" id="contactFirstName" class="form_input" placeholder="Nombre" value="<?= $data == '' ? '' : $data['contactFirstName'] ?>">
                    <input type="hidden" id="customerNumber" value="<?= $data == '' ? '' : $data['customerNumber'] ?>">
                </div>
                <div class="form_item">
                    <input type="text" id="contactLastName" class="form_input" placeholder="Apellido" value="<?= $data == '' ? '' : $data['contactLastName'] ?>">
                </div>
            </div>
            <div class="form_items">
                <div class="form_item">
                    <input type="text" id="customerName" class="form_input" placeholder="Alias" value="<?= $data == '' ? '' : $data['customerName'] ?>">
                </div>
                <div class="form_item">
                    <input type="text" id="phone" class="form_input" placeholder="Teléfono" value="<?= $data == '' ? '' : $data['phone'] ?>">
                </div>
            </div>
            <div class="form_items">
                <div class="form_item">
                    <input type="text" id="address1" class="form_input" placeholder="Dirección Linea 1" value="<?= $data == '' ? '' : $data['addressLine1'] ?>">
                </div>
                <div class="form_item">
                    <input type="text" id="address2" class="form_input" placeholder="Dirección Linea 2" value="<?= $data == '' ? '' : $data['addressLine2'] ?>">
                </div>
            </div>
            <div class="form_items">
                <div class="form_item">
                    <input type="text" id="postalCode" class="form_input" placeholder="Código Postal" value="<?= $data == '' ? '' : $data['postalCode'] ?>">
                </div>
                <div class="form_item">
                    <input type="text" id="state" class="form_input" placeholder="Estado" value="<?= $data == '' ? '' : $data['state'] ?>">
                </div>
            </div>
            <div class="form_items">
                <div class="form_item">
                    <input type="text" id="city" class="form_input" placeholder="Ciudad" value="<?= $data == '' ? '' : $data['city'] ?>">
                </div>
                <div class="form_item">
                    <input type="text" id="country" class="form_input" placeholder="País" value="<?= $data == '' ? '' : $data['country'] ?>">
                </div>
            </div>
            <div class="form_items">
                <div class="form_item">
                    <input type="text" id="creditLimit" class="form_input" placeholder="Crédito Limite" value="<?= $data == '' ? '' : round($data['creditLimit']) ?>">
                </div>
            </div>
            <div class="form_items">
                <div class="form_item">
                    <input type="button" value="<?= $data == '' ? 'Registrar' : 'Guardar' ?>" class="form_btn" onclick="<?= $data == '' ? 'create()' : 'update()' ?>">
                </div>
            </div>
        </form>
    </section>
</body>
<script src="../views/js/mainAdminCustomers.js"></script>
</html>