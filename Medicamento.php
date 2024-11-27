<?php
// archivo: domingo/test2/Medicamento.php

require_once 'Medic.php';

interface Observador {
    public function actualizar($estado);
}

class Medicamento implements Medic {
    private $precio;

    public function __construct($precio) {
        $this->precio = $precio;
    }

    public function obtenerPrecio() {
        return $this->precio;
    }
}

class Subject {
    private $observadores = [];
    private $estado;

    public function agregarObservador(Observador $observador) {
        $this->observadores[] = $observador;
    }

    public function eliminarObservador(Observador $observador) {
        $clave = array_search($observador, $this->observadores, true);
        if ($clave !== false) {
            unset($this->observadores[$clave]);
        }
    }

    public function notificarObservadores() {
        foreach ($this->observadores as $observador) {
            $observador->actualizar($this->estado);
        }
    }

    public function cambiarEstado($nuevoEstado) {
        $this->estado = $nuevoEstado;
        $this->notificarObservadores();
    }

    public function obtenerEstado() {
        return $this->estado;
    }
}
?>
