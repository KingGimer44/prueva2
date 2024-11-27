<?php
session_start();
if (!isset($_SESSION['empleado'])) {
    header("Location: login.php");
    exit();
}

$conexion = new mysqli("localhost", "root", "", "medicina");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $cantidad = $_POST['cantidad'];
    $imagen = $_FILES['imagen']['name'];

    if ($imagen) {
        move_uploaded_file($_FILES['imagen']['tmp_name'], "imagenes/$imagen");
        $conexion->query("UPDATE medicamentos SET nombre='$nombre', descripcion='$descripcion', cantidad='$cantidad', imagen='$imagen' WHERE id='$id'");
    } else {
        $conexion->query("UPDATE medicamentos SET nombre='$nombre', descripcion='$descripcion', cantidad='$cantidad' WHERE id='$id'");
    }

    header("Location: index.php");
} else {
    $id = $_GET['id'];
    $resultado = $conexion->query("SELECT * FROM medicamentos WHERE id='$id'");
    $medicamento = $resultado->fetch_assoc();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Modificar Medicamento</title>
    <link rel="stylesheet" href="estilo.css">
</head>
<body>
<header>
        <nav>
            <div class="logo"><h1>Modificar Medicamento</h1></div>
            <div class="menu">
                <a href="index.php"><button>Inventario</button></a>
            </div>
        </nav>
    </header>
    <div class="worker-section">
        <form method="post" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo $medicamento['id']; ?>">
            <input type="text" name="nombre" value="<?php echo $medicamento['nombre']; ?>" required>
            <textarea name="descripcion" required><?php echo $medicamento['descripcion']; ?></textarea>
            <input type="number" name="cantidad" value="<?php echo $medicamento['cantidad']; ?>" required>
            <input type="file" name="imagen">
            <button type="submit">Modificar</button>
        </form>
    </div>
</body>
</html>
