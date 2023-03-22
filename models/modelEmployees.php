<?php
//Se llama la clase conexion
require_once ("../core/conexion.php");

Class ModelEmployees extends Conexion
{
    //Función para traer de la bd todos los empleados
    public function readEmployees()
    {
        //Se crea una variable donde se almacena la consulta
        $sql = "SELECT employeeNumber,lastName,firstName,extension,email,officeCode,reportsTo,jobTitle  
                FROM employees";
        //Se ejecuta la consulta
        $results = mysqli_query($this->conexion,$sql);
        //Se incializa la variable employees como un arreglo
        $employees = array();

        while($row = mysqli_fetch_assoc($results)){
            //Se guardan los datos que arrojo la bd en la variable employees
            $employees[] = $row;
        }
        //Retornamos la variable employees
        return $employees;
    }
    //Función para traer un empleado segun su id
    public function employeeById($id = null)
    {
        //Se crea una variable donde se almacena la consulta
        $sql = "SELECT concat(e.firstName,' ',e.lastName) as employee,e.jobTitle,concat(r.firstName,' ',r.lastName) as reportPerson,
                o.phone,concat(o.city,' ',o.country,', ',o.addressLine1,' ',o.addressLine2) as infoaddress
                FROM employees e
                LEFT JOIN employees r ON e.reportsTo = r.employeeNumber
                INNER JOIN offices  o ON e.officeCode = o.officeCode
                WHERE e.employeeNumber = $id";
        //Se ejecuta la consulta
        $result = mysqli_query($this->conexion,$sql);
        //Retornamos el resutado de la consulta
        return mysqli_fetch_assoc($result);
    }

}