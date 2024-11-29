<?php
require_once 'Singleton.php';

class MedicamentoQueryService {
    private $conexion;

    public function __construct() {
        $this->conexion = Singleton::getInstance()->getConexion();
    }

    // Método para obtener todos los medicamentos
    public function obtenerTodos() {
        $resultado = $this->conexion->query("SELECT * FROM medicamentos");
        return $resultado->fetch_all(MYSQLI_ASSOC);
    }

    // Método para obtener un medicamento por ID
    public function obtenerPorId($id) {
        $stmt = $this->conexion->prepare("SELECT * FROM medicamentos WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }
}
?>
