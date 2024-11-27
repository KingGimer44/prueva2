<?php
    class Configuracion {
        private static $instancia = null;
        private $configuraciones = [];

        private function __construct() {
            $this->configuraciones = [
                'Inventario de Medicamentos' => 'Inventario de Medicamentos',
                'version' => '1.0.0',
            ];
        }

        public static function getInstance() {
            if (self::$instancia === null) {
                self::$instancia = new Configuracion();
            }
            return self::$instancia;
        }

        public function get($clave) {
            return $this->configuraciones[$clave] ?? null;
        }
    }