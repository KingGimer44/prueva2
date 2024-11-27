<?php

class Sujeto {
    private $observadores = [];

    public function agregarObservador(Observer $observador) {
        $this->observadores[] = $observador;
    }

    public function eliminarObservador(Observer $observador) {
        $this->observadores = array_filter($this->observadores, function($obs) use ($observador) {
            return $obs !== $observador;
        });
    }

    public function notificar($mensaje) {
        foreach ($this->observadores as $observador) {
            $observador->actualizar($mensaje);
        }
    }
}

?>