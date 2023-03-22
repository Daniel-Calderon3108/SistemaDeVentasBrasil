<?php
//Se trae el archivo de conexion para poder usarlo
require_once('../core/conexion.php');
class ModelPayments extends Conexion
{
    //Función que se encarga de traer todas las ordenes pendientes por pagar
    //Ya sea por el id del cliente, el apellido del cliente o el número de orden de compra
    public function getOrderPending($customerNumber, $orderNumber, $contactLastName)
    {
        $condition = '';

        if ($customerNumber != '') {
            $condition .= 'AND c.customerNumber =' . $customerNumber;
        }

        if ($contactLastName != '') {
            $condition .= 'AND c.contactLastName ="' . $contactLastName . '"';
        }

        if ($orderNumber != '') {
            $condition .= 'AND orderNumber =' . $orderNumber;
        }

        $sql = "SELECT orderNumber,orderDate,shippedDate,requiredDate,status,amountPending,
                concat(c.contactFirstName,' ',c.contactLastName) as customerCompleteName,c.customerNumber
                FROM orders
                INNER JOIN customers c USING(customerNumber) 
                WHERE statusPayment = 'pending' $condition";
        $result = mysqli_query($this->conexion, $sql);
        $ordersPending = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $ordersPending[] = $row;
        }

