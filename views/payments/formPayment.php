<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../views/img/logoEmpresa.png" type="image/x-icon">
    <title>Sistema de ventas - <?= isset($data['checkNumber']) ? 'Editando' : 'Realizar' ?> Pago</title>
</head>

<body>
    <?php include('../views/menu.php') ?>
    <section class="container_section">
        <h1 class="welcome_title">
            <?= isset($data['checkNumber']) ? 'Editando' : 'Realizar' ?> pago de la orden de compra #<span id="orderNumber"><?= $data['orderNumber'] ?></span>
        </h1>
        <div id="confirmar_pago">
            <div class="products_info margin_payment">
                <h1>Información pago:</h1>
                <p><b>Nombre Cliente: </b><?= $data['customerNameComplete'] ?></p>
                <p class="margin_payment"><b>Valor Pago Pendiente: </b><span id="amountPending"><?= $data['amountPending'] ?></span></p>
                <form>
                    <h1 class="title_payment">Datos Pago:</h1>
                    <div class="form_items">
                        <div class="form_item">
                            <input type="text" id="amount" class="form_input" placeholder="Digite la cantidad a pagar" value="<?= isset($data['amount']) ? $data['amount'] : '' ?>">
                            <input type="hidden" id="customerNumber" value="<?= $data['customerNumber'] ?>">
                            <input type="hidden" id="olderAmount" value="<?= isset($data['amount']) ? $data['amount'] : '' ?>">
                            <input type="hidden" id="checkNumber" value="<?= isset($data['checkNumber']) ? $data['checkNumber'] : '' ?>">
                        </div>
                        <div class="form_item">
                            <select id="methodPayment" class="form_input">
                                <option value="<?= isset($data['methodPayment']) ? $data['methodPayment'] : '' ?>">
                                    <?= isset($data['methodPayment']) ? $data['methodPayment'] : 'Seleccione medio de pago' ?></option>
                                <option value="Efectivo">Efectivo</option>
                                <option value="Tarjeta de crédito">Tarjeta de crédito</option>
                                <option value="Transferencia electrónica">Transferencia electrónica</option>
                            </select>
                        </div>
                    </div>
                    <div class="form_items">
                        <div class="form_item">
                            <input type="button" value="<?= isset($data['checkNumber']) ? 'Guardar Pago' : 'Realizar Pago' ?>" 
                                class="form_btn" onclick="<?= isset($data['checkNumber']) ? 'saveUpdate()' : 'realizarPago()' ?>">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
</body>
<script src="../views/js/mainPayments.js"></script>

</html>