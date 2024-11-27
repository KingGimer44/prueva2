<?php
require_once 'Singleton.php';

class Medicamento {
    private $conexion;

    public function __construct($conexion) {
        $this->conexion = $conexion;
    }

    public function obtenerTodos() {
        $resultado = $this->conexion->query("SELECT * FROM medicamentos");
        $medicamentos = [];

        while ($fila = $resultado->fetch_assoc()) {
            $medicamentos[] = $fila;
        }

        return $medicamentos;
    }

    public function obtenerPorId($id) {
        $stmt = $this->conexion->prepare("SELECT * FROM medicamentos WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function actualizar($id, $nombre, $descripcion, $cantidad, $imagen = null) {
        if ($imagen) {
            $stmt = $this->conexion->prepare("UPDATE medicamentos SET nombre = ?, descripcion = ?, cantidad = ?, imagen = ? WHERE id = ?");
            $stmt->bind_param("ssisi", $nombre, $descripcion, $cantidad, $imagen, $id);
        } else {
            $stmt = $this->conexion->prepare("UPDATE medicamentos SET nombre = ?, descripcion = ?, cantidad = ? WHERE id = ?");
            $stmt->bind_param("ssii", $nombre, $descripcion, $cantidad, $id);
        }
        return $stmt->execute();
    }
}

class NegocioMedicamento {
    private $conexion;

    public function __construct() {
        $this->conexion = Singleton::getInstance()->getConexion();
    }

    public function obtenerMedicamentoPorId($id) {
        $stmt = $this->conexion->prepare("SELECT * FROM medicamentos WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $resultado = $stmt->get_result();
        
        if ($resultado->num_rows > 0) {
            return $resultado->fetch_assoc();
        } else {
            return null;
        }
    }
}
?>