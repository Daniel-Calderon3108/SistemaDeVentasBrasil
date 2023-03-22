<?php
ob_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recibos de Pago</title>
    <style>
        .container-payment {
            margin: auto;
        }

        img {
            max-width: 180px;
            margin-top: -30px;
            display: block;
        }

        .container_header{
            text-align: center;
            margin: 50px;
        }

        h3{
            margin-bottom: 40px;
        }
    </style>
</head>
<body>
    <div class="container-payment">
        <div>
            <img src="http://<?= $_SERVER['HTTP_HOST'] ?>/pruebatecnicabrasil/views/img/logoEmpresa.png" alt="">
        </div>
        <hr>
        <div class="container_header">
            <h3>Recibo de Pago #<?= $data['checkNumber'] ?></h3>
            <p><b>Número Orden Compra:</b> <?= $data['orderNumber'] ?></p>
            <p><b>Fecha Compra:</b> <?= $data['orderDate'] ?></p>
            <p><b>ID Cliente:</b> <?= $data['customerNumber'] ?></p>
            <p><b>Nombre Cliente</b> <?= $data['customerNameComplete'] ?></p>
            <p><b>Valor Pagado:</b> <?= $data['amount'] ?></p>
            <p><b>Método Pago:</b> <?=$data['methodPayment'] ?></p>
            <p><b>Deuda:</b> <?= $data['amountPending'] ?></p>
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

$dompdf->stream("reciboPago#" . $data['checkNumber'] . ".pdf", array("Attachment" => false));
?>