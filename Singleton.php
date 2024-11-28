<?php

class Singleton {
    private static $instance = null;
    private $conexion;

    private function __construct() {
        $this->conexion = new mysqli('185.232.14.52', 'u760464709_brise_o_usr', '4O$;&qE~e', 'u760464709_brise_o_bd');
        
        if ($this->conexion->connect_error) {
            die("Conexión fallida: " . $this->conexion->connect_error);
        }
    }

    public static function getInstance() {
        if (self::$instance == null) {
            self::$instance = new Singleton();
        }
        return self::$instance;
    }

    public function getConexion() {
        return $this->conexion;
    }
}

?>
