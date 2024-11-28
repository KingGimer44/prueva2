<?php
require_once 'Singleton.php';

class NegocioEmpleado {
    private $conexion;

    public function __construct($conexion) {
        $this->conexion = $conexion;
    }

    public function registrarEmpleado($usuario, $contrasena) {
        $sql = "INSERT INTO empleados (usuario, contrasena) VALUES (?, ?)";
        $stmt = $this->conexion->prepare($sql);

        $hashedPassword = password_hash($contrasena, PASSWORD_DEFAULT);

        $stmt->bind_param('ss', $usuario, $hashedPassword);

        return $stmt->execute();
    }

    public function verificarCredenciales($usuario, $contrasena) {
        $sql = "SELECT * FROM empleados WHERE usuario = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param('s', $usuario);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $empleado = $result->fetch_assoc();
            if (password_verify($contrasena, $empleado['contrasena'])) {
                return true;
            }
        }
        return false;
    }
}
