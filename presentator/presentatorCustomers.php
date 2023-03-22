<?php
//Se verifica que se haya iniciado sesión, de no ser así se manda al inicio de sesión
session_start();
if (!isset($_SESSION['EmployeeNumber'])) {
    header('Location:presentatorLogin.php?action=login');
}
//Se trae el modelo de clientes para su posterior uso
require_once('../models/modelCustomers.php');

class PresentatorCustomers
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
    //Función que en lista a todos los clientes 
    public function listCustomers()
    {
        require_once('../views/customers/index.php');
    }
    //Función la cual se encarga de enviar al modelo el id, el nombre y el apellido del cliente
    //Si el modelo devuelve la lista de clientes, la envia a la vista
    public function searchCustomers($id, $nombre, $apellido)
    {
        $model  = new ModelCustomers;
        $data   = $model->searchCustomers($id, $nombre, $apellido);

        $this->resolve(false, 'ok', $data);
    }
    //Función que se encarga cargar la vista de crear clientes
    //Posteriormente si recibe datos por medio del post,
    //Envia esos datos al modelo para crear el cliente
    public function createCustomer()
    {
        $model = new ModelCustomers;

        if (isset($_POST) && !empty($_POST)) {
            //Captura todos los datos enviados en la vista
            $customer        = $_POST['customerName'];
            $name            = $_POST['contactFirstName'];
            $lastName        = $_POST['contactLastName'];
            $phone           = $_POST['phone'];
            $address1        = $_POST['address1'];
            $address2        = $_POST['address2'];
            $city            = $_POST['city'];
            $state           = $_POST['state'];
            $postalCode      = $_POST['postalCode'];
            $country         = $_POST['country'];
            $employeeNumber  = $_SESSION['EmployeeNumber'];
            $creditLimit     = $_POST['creditLimit'];
            //Envia los datos al modelo para crear el cliente
            $create = $model->createCustomer($customer, $name, $lastName, $phone, $address1, $address2, $city, $state, $postalCode, $country, $employeeNumber, $creditLimit);
            //Si se crea correctamente, devuelve a la vista, el id del cliente, y una url para redirigir
            if ($create != false) {

                $data = (object)[
                    'id' => $create,
                    'url' => 'presentatorCustomers.php?action=infoCustomer&customerNumber=' . $create
                ];

                $this->resolve(false, 'Cliente creado con exito', $data);
            } else {
                $this->resolve(true, 'Ocurrio un error al crear el cliente');
            }
        }
        $data = '';
        require_once('../views/customers/formCustomer.php');
    }
    //Función que se encarga de traer toda la información de un cliente en especifico
    //Así como todas las ordenes de compra y pagos que le pertenecen
    public function InfoCustomer($id)
    {
        $model     = new ModelCustomers;
        $data      = $model->getInfoCustomer($id);
        $orders    = $model->getOrdersByCustomer($id);
        $payments  = $model->getPaymentsByCustomer($id);

        require_once('../views/customers/infoCustomer.php');
    }
    //Función que se encarga de traer los datos del cliente a modificar y cargarlos en la vista
    public function updateCustomer($id)
    {
        $model = new ModelCustomers;

        $data = $model->getCustomerById($id);
        require_once('../views/customers/formCustomer.php');
    }
    //Función la cual recibe datos por medio del post, para mandarlos al modelo para modificar al cliente
    public function updateSave()
    {
        $model = new ModelCustomers;
        //Recoje todos los datos que envia la vista
        $customer        = $_POST['customerName'];
        $name            = $_POST['contactFirstName'];
        $lastName        = $_POST['contactLastName'];
        $phone           = $_POST['phone'];
        $address1        = $_POST['address1'];
        $address2        = $_POST['address2'];
        $city            = $_POST['city'];
        $state           = $_POST['state'];
        $postalCode      = $_POST['postalCode'];
        $country         = $_POST['country'];
        $creditLimit     = $_POST['creditLimit'];
        $customerNumber  = $_POST['customerNumber'];
        //Envia los datos al modelo para modificar el cliente
        $update = $model->updateCustomer($customer, $name, $lastName, $phone, $address1, $address2, $city, $state, $postalCode, $country, $creditLimit, $customerNumber);
        //Si se modifica correctamente, devuelve a la vista, una url para redirigir
        if ($update != false) {

            $data = (object)[
                'url' => 'presentatorCustomers.php?action=infoCustomer&customerNumber=' . $customerNumber
            ];

            $this->resolve(false, 'Cliente modificado con exito', $data);
        } else {
            $this->resolve(true, 'Ocurrio un error al modificar el cliente');
        }
    }
}
//Se inicializa una variable para poder usar el controlador de cliente
$presentatorCustomers = new PresentatorCustomers;
//Si se recibe por medio del get una acción, la almacena en una variable
if (isset($_GET['action'])) {
    $action = $_GET['action'];
    //Segun la acción solicitada llama la función requerida
    switch ($action) {

        case 'index';
            $presentatorCustomers->listCustomers();
            break;
        case 'search';
            $id = $_GET['id'];
            $nombre = $_GET['nombre'];
            $apellido = $_GET['apellido'];
            $presentatorCustomers->searchCustomers($id, $nombre, $apellido);
            break;
        case 'create';
            $presentatorCustomers->createCustomer();
            break;
        case 'infoCustomer':
            if (isset($_GET['customerNumber'])) {
                $id = $_GET['customerNumber'];
                $presentatorCustomers->InfoCustomer($id);
            } else {
                echo 'Página no encontrada';
                die;
            }
            break;
        case 'update':
            $id = $_GET['customerNumber'];
            $presentatorCustomers->updateCustomer($id);
            break;
        case 'updateSave':
            $presentatorCustomers->updateSave();
            break;
    }
}else{
    echo 'página no encontrada';
}
