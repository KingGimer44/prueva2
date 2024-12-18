<?php

require_once 'Medic.php';

class Decorator implements Medic {
    protected $medicamento;

    public function __construct(Medic $medicamento) {
        $this->medicamento = $medicamento;
    }

    public function obtenerPrecio() {
        return $this->medicamento->obtenerPrecio();
    }

    public function obtenerPrecioConDescuento() {
        return $this->obtenerPrecio() * 0.9;
    }
}
?>
