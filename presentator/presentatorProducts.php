<?php
//Se verifica que se haya iniciado sesión, de no ser así se manda al inicio de sesión
session_start();
if (!isset($_SESSION['EmployeeNumber'])) {
    header('Location:presentatorLogin.php?action=login');
}
//Se trae el modelo de productos para su posterior uso
require_once('../models/modelProducts.php');

class PresentatorProducts
{
    //Función que devuelve un json con el id y nombre del producto,
    //segun la coincidencias de nombre del producto
    public function resolve($data)
    {
       $json = [];
       foreach($data as $row){
            $json[] = [
                'id' => $row['productCode'],
                'text' => $row['productName']
            ];
       }

       echo json_encode($json);
    }
    //Función para traer todos los productos
    public function getProducts($search)
    {
        $model  = new ModelProducts;
        $data   = $model->getProducts($search);
        $this->resolve($data);
    }
}
//Se inicializa una variable para poder usar el controlador de productos
$presentatorProducts = new PresentatorProducts;

if(isset($_GET['action'])){
    $action = $_GET['action'];
    //Segun la acción solicitada llama la función requerida
    switch($action){

        case 'getProducts':
            $search = $_GET['q'];
            $presentatorProducts->getProducts($search);
            break;
    }
}