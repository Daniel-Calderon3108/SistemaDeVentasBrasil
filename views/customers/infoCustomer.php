<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../views/img/logoEmpresa.png" type="image/x-icon">
    <title>Sistema de Ventas - View Customer</title>
</head>
<body>
    <?php include('../views/menu.php') ?>
    <section class="container_section">
        <h1 class="welcome_title">
            Ver Información del Cliente
        </h1>
        <div class="btn_container_edit">
            <a href="presentatorCustomers.php?action=update&customerNumber=<?= $data['customerNumber'] ?>" class="btn_edit">Editar Cliente</a>
        </div>
        <div class="info_customer_container">
            <div class="info_customer">
                <p><span>ID:</span><?= $data['customerNumber'] ?></p>
                <p><span>Nombre:</span><?= $data['contactFirstName'] ?></p>
                <p><span>Teléfono:</span><?= $data['phone'] ?></p>
                <p><span>País:</span><?= $data['country'] ?></p>
                <p><span>Estado:</span><?= $data['state'] ?></p>
                <p><span>Registrado por:</span><?= $data['employee'] ?></p>
            </div>
            <div class="info_customer">
                <p><span>Alias:</span><?= $data['customerName'] ?></p>
                <p><span>Apellido:</span><?= $data['contactLastName'] ?></p>
                <p><span>Dirección:</span><?= $data['addressLine1'].' '.$data['addressLine2'] ?></p>
                <p><span>Ciudad:</span><?= $data['city'] ?></p>
                <p><span>Código Postal:</span><?= $data['postalCode'] ?></p>
                <p><span>Crédito Limite:</span><?= $data['creditLimit'] ?></p>
            </div>
        </div>
        <div class="tabs">
            <div class="tab_buttons">
                <button class="tab_button active">Ordenes de Compra</button>
                <button class="tab_button">Pagos</button>
            </div>
        </div>
        <div class="tab_content">
            <div class="active">
                <a href="presentatorOrders.php?action=createNewOrder&customerNumber=<?= $data['customerNumber'] ?>" class="btn_new_order">Agregar Nueva Orden de Compra</a>
                <table class="table_order">
                    <tr>
                        <th>Número de orden</th>
                        <th>Fecha orden</th>
                        <th>Fecha de envío</th>
                        <th>Fecha recibe cliente</th>
                        <th>Estado</th>
                        <th>Estado del pago</th>
                        <th></th>
                        <th></th>
                    </tr>
                    <?php 
                    foreach($orders as $order){
                        $orderNumber = $order['orderNumber'];
                        $fechaOrden = $order['orderDate'];
                        $fechaRecibido = $order['requiredDate'];
                        $fechaEnvio = $order['shippedDate'];
                        $estado = $order['status'];
                        $estadoPago = $order['statusPayment'];
                    ?>
                    <tr>
                        <td><?= $orderNumber ?></td>
                        <td><?= $fechaOrden ?></td>
                        <td><?= $fechaEnvio ?></td>
                        <td><?= $fechaRecibido ?></td>
                        <td><?= $estado ?></td>
                        <td><?= $estadoPago ?></td>
                        <td><a href="presentatorOrders.php?action=pdf&orderNumber=<?= $orderNumber ?>" target="_blank">Detalle</a></td>
                        <td><a href="presentatorOrders.php?action=updateOrder&orderNumber=<?=  $orderNumber?>">Editar</a></td>
                    </tr>
                    <?php } ?>
                </table>
            </div>
            <div>
                <table class="table_order">
                    <tr>
                        <th>Número de verificación</th>
                        <th>Fecha de pago</th>
                        <th>Monto</th>
                        <th></th>
                        <th></th>
                    </tr>
                    <?php 
                    foreach($payments as $payment){
                        $checkNumber = $payment['checkNumber'];
                        $paymentDate = $payment['paymentDate'];
                        $amount = $payment['amount'];
                    ?>
                    <tr>
                        <td><?= $checkNumber ?></td>
                        <td><?= $paymentDate ?></td>
                        <td><?= $amount ?></td>
                        <td><a href="presentatorPayments.php?action=pdf&checkNumber=<?= $checkNumber ?>" target="_blank">Detalle</a></td>
                        <td><a href="presentatorPayments.php?action=updatePayment&checkNumber=<?= $checkNumber ?>">Editar</a></td>
                    </tr>
                    <?php } ?>
                </table>
            </div>
        </div>
    </section>
</body>
<script src="../views/js/mainCustomers.js"></script>
</html>