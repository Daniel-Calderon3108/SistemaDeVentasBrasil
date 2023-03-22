<?php
ob_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orden de Servicio</title>
    <style>
        .container-order {
            margin: auto;
        }

        img {
            max-width: 180px;
            margin-top: -30px;
            display: block;
        }

        td,
        th {
            text-align: center;
        }

        .container_header{
            text-align: center;
        }

        .items_header {
            display: inline-block;
            margin-top: 30px;
        }

        .items_header p {
            font-size: 15px;
        }
        
        table{
            width: 60%;
            margin: auto;
        }

        .table{
            width: 100%;
            margin: 30px auto;
        }
    </style>
</head>

<body>
    <div class="container-order">
        <div>
            <img src="http://<?= $_SERVER['HTTP_HOST'] ?>/pruebatecnicabrasil/views/img/logoEmpresa.png" alt="">
        </div>
        <hr>
        <div class="container_header">
            <div class="items_header">
                <p><b>ID Cliente:</b> <?= $data['customerNumber'] ?></p>
                <p><b>Nombre Completo:</b> <?= $data['customerNameComplete'] ?></p>
            </div>
            <div class="items_header">
                <p><b>Número de Orden:</b> <?= $data['orderNumber'] ?></p>
                <p><b>Fecha de Compra:</b> <?= $data['orderDate'] ?></p>
            </div>
            <div class="items_header">
                <p><b>Fecha Envío:</b> <?= $data['shippedDate'] ?></p>
                <p><b>Fecha Recibe Cliente:</b> <?= $data['requiredDate'] ?></p>
            </div>
        </div>
        <hr>
        <table class="table">
            <tr>
                <th>Nombre Producto</th>
                <th>Linea Producto</th>
                <th>Cantidad</th>
                <th>Precio Unitario</th>
                <th>Precio Total</th>
            </tr>
            <?php
            $totalOrder = 0;
            foreach ($orderDetail as $detail) {
                $productName = $detail['productName'];
                $productLine = $detail['productLine'];
                $quantity = $detail['quantityOrdered'];
                $price = $detail['priceEach'];
                $total = $detail['total'];
                $totalOrder = $totalOrder + $total;
            ?>
                <tr>
                    <td><?= $productName ?></td>
                    <td><?= $productLine ?></td>
                    <td><?= $quantity ?></td>
                    <td>$ <?= $price ?></td>
                    <td>$ <?= $total ?></td>
                </tr>
            <?php } ?>
        </table>
        <hr>
        <table>
            <tr>
                <td style="text-align: left;"><b>Total</b></td>
                <td style="text-align: right;">$ <?= $totalOrder ?></td>
            </tr>
        </table>
        <hr>
        <div>
            <p><b>Estado del pago:</b> <?= $data['statusPayment'] ?></p>
            <p><b>Deuda pendiente:</b> <?= $data['amountPending'] ?></p>
        </div>
    </div>

</body>

</html>
<?php
$html = ob_get_clean();

require_once('../dompdf/autoload.inc.php');

use Dompdf\Dompdf;

$dompdf = new Dompdf();

$options = $dompdf->getOptions();
$options->set(array('isRemoteEnabled' => true));
$dompdf->setOptions($options);

$dompdf->loadHtml($html);

$dompdf->setPaper('letter');

$dompdf->render();

$dompdf->stream("ordenDeServicio#" . $data['orderNumber'] . ".pdf", array("Attachment" => false));
?>