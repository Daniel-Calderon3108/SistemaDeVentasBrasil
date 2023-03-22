<?php
//Se verifica que se haya iniciado sesión, de no ser así se manda al inicio de sesión
session_start();
if (!isset($_SESSION['EmployeeNumber'])) {
    header('Location:presentatorLogin.php?action=login');
}
//Se trae el modelo de pagos para su posterior uso
require_once('../models/modelPayments.php');

class PresentatorPayments
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
    //Función que carga la vista index de pagos
    public function Index()
    {
        require_once('../views/payments/index.php');
    }
    //Función que se encarga de cargar la vista y 
    //enviar a la vista la información de todas las ordenes de compra pendientes por pagar
    public function getOrderPending($customerNumber, $orderNumber,$contactLastName)
    {
        $model  = new ModelPayments;
        $data   = $model->getOrderPending($customerNumber, $orderNumber,$contactLastName);

        $this->resolve(false, 'ok', $data);
    }
    //Función que se encarga de cargar la vista de nuevo pago
    public function create($orderNumber)
    {
        $model  = new ModelPayments;
        $data   = $model->orderPending($orderNumber);
        require_once('../views/payments/formPayment.php');
    }
    //Función que recoge los datos enviados por el usuario y los envia al modelo para crear el nuevo pago
    public function savePayment()
    {
        $model = new ModelPayments; 
        //Recoge todos los datos enviados por el usuario
        $customerNumber  = $_POST['customerNumber'];
        $orderNumber     = $_POST['orderNumber'];
        $amount          = $_POST['amount'];
        $methodPayment   = $_POST['methodPayment'];
        //Envia los datos al modelo para crear el nuevo pago
        $result = $model->savePayment($customerNumber,$orderNumber,$amount,$methodPayment);
        //Si se crea correctamente, crea la url para redigirigirse
        if($result != false){
            $data = 'presentatorPayments.php?action=successPayment&checkNumber='.$result;
            $this->resolve(false,'guardado con exito',$data);
        }else{
            $this->resolve(true,'Algo fallo al guardar el pago');
        }
    }
    //Función la cual muestra la vista de pago exitoso, cuando el pago se crea exitosamente
    public function successPayment($checkNumber)
    {
        $id = $checkNumber;
        require_once('../views/payments/successPayment.php');
    }
    //Función para traer la vista y poder generar el pdf con los datos requeridos
    public function pdf($checkNumber)
    {
        $model = new ModelPayments;
        $data = $model->getInfoPayment($checkNumber);
        require_once('../views/formats/reciboPago.php');
    }
    //Función que renderiza la vista de pagos, con los datos que trae el modelo, para poder modificar el pago
    public function updatePayment($checkNumber)
    {
        $model = new ModelPayments;
        $data  = $model->getPaymentById($checkNumber);

        require_once('../views/payments/formPayment.php');
    }
    //Función para mandar los datos al modelo y realizar la modificación del pago
    public function saveUpdate()
    {
        $model = new ModelPayments;

        $customerNumber = $_POST['customerNumber'];
        $orderNumber = $_POST['orderNumber'];
        $amount = $_POST['amount'];
        $methodPayment = $_POST['methodPayment'];
        $olderAmount = $_POST['olderAmount'];
        $checkNumber = $_POST['checkNumber'];


        $result = $model->saveUpdate($customerNumber,$orderNumber,$amount,$methodPayment,$olderAmount,$checkNumber);
    
        if ($result) {
            $data = (object) [
                'url' => 'presentatorCustomers.php?action=infoCustomer&customerNumber='.$customerNumber
            ];

            $this->resolve(false,'ok',$data);
        } else {
            $this->resolve(true,'algo fallo al realizar la modificación del pago');
        }

    }
}
//Se inicializa una variable para poder usar el controlador de pagos
$presentatorPayments = new PresentatorPayments;
//Si se recibe por medio del get una acción, la almacena en una variable
if (isset($_GET['action'])) {
    //Segun la acción solicitada llama la función requerida
    $action = $_GET['action'];

    switch ($action) {
        case 'index':
            $presentatorPayments->Index();
            break;
        case 'search':
            $customerNumber = $_GET['customerNumber'];
            $contactLastName = $_GET['contactLastName'];
            $orderNumber = $_GET['orderNumber'];
            $presentatorPayments->getOrderPending($customerNumber, $orderNumber,$contactLastName);
            break;
        case 'create':
            if(isset($_GET['orderNumber'])){
                $orderNumber = $_GET['orderNumber'];
                $presentatorPayments->create($orderNumber);
            }else{
                echo 'Página no encontrada';
            }
            break;
        case 'savePayment':
            $presentatorPayments->savePayment();
            break;
        case 'successPayment':
            if(isset($_GET['checkNumber'])){
                $checkNumber = $_GET['checkNumber'];
                $presentatorPayments->successPayment($checkNumber);
            }else{
                echo 'Página no encontrada';
            }
            break;
        case 'pdf':
            if(isset($_GET['checkNumber'])){
                $checkNumber = $_GET['checkNumber'];
                $presentatorPayments->pdf($checkNumber);
            }else{
                echo 'Página no encontrada';
            }
            break;
        case 'updatePayment':
            if (isset($_GET['checkNumber'])) {
                $checkNumber = $_GET['checkNumber'];
                $presentatorPayments->updatePayment($checkNumber);
            } else {
                echo 'Página no encontrada';
            }
            break;
        case 'saveUpdate':
            $presentatorPayments->saveUpdate();
            break;
    }
}
