<?php

class Singleton {
    private static $instance = null;
    private $conexion;

    private function __construct() {
        $this->conexion = new mysqli('localhost', 'root', '', 'medicina');
        
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