<?php
//Se verifica que se haya iniciado sesión, de no ser así se manda al inicio de sesión
session_start();
if (!isset($_SESSION['EmployeeNumber'])) {
    header('Location:presentatorLogin.php?action=login');
}
//Se llama el modelo employees y luego se almacena en una variable
require_once("../models/modelEmployees.php");

class PresentatorEmployees
{
    //Función la cual nos trae el empleado que se logeo y carga la página de inicio, 
    //la cual sale despues de logearnos
    public function home()
    {
        $id = $_SESSION['EmployeeNumber'];
        $model = new ModelEmployees;
        $data = $model->employeeById($id);
        require_once("../views/home.php");
    }
}

$presentator = new PresentatorEmployees;

//Se virifica que venga por parametro action
if (isset($_GET['action'])) {
    $action = $_GET['action'];
    //Se realiza un switch segun el action que llegue por get
    switch ($action) {
        //Si en el action llega el valor index, se trae la info del empleado que se haya logeado
        //y luego se carga la página
        case "index";
            $presentator->home();
            break;
    }
}else{
    echo 'página no encontrada';
}