<?php
session_start();
require_once 'Singleton.php';
require_once 'NegocioEmpleado.php';

$conexion = Singleton::getInstance()->getConexion();
$negocioEmpleado = new NegocioEmpleado($conexion);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = $_POST['usuario'] ?? '';
    $contrasena = $_POST['contrasena'] ?? '';

    if ($usuario && $contrasena) {
        $resultado = $negocioEmpleado->registrarEmpleado($usuario, $contrasena);
        if ($resultado) {
            $_SESSION['empleado'] = $usuario;
            header("Location: index.php");
            exit();
        } else {
            $mensaje = "Error al registrar el empleado.";
        }
    } else {
        $mensaje = "Por favor, complete todos los campos.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="estilo.css">
    <title>Registro de Empleado</title>
</head>
<body>
    <header>
        <h1>Registro de Empleado</h1>
    </header>
    <main>
        <div class="worker-section">
            <form method="POST" action="">
                <input type="text" name="usuario" placeholder="Usuario" required>
                <input type="password" name="contrasena" placeholder="Contraseña" required>
                <button type="submit">Registrar</button>
                <a href="login.php"><button type="button">Volver a Iniciar Sesión</button></a>
            </form>
            <?php if (isset($mensaje)): ?>
                <p><?php echo htmlspecialchars($mensaje); ?></p>
            <?php endif; ?>
        </div>
    </main>
</body>
</html>
