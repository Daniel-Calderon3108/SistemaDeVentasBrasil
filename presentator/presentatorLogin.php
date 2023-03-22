<?php
//Si existe una sesión, se encarga de eliminar los datos de la sesión
session_start();
if (isset($_SESSION['customerNumber'])) {
    unset($_SESSION['customerNumber']);
    unset($_SESSION['id']);
    header("Location: presentatorLogin.php?action=login");
}
//Se trae el modelo de login para su posterior uso
require_once("../models/modelLogin.php");

class PresentatorLogin
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
    }
    //Función que incluye la vista de inicio de sesión
    public function login()
    {
        include('../views/login.php');
    }
    //Función que se encarga de recibir por el get el correo y contraseña enviadas por el usuario
    public function validateLogin($email, $password)
    {
        $model  = new ModelLogin;
        $login  = $model->login($email, $password);
        //Si los datos enviados por el usuario son correctos crea una sesión
        if ($login != false) {
            //Se crea el id de la sesión
            $_SESSION['id'] = session_create_id();
            //Se trae el id del empleado que se logeo
            $_SESSION['EmployeeNumber'] = $login;
            //Se crea la url para redirigirnos a la vista de inicio
            $url = 'presentatorEmployees.php?action=index';
            $this->resolve(false, 'Ok',$url);
        } else {
            $this->resolve(true, 'Correo ó Clave son incorrectos');
        }
    }
}
//Se inicializa una variable para poder usar el controlador de login
$presentatorLogin = new PresentatorLogin;
//Si se recibe por medio del get una acción, la almacena en una variable
if (isset($_GET['action'])) {
    $action = $_GET['action'];
    //Segun la acción solicitada llama la función requerida
    switch ($action) {
        case 'login';
            $presentatorLogin->login();
            break;

        case 'validateLogin';
            $email = $_POST['email'];
            $password = $_POST['password'];
            $presentatorLogin->validateLogin($email, $password);
            break;
    }
}else{
    echo 'página no encontrada';
}
