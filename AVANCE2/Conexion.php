<?php
class Conexion {
    private $host = "localhost";      
    private $usuario = "root";        
    private $contrasena = "Emiliano30j2005";         
    private $base_datos = "bdm_pia";  
    private $puerto = 3306;           
    public $conexion;

    public function __construct() {
        $this->conectar();
    }

    public function conectar() {
        $this->conexion = new mysqli(
            $this->host,
            $this->usuario,
            $this->contrasena,
            $this->base_datos,
            $this->puerto   
        );

        if ($this->conexion->connect_error) {
            die("Error de conexión: " . $this->conexion->connect_error);
        }

        $this->conexion->set_charset("utf8");
    }

    public function cerrar() {
        $this->conexion->close();
    }
}
?>
