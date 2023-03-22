<?php

Class Conexion{
    //Se inicializan las variables
    public $conexion;
    private $server;
    private $user;
    private $password;
    private $namebd;
    private $charset;

    //Se crea constructor
    function __construct()
    {
        //Se llama al archivo database para poder usarlo
        $db_cfg = require_once("../config/database.php");
        //Se llenan las variables con los datos que traemos del archivo
        $this->server    = $db_cfg["server"];
        $this->user      = $db_cfg["user"];
        $this->password  = $db_cfg["pass"];
        $this->namebd    = $db_cfg["bd"];
        $this->charset   = $db_cfg["charset"];

        //Se llama al metodo conectar base de datos
        $this->connectBd();

        //Setear nombres para no tener problemas con los caracteres
        $sql = "SET NAMES '".$this->charset."'";
        mysqli_query($this->conexion,$sql);
    }

    //Función para poder conectarnos a la base de datos
    private function connectBd(){
        //Se pasan los parametros necesarios para realizar la conexión
        $this->conexion = mysqli_connect($this->server,$this->user,$this->password,$this->namebd);
        
        //Se realiza un if donde se verifica que la conexión sea exitosa
        if(mysqli_connect_error()){
            die("Fallo la conexion a la base de datos ".mysqli_connect_error().mysqli_connect_errno());
        }
    }   
}