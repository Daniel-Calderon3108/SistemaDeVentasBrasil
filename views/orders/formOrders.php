<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../views/img/logoEmpresa.png" type="image/x-icon">
    <title>Sistema de Ventas - Generar Nueva Orden de Compra</title>
</head>

<body>
    <?php include('../views/menu.php') ?>
    <section class="container_section">
        <h1 class="welcome_title">
            Generando nueva orden de compra
        </h1>
        <div id="seleccionar_productos">
            <form class="form">
                <h1 class="form_title">Datos Orden de Compra</h1>
                <p class="form_info">Recuerda que el crédito limite es: <span id="creditLimit"><?= $data['creditLimit'] ?></span></p>
                <div class="form_items">
                    <div class="form_products">
                        <input type="hidden" id="customerNumber" value="<?= $customerNumber ?>">
                        <select id="Products" class="form_input" onchange="infoProduct()"></select>
                    </div>
                </div>
                <div id="form_info_products"></div>
                <div class="products_info">
                    <h1>Valor total por producto</h1>
                    <div id="totalProducts"></div>
                    <h1>Total Compra</h1>
                    <p>$ <span id="totalOrder">0</span></p>
                </div>
                <div class="form_items">
                    <div class="form_item">
                        <input type="button" value="Confirmar Pedido" class="form_btn" onclick="createNewOrder()">
                    </div>
                </div>
            </form>
        </div>
        <div id="seleccionar_fechas" style="display: none;">
            <div class="form">
                <h1 class="form_title">Seleccionando Fechas Orden de Compra</h1>
                <div class="form_items">
                    <div class="form_item">
                        <label for="">Fecha de envío pedido</label>
                        <input type="date" id="shippedDate" class="form_input" value="<?= $fecha ?>" min="<?= $fecha ?>">
                        <input type="hidden" id="orderNumber">
                    </div>
                    <div class="form_item">
                        <label for="">Fecha que sera recibido el pedido</label>
                        <input type="date" id="requiredDate" class="form_input" value="<?= $fecha ?>" min="<?= $fecha ?>">
                    </div>
                </div>
                <div class="form_items">
                    <div class="form_item">
                        <input type="button" value="Guardar" class="form_btn" onclick="addDate()">
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>
<script src="../views/js/mainOrders.js"></script>

</html>