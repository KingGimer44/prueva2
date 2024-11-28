<?php
session_start();
require_once 'NegocioMedicamento.php';

if (!isset($_SESSION['empleado'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $cantidad = $_POST['cantidad'];

    $nombreImagen = $_FILES['imagen']['name'];
    $rutaTemporal = $_FILES['imagen']['tmp_name'];
    $carpetaDestino = "imagenes/";

    if (move_uploaded_file($rutaTemporal, $carpetaDestino . $nombreImagen)) {

        $negocioMedicamento = new NegocioMedicamento();

        $resultado = $negocioMedicamento->agregarMedicamento($nombre, $descripcion, $cantidad, $nombreImagen);

        if ($resultado) {
            header("Location: index.php");
        } else {
            echo "Error al agregar el medicamento.";
        }
    } else {
        echo "Error al subir la imagen.";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="estilo.css">
    <title>Agregar Medicamento</title>
</head>
<body>
    <header>
        <nav>
            <div class="logo"><h1>Agregar Medicamento</h1></div>
            <div class="menu">
                <a href="index.php"><button>Inventario</button></a>
            </div>
        </nav>
    </header>
    <main>
        <div class="worker-section">
            <form method="post" enctype="multipart/form-data">
                <input type="text" name="nombre" placeholder="Nombre del medicamento" required>
                <textarea name="descripcion" placeholder="Descripción médica" required></textarea>
                <input type="number" name="cantidad" placeholder="Cantidad en stock" required>
                <input type="file" name="imagen" required>
                <button type="submit">Agregar</button>
            </form>
        </div>
    </main>
</body>
</html>
