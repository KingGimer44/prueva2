<?php
require_once 'MedicamentoLee.php';
require_once 'MedicamentoEscribe.php';
require_once 'Singleton.php';
require_once 'sujeto.php';
require_once 'observer.php';

class InventarioFacade extends Sujeto {
    private $medicamentoQueryService;
    private $medicamentoCommandService;

    public function __construct() {
        $this->medicamentoQueryService = new MedicamentoQueryService();
        $this->medicamentoCommandService = new MedicamentoCommandService();
    }

    public function obtenerTodosLosMedicamentos() {
        $medicamentos = $this->medicamentoQueryService->obtenerTodos();
        $this->notificar("Se han obtenido " . count($medicamentos) . " medicamentos.");
        return $medicamentos;
    }

    public function agregarMedicamento($nombre, $descripcion, $cantidad, $imagen) {
        $resultado = $this->medicamentoCommandService->agregarMedicamento($nombre, $descripcion, $cantidad, $imagen);
        if ($resultado) {
            $this->notificar("Se ha agregado un nuevo medicamento: " . $nombre);
        }
        return $resultado;
    }

    public function modificarMedicamento($id, $nombre, $descripcion, $cantidad, $imagen) {
        $resultado = $this->medicamentoCommandService->modificarMedicamento($id, $nombre, $descripcion, $cantidad, $imagen);
        if ($resultado) {
            $this->notificar("Se ha actualizado el medicamento con ID: " . $id);
        }
        return $resultado;
    }

    public function eliminarMedicamento($id) {
        $resultado = $this->medicamentoCommandService->eliminarMedicamento($id);
        if ($resultado) {
            $this->notificar("Se ha eliminado el medicamento con ID: " . $id);
        }
        return $resultado;
    }

}

?>
