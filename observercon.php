<?php
require_once 'observer.php';
require_once 'sujeto.php';

class ConcreteObserver implements Observer {
    public function actualizar($mensaje) {
    }
}

$sujeto = new Sujeto();
$observador = new ConcreteObserver();

$sujeto->agregarObservador($observador);

?>