        return $ordersPending;
    }
    //Función que se encarga de traer el número de orden de compra, el valor pendiente
    //y nombre del cliente al que le corresponde la orden de compra
    public function orderPending($orderNumber)
    {
        $sql = "SELECT orderNumber,amountPending,concat(c.contactFirstName,' ',c.contactLastName) as customerNameComplete,c.customerNumber 
                FROM orders 
                INNER JOIN customers c USING(customerNumber)
                WHERE orderNumber = $orderNumber";
        $result = mysqli_query($this->conexion, $sql);

        return mysqli_fetch_assoc($result);
    }
    //Función que se encarga de guardar la información del pago realizado
    //Siguiendo una serie de pasos explicados a continuación
    //Para guardar el pago, se requiere el id del cliente, el id de la orden de compra y el valor a pagar
    public function savePayment($customerNumber, $orderNumber, $amount, $methodPayment)
    {
        //1. Se crea el número único de check del pago, por medio del minuto y segundo en el que se realiza el pago, 2 números
        //y el id de la orden de compra
        $dato = date('is');
        $checkNumber = "RD" . $orderNumber . $dato;
        //2. Se trae la fecha en la que se realiza el pago
        $fecha = date('y-m-d');
        //3. Se realiza una actualización en el crédito limite del cliente sumando el valor del pago
        $sql = "UPDATE customers SET creditLimit = creditLimit + $amount WHERE customerNumber = $customerNumber";
        $result = mysqli_query($this->conexion, $sql);

        if ($result) {
            //4. Se inserta en la tabla de pagos, la información del pago
            $sql = "INSERT INTO payments (customerNumber,checkNumber,paymentDate,amount,methodPayment,orderNumber)
                    VALUES ($customerNumber,'$checkNumber','$fecha',$amount,'$methodPayment',$orderNumber)";
            $result = mysqli_query($this->conexion, $sql);

            if ($result) {
                //5. Se resta al saldo pendiente de la orden de compra, el valor pagado
                $sql = "UPDATE orders SET amountPending = amountPending - $amount 
                        WHERE orderNumber = $orderNumber";
                $result = mysqli_query($this->conexion, $sql);

                if ($result) {
                    //6. Se consulta cuando se esta debiendo de saldo en la orden de compra
                    $sql = "SELECT amountPending FROM orders WHERE orderNumber = $orderNumber";
                    $record = mysqli_query($this->conexion, $sql);

                    if ($record) {

                        $result = mysqli_fetch_assoc($record);
                        //7. Si ya no se debe nada, se realiza una actualización a la orden de compra, 
                        //para que cambie el estado a pagado
                        if ($result['amountPending'] == 0) {

                            $sql = "UPDATE orders SET statusPayment = 'pay' WHERE orderNumber = $orderNumber";
                            $result = mysqli_query($this->conexion, $sql);
                        }
                        //8. Si todos los procesos mencionados anteriormente se realizan correctamente,
                        //se retorna el número único de check del pago, en caso que alguno falle se retorna falso
                        return $checkNumber;
                    } else {
                        return false;
                    }
                }
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
    //Se trae toda la información de un pago en especifico, buscandolo por el número único del check de pago
    public function getInfoPayment($checkNumber)
    {
        $sql = "SELECT o.orderNumber,o.orderDate,concat(c.contactFirstName,' ',c.contactLastName) as customerNameComplete,
                c.customerNumber,methodPayment,o.amountPending,checkNumber,amount
                FROM payments p
                LEFT JOIN orders o USING(orderNumber)
                INNER JOIN customers c ON p.customerNumber = c.customerNumber
                WHERE checkNumber = '$checkNumber'";
        $result = mysqli_query($this->conexion, $sql);
        return mysqli_fetch_assoc($result);
    }
    //Función que trae los datos de los pagos para luego ser modificados
    public function getPaymentById($checkNumber)
    {
        $sql = "SELECT p.customerNumber,checkNumber,amount,methodPayment, amountPending,
                concat(c.contactFirstName,' ',c.contactLastName) as customerNameComplete,o.orderNumber
                FROM payments p
                INNER JOIN customers c ON p.customerNumber = c.customerNumber
                LEFT JOIN orders o ON p.OrderNumber = o.orderNumber 
                WHERE checkNumber = '$checkNumber'";
        $result = mysqli_query($this->conexion,$sql);

        return mysqli_fetch_assoc($result);
    }
    //Función para actualizar los datos del pago, ademas de realizar unos cambios en 
    //las tablas de clientes y orden de compra explicadas a continuación
    public function saveUpdate($customerNumber,$orderNumber,$amount,$methodPayment,$olderAmount,$checkNumber)
    {
        //1. Se realiza modificación el la tabla payments
        $sql = "UPDATE payments SET amount = $amount,methodPayment = '$methodPayment' WHERE checkNumber = '$checkNumber'";
        $result = mysqli_query($this->conexion,$sql);

        if ($result) {
            //2. Se modifica el crédito limite del cliente, restando el valor anterior del pago y sumando el valor nuevo de pago
            $sql = "UPDATE customers SET creditLimit = creditLimit - $olderAmount WHERE customerNumber = $customerNumber";
            $result = mysqli_query($this->conexion,$sql);

            if ($result) {
                $sql = "UPDATE customers SET creditLimit = creditLimit + $amount WHERE customerNumber = $customerNumber";
                $result = mysqli_query($this->conexion,$sql);

                if ($result) {
                    //3. Se modifica el valor pendiente de la orden de compra, sumando el valor anterior del pago y restando el valor nuevo de pago
                    $sql = "UPDATE orders SET amountPending = amountPending + $olderAmount WHERE orderNumber = $orderNumber";
                    $result = mysqli_query($this->conexion,$sql);

                    if ($result) {
                        $sql = "UPDATE orders SET amountPending = amountPending - $amount WHERE orderNumber = $orderNumber";
                        $result = mysqli_query($this->conexion,$sql);
                        
                        if ($result) {
                            //4. Se verfica el valor pendiente de la orden de compra, si el valor es igual a 0 se poner como pagado,
                            //de lo contrario se pone como pendiente
                            $sql = "SELECT amountPending FROM orders WHERE orderNumber = $orderNumber";
                            $record = mysqli_query($this->conexion, $sql);

                            if ($record) {
                                $result = mysqli_fetch_assoc($record);

                                if ($result['amountPending'] == 0) {
                                    $sql = "UPDATE orders SET statusPayment = 'pay' WHERE orderNumber = $orderNumber";
                                    $result = mysqli_query($this->conexion, $sql);
                                } else {
                                    $sql = "UPDATE orders SET statusPayment = 'pending' WHERE orderNumber = $orderNumber";
                                    $result = mysqli_query($this->conexion, $sql);
                                }

                                return true;
                            }
                        } else {
                            return false;
                        }
                    } else {
                        return false;
                    }
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
}
