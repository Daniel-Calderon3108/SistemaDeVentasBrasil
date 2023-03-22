<?php
//Se trae el archivo de conexion para poder usarlo
require_once('../core/conexion.php');

class ModelOrders extends Conexion
{
    //Función que se encarga de traer el detalle de una orden de compra por medio del número de orden de compra
    public function getDetailOrder($orderNumber)
    {
        $sql = "SELECT od.quantityOrdered,od.priceEach,p.productName,p.productLine,
                quantityOrdered * priceEach as total 
                FROM orderdetails od
                INNER JOIN orders o USING(orderNumber)
                INNER JOIN products p USING(productCode)
                WHERE od.orderNumber = $orderNumber";
        $result = mysqli_query($this->conexion, $sql);
        $ordersDetails = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $ordersDetails[] = $row;
        }

        return $ordersDetails;
    }
    //Función que se encarga de traer el limite de crédito de un cliente por medio del id del cliente
    //Para luego verificar si el cliente al generar la orden de compra no se pase del limite
    public function getCreditLimit($customerNumber)
    {
        $sql = "SELECT creditLimit FROM customers WHERE customerNumber = $customerNumber";
        $result = mysqli_query($this->conexion, $sql);

        return mysqli_fetch_assoc($result);
    }
    //Función que se encarga de crear una nueva orden de compra y realizar una seria de pasos, que se mostraran a continuación
    //Para crear una nueva orden de compra se requiere el codigo del producto, la cantidad y precio por producto, id del cliente 
    //y el valor total de la nueva orden de compra 
    public function createNewOrder($product_code, $quantity, $price, $customerNumber, $amountPending)
    {
        //1. Se obtiene la fecha actual, la cual sera la fecha en la que se realizó la orden de compra
        $fecha = date('y-m-d');

        //2. Se descuenta del crédito limite del cliente, el valor total de la orden de compra
        $sql = "UPDATE customers SET creditLimit = creditLimit - $amountPending WHERE customerNumber = $customerNumber";
        $result = mysqli_query($this->conexion, $sql);

        if ($result) {
            //3. Si la query se ejecuta correctamente, se trae el ultimo id de orden de compra registrado
            $sql = "SELECT orderNumber FROM orders ORDER BY 1 DESC";
            $result = mysqli_query($this->conexion, $sql);

            $data = mysqli_fetch_assoc($result);
            //4. Se agrega el nuevo id para la orden de compra a registrar en una una variable
            $orderNumber = $data['orderNumber'] + 1;
            //5. Se registra la nueva orden de compra
            $sql = "INSERT INTO orders (orderNumber,orderDate,customerNumber,status,statusPayment,amountPending) 
                VALUES ($orderNumber,'$fecha',$customerNumber,'In Process','pending',$amountPending)";
            $result = mysqli_query($this->conexion, $sql);

            if ($result) {
                //6. Se realiza un ciclo for, para crear el detalle de la orden de compra
                for ($i = 0; $i < count($product_code); $i++) {

                    $orderLineNumber = $i + 1;
                    //7. Se registran cada uno de los productos seleccionados por el usuario en la tabla de detalle de orden de compra
                    $sql = "INSERT INTO orderdetails (orderNumber,productCode,quantityOrdered,priceEach,orderLineNumber) 
                        VALUES ('$orderNumber','$product_code[$i]','$quantity[$i]','$price[$i]','$orderLineNumber')";
                    $result = mysqli_query($this->conexion, $sql);
                }
                //7. Si toda se ejecuta correctamente, se retorna el id de la orden de compra, en caso que algo falle, se retorna falso
                if ($result) {
                    return $orderNumber;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
    //Función la cual se encarga de modificar la orden de compra, agregando la fecha en la que sera enviado los productos 
    //y la fecha en la que el cliente debe recibirlo
    public function finallyOrder($shippedDate, $requiredDate, $orderNumber)
    {
        $sql = "UPDATE orders SET shippedDate = '$shippedDate',requiredDate = '$requiredDate'
                WHERE orderNumber = $orderNumber";
        $result = mysqli_query($this->conexion, $sql);

        if ($result) {
            return true;
        } else {
            return false;
        }
    }
    //Función en la que se obtiene toda la información de una orden de compra
    public function getInfoOrder($orderNumber)
    {
        $sql = "SELECT o.orderDate,o.requiredDate,o.shippedDate,c.customerNumber,o.orderNumber,
               concat(c.contactFirstName,' ',c.contactLastName) as customerNameComplete,o.statusPayment,o.amountPending
               FROM orders o INNER JOIN customers c USING(customerNumber) 
               WHERE o.orderNumber = $orderNumber";
        $result = mysqli_query($this->conexion, $sql);

        return mysqli_fetch_assoc($result);
    }
    //Función que trae los datos de la orden a editar
    public function getOrderById($orderNumber)
    {
        $sql = "SELECT orderNumber,customerNumber,requiredDate,shippedDate,status,comments FROM orders WHERE orderNumber = $orderNumber";
        $result = mysqli_query($this->conexion,$sql);
        
        return mysqli_fetch_assoc($result);
    }

    //Función para modificar la orden de compra, ya sea cambiar la fecha de envio del producto, fecha en la que recibe el cliente
    //Estado del pedido o agregar comentarios
    public function updateOrder($orderNumber,$requiredDate,$shippedDate,$status,$comments)
    {
        $sql = "UPDATE orders SET requiredDate = '$requiredDate',shippedDate = '$shippedDate',status = '$status',comments = '$comments' 
                WHERE orderNumber = $orderNumber";
        $result = mysqli_query($this->conexion,$sql);

        if ($result) {
            return true;
        } else {
            return false;
        }
    }
}
