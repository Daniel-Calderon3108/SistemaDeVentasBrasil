<?php
//Se trae el archivo de conexion para poder usarlo
require_once("../core/conexion.php");

class ModelLogin extends Conexion
{
    //Función que se encarga de validar que el correo y contraseña enviada por el usuario sea correcta
    public function login($email,$password)
    {
        //Se llama a la función que se encarga de encriptar las contraseñas 
        //para verificar que coincida con la que esta en la base de datos
        $pass = $this->encryptPassword($password);
        $sql = "SELECT employeeNumber FROM employees WHERE email = '$email' AND employeePass = '$pass'";
        $result = mysqli_query($this->conexion,$sql);
        $row = mysqli_fetch_assoc($result);

        //En caso de que la verificación sea correcta, se retorna el id del empleado
        if($row > 0){
            $employee = $row['employeeNumber'];
            return $employee;
        }else{
            return false;
        }

    }
    //Función que se encarga de encriptar la contraseñas
    public function encryptPassword($password) {
        $salt = 'system';
        $hash = hash('sha256', $salt . $password);
        return $hash;
    }
}