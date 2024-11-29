<?php
session_start();
require_once 'MedicamentoLee.php';
require_once 'MedicamentoEscribe.php';
require_once 'Singleton.php';
require_once 'Configuracion.php';
require_once 'facade.php';
require_once 'sujeto.php';
require_once 'observer.php';
require_once 'observercon.php';

$queryService = new MedicamentoQueryService();

$medicamentos = $queryService->obtenerTodos();

$config = Configuracion::getInstance();
$nombreSitio = $config->get('Inventario de Medicamentos');

$busqueda = isset($_POST['busqueda']) ? $_POST['busqueda'] : '';

if ($busqueda) {
    $medicamentos = array_filter($medicamentos, function($medicamento) use ($busqueda) {
        return stripos($medicamento['nombre'], $busqueda) !== false;
    });
}

$mensajeNotificacion = "Se han encontrado " . count($medicamentos) . " medicamentos.";


$observador1 = new ConcreteObserver("Observador 1");
$observador2 = new ConcreteObserver("Observador 2");

$inventarioFacade = new InventarioFacade($queryService);
$inventarioFacade->agregarObservador($observador1);
$inventarioFacade->agregarObservador($observador2);

$resultado = $inventarioFacade->obtenerTodosLosMedicamentos();

$config = Configuracion::getInstance();
$nombreSitio = $config->get('Inventario de Medicamentos');

$inventario = new InventarioFacade();
$medicamentos = $inventario->obtenerTodosLosMedicamentos();

$busqueda = isset($_POST['busqueda']) ? $_POST['busqueda'] : '';

if ($busqueda) {
    $medicamentos = array_filter($medicamentos, function($medicamento) use ($busqueda) {
        return stripos($medicamento['nombre'], $busqueda) !== false;
    });
}

$mensajeNotificacion = "Se han encontrado " . count($medicamentos) . " medicamentos.";

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="estilo.css">
    <title>Inventario de Medicamentos</title>
</head>
<body>
    <header>
        <nav>
            <div class="logo"><h1>Inventario de Medicamentos</h1></div>
            <div class="menu">
                <div class="busqueda-container">
                    <form method="POST" action="">
                        <input type="text" name="busqueda" class="busqueda-input" placeholder="Buscar medicamento" value="<?php echo htmlspecialchars($busqueda); ?>">
                        <button type="submit" class="busqueda-boton">Buscar</button>
                    </form>
                </div>
                <?php if (isset($_SESSION['empleado'])): ?>
                    <a href="agregar.php"><button>Agregar Medicamento</button></a>
                    <a href="logout.php"><button>Cerrar Sesión</button></a>
                <?php else: ?>
                    <a href="login.php"><button>Iniciar Sesión</button></a>
                <?php endif; ?>
            </div>
        </nav>
    </header>
    <main>
        <div class="medicines-grid">
            <?php foreach ($medicamentos as $medicamento): ?>
                <div class="medicine">
                    <img class="medicamento-imagen" src="imagenes/<?php echo $medicamento['imagen']; ?>" alt="<?php echo $medicamento['nombre']; ?>">
                    <h4><?php echo $medicamento['nombre']; ?></h4>
                    <p>Cantidad en stock: <?php echo $medicamento['cantidad']; ?></p>
                    <a href="detalle.php?id=<?php echo $medicamento['id']; ?>"><button class="button1">Ver detalles</button></a>
                </div>
            <?php endforeach; ?>
        </div>
    </main>
    <div id="notificacion" class="notificacion" style="display: none;">
        <p id="mensaje-notificacion"></p>
    </div>

    <script>
        const mensaje = <?php echo json_encode($mensajeNotificacion); ?>;

        function mostrarNotificacion(mensaje) {
            const notificacion = document.getElementById('notificacion');
            const mensajeNotificacion = document.getElementById('mensaje-notificacion');

            mensajeNotificacion.textContent = mensaje;
            notificacion.style.display = 'block';
            notificacion.style.opacity = 1;

            setTimeout(() => {
                notificacion.style.opacity = 0;
                setTimeout(() => {
                    notificacion.style.display = 'none';
                }, 500);
            }, 3000);
        }

        mostrarNotificacion(mensaje);
    </script>
</body>
</html>
