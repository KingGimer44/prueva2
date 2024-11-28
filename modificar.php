<?php
session_start();
require_once 'NegocioMedicamento.php';

if (!isset($_SESSION['empleado'])) {
    header("Location: login.php");
    exit();
}

$negocioMedicamento = new NegocioMedicamento();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['modificar'])) { 
        $id = $_POST['id'];
        $nombre = $_POST['nombre'];
        $descripcion = $_POST['descripcion'];
        $cantidad = $_POST['cantidad'];
        $imagen = $_FILES['imagen']['name'];

        if ($imagen) {
            move_uploaded_file($_FILES['imagen']['tmp_name'], "imagenes/$imagen");
            $resultado = $negocioMedicamento->modificarMedicamento($id, $nombre, $descripcion, $cantidad, $imagen);
        } else {
            $resultado = $negocioMedicamento->modificarMedicamento($id, $nombre, $descripcion, $cantidad);
        }

        if ($resultado) {
            header("Location: index.php");
        } else {
            echo "Error al modificar el medicamento.";
        }
    } elseif (isset($_POST['eliminar'])) { 
        $id = $_POST['id'];
        $resultado = $negocioMedicamento->eliminarMedicamento($id);
        
        if ($resultado) {
            header("Location: index.php");
        } else {
            echo "Error al eliminar el medicamento.";
        }
    }
} else {
    $id = $_GET['id'];
    $medicamento = $negocioMedicamento->obtenerMedicamentoPorId($id);
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
        <button type="submit" name="modificar">Modificar</button>
    </form>
</div>
<div class="delete">
    <form method="post" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?php echo $medicamento['id']; ?>">
        <button type="submit" name="eliminar" class="delete-btn">Borrar</button>
    </form>
</div>
</body>
</html>
