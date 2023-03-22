<?php
//Se verifica que se haya iniciado sesión, de no ser así se manda al inicio de sesión
session_start();
if (!isset($_SESSION['EmployeeNumber'])) {
    header('Location:presentatorLogin.php?action=login');
}
//Se trae el modelo de orden de compra para su posterior uso
require_once('../models/modelOrders.php');

class PresentatorOrders
{
    //Función que retorna un json, indicando si hubo error, un mensaje y un data en caso que exista
    public function resolve($error, $message, $data = null)
    {
        $data = array(
            'error' => $error,
            'message' => $message,
            'data' => $data
        );
        $json = json_encode($data);
        header('Content-Type: application/json');

        echo $json;
        die;
    }
    //Función que se encarga de cargar la vista de nueva orden compra
    //Si recibe datos por post los envia al modelo para crear la nueva orden de compra
    public function createNewOrder($id)
    {
        $model           = new ModelOrders;
        //Obtiene por get el id del cliente y lo guarda en una variable
        $customerNumber  = $id;
        //Obtiene la fecha actual
        $fecha           = date('Y-m-d');
        //Obtiene el crédito limite del cliente
        $data            = $model->getCreditLimit($customerNumber);

        if (isset($_POST) && !empty($_POST)) {
            //Recoge todos los datos enviados por el usuario
            $productCode    = $_POST['productCode'];
            $quantity       = $_POST['quantity'];
            $price          = $_POST['price'];
            $amountPending  = $_POST['amountPending'];
            //Envia los datos al modelo para crear la nueva orden de compra
            $orderNumber = $model->createNewOrder($productCode, $quantity, $price, $customerNumber, $amountPending);
            //Si se crea correctamente, envia a la vista el id de la orden de compra
            if ($orderNumber != false) {

                $data = (object) [
                    'orderNumber' => $orderNumber,
                ];

                $this->resolve(false, 'ok', $data);
            } else {
                $this->resolve(true, 'Algo fallo al crear la orden de compra');
            }
        }

        require_once('../views/orders/formOrders.php');
    }
    //Función que se encarga de recoger los datos enviados por el usuario
    //Para enviarlos al modelo y que se guarden las fechas
    public function finallyOrder()
    {

        $model = new ModelOrders;

        if (isset($_POST) && !empty($_POST)) {
            //Se recogen los datos enviados por el usuario
            $shippedDate     = $_POST['shippedDate'];
            $requiredDate    = $_POST['requiredDate'];
            $orderNumber     = $_POST['orderNumber'];
            $customerNumber  = $_POST['customerNumber'];
            //Se envia los datos al modelo para que almacene la fechas
            $addDate = $model->finallyOrder($shippedDate, $requiredDate, $orderNumber);
            //Si se guardan con exito, se crea una url
            if ($addDate) {

                $data = (object) [
                    'url' => 'presentatorOrders.php?action=successOrder&orderNumber=' . $orderNumber
                ];

                $this->resolve(false, 'ok', $data);
            } else {
                $this->resolve(true, 'Algo fallo al guardar las fechas');
            }
        }
    }
    //Función la cual muestra la vista de orden exitosa, cuando la orden de compra se crea exitosamente
    public function successOrder($orderNumber)
    {
        $id = $orderNumber;
        require_once('../views/orders/successOrder.php');
    }
    //Función para traer la vista y poder generar el pdf con los datos requeridos
    public function pdf($orderNumber)
    {
        $model        = new ModelOrders;
        $data         = $model->getInfoOrder($orderNumber);
        $orderDetail  = $model->getDetailOrder($orderNumber);
        require_once('../views/formats/ordenDeServicio.php');
    }
    //Función que renderiza la vista para realizar modificación a la orden de compra
    public function updateOrder($orderNumber)
    {
        $fecha = date('Y-m-d');
        $model  = new ModelOrders;
        $data   = $model->getOrderById($orderNumber);
        require_once('../views/orders/formUpdate.php');
    }
    //Función para mandar los datos al modelo y realizar la modificación del orden de compra
    public function saveUpdate()
    {
        $model = new ModelOrders;
        //Recoge los datos enviados por el usuario
        $orderNumber    = $_POST['orderNumber'];
        $requiredDate   = $_POST['requiredDate'];
        $shippedDate    = $_POST['shippedDate'];
        $status         = $_POST['status'];
        $comments       = $_POST['comments'];
        $customerNumber = $_POST['customerNumber'];

        $data = $model->updateOrder($orderNumber,$requiredDate,$shippedDate,$status,$comments);

        if ($data) {
            $data = (object) [
                'url' => 'presentatorCustomers.php?action=infoCustomer&customerNumber='.$customerNumber
            ];

            $this->resolve(false,'ok',$data);
        } else {
            $this->resolve(false,'algo fallo al realizar la modificación del pago');
        }

    }
}
//Se inicializa una variable para poder usar el controlador de orden
$presentatorOrder = new PresentatorOrders;
//Si se recibe por medio del get una acción, la almacena en una variable
if (isset($_GET['action'])) {

    $action = $_GET['action'];
    //Segun la acción solicitada llama la función requerida
    switch ($action) {
        case 'createNewOrder':
            if (isset($_GET['customerNumber'])) {
                $id = $_GET['customerNumber'];
                $presentatorOrder->createNewOrder($id);
            } else {
                echo 'Página no encontrada';
            }
            break;
        case 'addDate';
            $presentatorOrder->finallyOrder();
            break;
        case 'successOrder':
            if (isset($_GET['orderNumber'])) {
                $orderNumber = $_GET['orderNumber'];
                $presentatorOrder->successOrder($orderNumber);
            } else {
                echo 'Página no encontrada';
            }
            break;
        case 'pdf';
            if (isset($_GET['orderNumber'])) {
                $orderNumber = $_GET['orderNumber'];
                $presentatorOrder->pdf($orderNumber);
            }
            break;
        case 'updateOrder':
            if (isset($_GET['orderNumber'])) {
                $orderNumber = $_GET['orderNumber'];
                $presentatorOrder->updateOrder($orderNumber);
            } else {
                echo 'Página no encontrada';
            }
            break;
        case 'saveUpdate':
            $presentatorOrder->saveUpdate();
            break;
    }
}else{
    echo 'página no encontrada';
}
