<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $usuario = $_POST['usuario'];
    $contrasena = $_POST['contrasena'];

    // Conexión a la base de datos
    $conexion = new mysqli("localhost", "root", "", "medicina");;
    $resultado = $conexion->query("SELECT * FROM empleados WHERE usuario='$usuario' AND contrasena='$contrasena'");

    if ($resultado->num_rows > 0) {
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
            </form>
        </div>
    </main>
</body>
</html>
