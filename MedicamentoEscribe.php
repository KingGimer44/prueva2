<?php
require_once 'Singleton.php';

class MedicamentoCommandService {
    private $conexion;

    public function __construct() {
        $this->conexion = Singleton::getInstance()->getConexion();
    }

    // Método para agregar un medicamento
    public function agregarMedicamento($nombre, $descripcion, $cantidad, $imagen) {
        $stmt = $this->conexion->prepare("INSERT INTO medicamentos (nombre, descripcion, cantidad, imagen) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssis", $nombre, $descripcion, $cantidad, $imagen);
        return $stmt->execute();
    }

    // Método para actualizar un medicamento
    public function actualizarMedicamento($id, $nombre, $descripcion, $cantidad, $imagen) {
        if ($imagen) {
            $stmt = $this->conexion->prepare("UPDATE medicamentos SET nombre = ?, descripcion = ?, cantidad = ?, imagen = ? WHERE id = ?");
            $stmt->bind_param("ssisi", $nombre, $descripcion, $cantidad, $imagen, $id);
        } else {
            $stmt = $this->conexion->prepare("UPDATE medicamentos SET nombre = ?, descripcion = ?, cantidad = ? WHERE id = ?");
            $stmt->bind_param("ssii", $nombre, $descripcion, $cantidad, $id);
        }
        return $stmt->execute();
    }

    // Método para eliminar un medicamento
    public function eliminarMedicamento($id) {
        $stmt = $this->conexion->prepare("DELETE FROM medicamentos WHERE id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}
?>
