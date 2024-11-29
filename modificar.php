<?php
session_start();
require_once 'MedicamentoLee.php';
require_once 'MedicamentoEscribe.php';

if (!isset($_SESSION['empleado'])) {
    header("Location: login.php");
    exit();
}

$commandService = new MedicamentoCommandService();
$queryService = new MedicamentoQueryService();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'] ?? null;
    $nombre = $_POST['nombre'] ?? '';
    $descripcion = $_POST['descripcion'] ?? '';
    $cantidad = $_POST['cantidad'] ?? 0;
    $imagen = !empty($_FILES['imagen']['name']) ? $_FILES['imagen']['name'] : null;

    if ($imagen) {
        move_uploaded_file($_FILES['imagen']['tmp_name'], "imagenes/$imagen");
        $commandService->actualizarMedicamento($id, $nombre, $descripcion, $cantidad, $imagen);
    } else {
        $commandService->actualizarMedicamento($id, $nombre, $descripcion, $cantidad, null);
    }

    if (isset($_POST['eliminar'])) {
        $commandService->eliminarMedicamento($id);
        header("Location: index.php");
        exit();
    }

    header("Location: index.php");
    exit();
}

$id = $_GET['id'] ?? null;
$medicamento = $queryService->obtenerPorId($id);
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
        <input type="hidden" name="id" value="<?php echo $medicamento['id'] ?? ''; ?>">
        <input type="text" name="nombre" value="<?php echo $medicamento['nombre'] ?? ''; ?>" required>
        <textarea name="descripcion" required><?php echo $medicamento['descripcion'] ?? ''; ?></textarea>
        <input type="number" name="cantidad" value="<?php echo $medicamento['cantidad'] ?? 0; ?>" required>
        <input type="file" name="imagen">
        <button type="submit" name="modificar">Modificar</button>
    </form>
</div>
<div class="delete">
    <form method="post" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?php echo $medicamento['id'] ?? ''; ?>">
        <button type="submit" name="eliminar" class="delete-btn">Borrar</button>
    </form>
</div>
</body>
</html>
