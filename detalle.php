<?php
session_start();
require_once 'Singleton.php';
require_once 'NegocioMedicamento.php';

$negocioMedicamento = new NegocioMedicamento();
$id = $_GET['id'];
$medicamento = $negocioMedicamento->obtenerMedicamentoPorId($id);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="estilo.css">
    <title>Detalle del Medicamento</title>
</head>
<body>
    <header>
        <nav>
            <div class="logo"><h1>Detalle del Medicamento</h1></div>
            <div class="menu">
                <a href="index.php"><button>Inventario</button></a>
            </div>
        </nav>
    </header>
    <main>
        <div class="results">
            <img class="medicamento-imagen-detalle" src="imagenes/<?php echo $medicamento['imagen']; ?>" alt="<?php echo $medicamento['nombre']; ?>">
            <h4><?php echo $medicamento['nombre']; ?></h4>
            <p><?php echo $medicamento['descripcion']; ?></p>
            <p>Cantidad en stock: <?php echo $medicamento['cantidad']; ?></p>
            <?php if (isset($_SESSION['empleado'])): ?>
                <div class="worker-section">
                    <form method="get" action="modificar.php">
                        <input type="hidden" name="id" value="<?php echo $medicamento['id']; ?>">
                        <button type="submit">Modificar</button>
                    </form>
                </div>
            <?php endif; ?>
        </div>
    </main>
</body>
</html>
