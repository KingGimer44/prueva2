<?php
session_start();
require_once 'Singleton.php';
require_once 'NegocioEmpleado.php';

$conexion = Singleton::getInstance()->getConexion();
$negocioEmpleado = new NegocioEmpleado($conexion);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $usuario = $_POST['usuario'];
    $contrasena = $_POST['contrasena'];

    // Verificar credenciales usando NegocioEmpleado
    if ($negocioEmpleado->verificarCredenciales($usuario, $contrasena)) {
        $_SESSION['empleado'] = $usuario;
        header("Location: index.php");
    } else {
        echo "Usuario o contraseña incorrectos.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="estilo.css">
    <title>Inicio de Sesión</title>
</head>
<body>
    <header>
        <nav>
            <div class="logo"><h1>Inventario de Medicamentos</h1></div>
        </nav>
    </header>
    <main>
        <div class="worker-section">
            <form method="post" action="login.php">
                <input type="text" name="usuario" placeholder="Usuario" required>
                <input type="password" name="contrasena" placeholder="Contraseña" required>
                <button type="submit">Iniciar Sesión</button>
                <a href="registro.php"><button type="button">Crear Nuevo Empleado</button></a>
            </form>
        </div>
    </main>
</body>
</html>
