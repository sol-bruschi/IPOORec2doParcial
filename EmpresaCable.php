<?php

class EmpresaCable {
    private $colPlanes;
    private $colContratos;

    public function __construct() {
        $this->colPlanes = [];
        $this->colContratos = [];
    }

     // Métodos de acceso
     public function getColPlanes() {
        return $this->colPlanes;
    }

    public function setColPlanes($colPlanes) {
        $this->colPlanes = $colPlanes;
    }

    public function getColContratos() {
        return $this->colContratos;
    }

    public function setColContratos($colContratos) {
        $this->colContratos = $colContratos;
    }

    public function incorporarPlan($objPlan) {
        foreach ($this->colPlanes as $planExistente) {
            if ($planExistente->getCanales() === $objPlan->getCanales()) {
                if ($planExistente->getIncluyeMG() === $objPlan->getIncluyeMG()) {
                    return false;
                }
            }
        }
        $this->colPlanes[] = $objPlan;
        return true;
    }

    public function incorporarContrato($objPlan, $objCliente, $fechaDesde, $fechaVenc, $esViaWeb) {
        if ($esViaWeb) {
            $nuevoContrato = new ContratoWeb($fechaDesde, $fechaVenc, $objPlan, 0, true, $objCliente);
        } else {
            $nuevoContrato = new ContratoEmpresa($fechaDesde, $fechaVenc, $objPlan, 0, true, $objCliente, []);
        }
        $this->colContratos[] = $nuevoContrato;
        return $nuevoContrato;
    }

    public function retornarImporteContratos($codigoPlan) {
        $importeTotal = 0;
        foreach ($this->colContratos as $contrato) {
            if ($contrato->getObjPlan()->getCodigo() === $codigoPlan) {
                $importeTotal += $contrato->calcularImporte();
            }
        }
        return $importeTotal;
    }

    public function pagarContrato($objContrato) {
        $importeFinal = 0;
        $objContrato->actualizarEstadoContrato();
        switch ($objContrato->getEstado()) {
            case 'AL DIA':
                $importeFinal = $objContrato->getCosto();
                break;
            case 'MOROSO':
                $diasMora = $objContrato->diasContratoVencido();
                $multa = $objContrato->getCosto() * 0.10 * $diasMora;
                $importeFinal = $objContrato->getCosto() + $multa;
                break;
            case 'SUSPENDIDO':
                $diasMora = $objContrato->diasContratoVencido();
                $multa = $objContrato->getCosto() * 0.10 * $diasMora;
                $importeFinal = $objContrato->getCosto() + $multa;
                break;
        }
        return $importeFinal;
    }

    public function __toString() {
        $cadena = "Planes:\n" . $this->colPlanes->__toString() . "\n";
        $cadena .= "Contratos:\n" . $this->colContratos->__toString() . "\n";
    
        return $cadena;
    }
    
}
