<?php

class ContratoEmpresa extends Contrato {
    private $colCanales;

    public function __construct($fechaInicio, $fechaVencimiento, $objPlan, $costo, $seRenueva, $objCliente, $colCanales) {
        parent::__construct($fechaInicio, $fechaVencimiento, $objPlan, 0, $seRenueva, $objCliente); // El costo se inicializa en 0, ya que se calculará posteriormente
        $this->colCanales = $colCanales;
        $this->calcularCosto();
    }

    public function getColCanales() {
        return $this->colCanales;
    }

    public function setColCanales($colCanales) {
        $this->colCanales = $colCanales;
    }

    public function calcularCosto() {
        $this->setCosto($this->getObjPlan()->getImporte());
        foreach ($this->colCanales as $canal) {
            $this->setCosto($this->getCosto() + $canal->getImporte());
        }
    }

    public function __toString() {
        $cadena = parent::__toString();
        $cadena .= "Canales:\n";
        $cadena .= $this->getColCanales()[0] . "\n"; 
        $cadena .= $this->getColCanales()[1] . "\n"; 
        return $cadena;
    }
    

    public function calcularImporte() {
        $importe = parent::calcularImporte(); // Importe del plan base
        foreach ($this->colCanales as $canal) {
            $importe += $canal->getImporte(); // Agregar importe de canales adicionales
        }
        return $importe;
    }
}
