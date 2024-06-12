<?php

class ContratoWeb extends Contrato {
    private $porcentajeDescuento;

    public function __construct($fechaInicio, $fechaVencimiento, $objPlan, $costo, $seRenueva, $objCliente, $porcentajeDescuento = 0.10) {
        parent::__construct($fechaInicio, $fechaVencimiento, $objPlan, 0, $seRenueva, $objCliente); // El costo se inicializa en 0, ya que se calculará posteriormente
        $this->porcentajeDescuento = $porcentajeDescuento;
        $this->calcularCosto();
    }

    public function getPorcentajeDescuento() {
        return $this->porcentajeDescuento;
    }

    public function setPorcentajeDescuento($porcentajeDescuento) {
        $this->porcentajeDescuento = $porcentajeDescuento;
    }

    public function calcularCosto() {
        $descuento = $this->getObjPlan()->getImporte() * $this->porcentajeDescuento;
        $this->setCosto($this->getObjPlan()->getImporte() - $descuento);
    }

    public function __toString() {
        $cadena = parent::__toString();
        $cadena .= "Porcentaje Descuento: " . ($this->getPorcentajeDescuento() * 100) . "%\n";
        return $cadena;
    }

    public function calcularImporte() {
        $importe = parent::calcularImporte(); // Importe del plan base
        $descuento = $importe * $this->porcentajeDescuento;
        return $importe - $descuento; // Aplicar descuento para contrato web
    }
}
