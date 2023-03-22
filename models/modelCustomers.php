<?php
//Se trae el archivo de conexion para poder usarlo
require_once("../core/conexion.php");

class ModelCustomers extends Conexion
{
    //Función la cual se encarga de traer los clientes, ya sea por el id, el nombre o el apellido
    //Al final retorna en un arreglo los datos que trae la base de datos
    public function searchCustomers($id,$name,$lastName)
    {
        //Se inicializa la variable condición
        $condition = "";

        //Si el id viene lleno, se agrega la condición de el id a la consulta
        if($id != ""){

            $condition = " WHERE c.customerNumber = $id";
            //Si el nombre viene lleno, se agrega la condición de el nombre a la consulta
            if($name != ""){

                $condition .= " AND c.contactFirstName ='$name'";
                    if($lastName != ""){
                        //Si el apellido viene lleno, se agrega la condición de el apellido a la consulta
                        $condition .= " AND c.contactLastName = '$lastName'";
                    }
            //Se repito los mismos paso, para generar las condiciones que deben cumplirse para la consulta
            }else if($lastName != ""){
                $condition .= " AND c.contactLastName = '$lastName'";
            }
        }else if($name != ""){
            $condition .= " WHERE c.contactFirstName = '$name'";

            if($lastName !=""){
                $condition .= " AND c.contactLastName = '$lastName'";
            }
        }else if($lastName !=""){
            $condition = " WHERE c.contactLastName = '$lastName'";
        }
        //Se crea la consulta
        $sql = "SELECT c.customerNumber,c.customerName,concat(c.contactFirstName,' ',c.contactLastName) as customerCompleteName,
                c.phone,c.addressLine1,c.addressLine2,c.city,c.state,c.postalCode,c.country,
                concat(e.firstName,' ',e.lastName) as employee,c.creditLimit
                FROM customers c
                LEFT JOIN employees e ON c.salesRepEmployeeNumber  = e.employeeNumber
                $condition";
        //Se ejecuta la consulta
        $result = mysqli_query($this->conexion,$sql);
        //Se inicializa la variable customers como un arreglo
        $customers = array();
        while ($row = mysqli_fetch_assoc($result)){
            //Se agrega a la variable customers los datos que hayan sido traidos de la base de datos
            $customers[] = $row;
        }
        //Se retorna la variable customers
        return $customers;
    }
    //Función para crear un nuevo cliente, recibe los parametros necesarios para realizar la insersión
    public function createCustomer($customer,$name,$lastName,$phone,$addres1,$addres2,$city,$state,$postalCode,$country,$employeeNumber,$creditLimit)
    {
        //Se realiza una consulta previa para saber cual es el ultimo id de cliente registrado en la base de datos
        $sql = "SELECT customerNumber FROM customers ORDER BY 1 DESC";
        $result = mysqli_query($this->conexion,$sql);

        $data = mysqli_fetch_assoc($result);
        //Se inicializa una variable llamada id, la cual almacena el nuevo id del cliente que vamos a registrar
        $id = $data['customerNumber'] + 1;

        //Se realiza la query para la creación del cliente
        $sql = "INSERT INTO customers (customerNumber,customerName,contactLastName,contactFirstName,phone,addressLine1,addressLine2,city,state,postalCode,country,salesRepEmployeeNumber,creditLimit)
                VALUES ($id,'$customer','$lastName','$name','$phone','$addres1','$addres2','$city','$state','$postalCode','$country','$employeeNumber','$creditLimit')";
        $result = mysqli_query($this->conexion,$sql);
        //Si la inserción es exitosa, se retorna el id del cliente
        if($result){
            return $id;
        }else{
            return false;
        }
    }
    //Función la cual trae toda la información de un cliente especifico por medio del id del Cliente
    public function getInfoCustomer($id)
    {
        $sql = "SELECT c.customerNumber,c.customerName,c.contactFirstName,c.contactLastName,
                c.phone,c.addressLine1,c.addressLine2,c.city,c.state,c.postalCode,c.country,
                concat(e.firstName,' ',e.lastName) as employee,c.creditLimit
                FROM customers c
                LEFT JOIN employees e ON c.salesRepEmployeeNumber  = e.employeeNumber 
                WHERE c.customerNumber = $id";
        $result = mysqli_query($this->conexion,$sql);
        
        return mysqli_fetch_assoc($result);
    }
    //Función la cual se encarga de traer todas las ordenes de compra que tenga un cliente
    public function getOrdersByCustomer($id)
    {
        $sql = "SELECT orderNumber,orderDate,requiredDate,shippedDate,status,statusPayment FROM orders
                WHERE customerNumber = $id
                ORDER BY orderNumber DESC";
        $result = mysqli_query($this->conexion,$sql);
        $orders = array();
        while($row = mysqli_fetch_assoc($result)){
            $orders[] = $row;
        }
        return $orders;
    }
    //Función la cual se encarga de traer todos los pagos realizados por un cliente
    public function getPaymentsByCustomer($id)
    {
        $sql = "SELECT checkNumber,paymentDate,amount FROM payments 
                WHERE customerNumber = $id 
                ORDER BY paymentDate DESC";
        $result = mysqli_query($this->conexion,$sql);
        $payments = array();
        while($row = mysqli_fetch_assoc($result)){
            $payments[] = $row;
        }
        return $payments;
    }
    //Función la cual trae los datos de un cliente, para luego realizar la modificación
    public function getCustomerById($id)
    {
        $sql = "SELECT customerNumber,customerName,contactLastName,contactFirstName,phone,addressLine1,addressLine2,city,
                state,postalCode,country,creditLimit 
                FROM customers WHERE customerNumber = $id";
        $result = mysqli_query($this->conexion,$sql);

        return mysqli_fetch_assoc($result);
    }
    //Función que modifica el cliente, ya sea por el alias, el nombre, el apellido, el teléfono, las direcciones, ciudada, estado, código postal, país o crédito limite
    public function updateCustomer($customer,$name,$lastName,$phone,$address1,$address2,$city,$state,$postalCode,$country,$creditLimit,$customerNumber)
    {
        $sql = "UPDATE customers SET customerName='$customer',contactLastName='$lastName',contactFirstName='$name',phone='$phone',addressLine1='$address1',
                addressLine2='$address2',city='$city',state='$state',postalCode='$postalCode',country='$country',creditLimit='$creditLimit'
                WHERE customerNumber=$customerNumber";
        $result = mysqli_query($this->conexion,$sql);
        if($result){
            return true;
        }else{
            return false;
        }
    }
}