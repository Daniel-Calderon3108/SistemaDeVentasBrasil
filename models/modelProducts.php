<?php
//Se trae el archivo de conexion para poder usarlo
require_once('../core/conexion.php');
class ModelProducts extends Conexion
{
    //Función que se encarga de traer todos los productos registrados en la base de datos
    //Segun la sugerencia del nombre de los productos
    public function getProducts($search)
    {
        $sql = "SELECT productCode,productName FROM products WHERE productName LIKE '%$search%'";
        $result = mysqli_query($this->conexion,$sql);
        $products = array();
        while ($row = mysqli_fetch_assoc($result)){
            $products[] = $row;
        }
        return $products;
    }
}