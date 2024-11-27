<?php

require_once 'NegocioMedicamento.php';
require_once 'Singleton.php';
require_once 'sujeto.php';
require_once 'observer.php';

class InventarioFacade extends Sujeto {
    private $medicamentoNegocio;

    public function __construct() {
        $conexion = Singleton::getInstance()->getConexion();
        $this->medicamentoNegocio = new Medicamento($conexion);
    }

    public function obtenerTodosLosMedicamentos() {
        $medicamentos = $this->medicamentoNegocio->obtenerTodos();
        $this->notificar("Se han obtenido " . count($medicamentos) . " medicamentos.");
        return $medicamentos;
    }

}

?>