<?php
/*
 
Adquirir un plan implica un contrato. Los contratos tienen la fecha de inicio, la fecha de vencimiento, el plan, un estado (al día, moroso, suspendido), un costo, si se renueva o no y una referencia al cliente que adquirió el contrato.
*/
class Contrato{
    
    //ATRIBUTOS
    private $fechaInicio;   
    private $fechaVencimiento;
    private $objPlan;
    private $estado;  //al día, moroso, suspendido
    private $costo;
    private $seRenueva;
    private $objCliente;

 //CONSTRUCTOR
    public function __construct($fechaInicio, $fechaVencimiento, $objPlan,$costo,$seRenueva,$objCliente){
    
       $this->fechaInicio = $fechaInicio;
       $this->fechaVencimiento = $fechaVencimiento;
       $this->objPlan = $objPlan;
       $this->estado = 'AL DIA';
       $this->costo = $costo;
       $this->seRenueva = $seRenueva;
       $this->objCliente = $objCliente;
           

    }


         public function getFechaInicio(){
        return $this->fechaInicio;
    }

    public function setFechaInicio($fechaInicio){
         $this->fechaInicio= $fechaInicio;
    }

        public function getFechaVencimiento(){
        return $this->fechaVencimiento;
    }

    public function setFechaVencimiento($fechaVencimiento){
         $this->fechaVencimiento= $fechaVencimiento;
    }


            public function getObjPlan(){
        return $this->objPlan;
    }

    public function setObjPlan($objPlan){
         $this->objPlan= $objPlan;
    }

   public function getEstado(){
        return $this->estado;
    }

    public function setEstado($estado){
         $this->estado= $estado;
    }

 public function getCosto(){
        return $this->costo;
    }

    public function setCosto($costo){
         $this->costo= $costo;
    }

public function getSeRenueva(){
        return $this->seRenueva;
    }

    public function setSeRenueva($seRenueva){
         $this->seRenueva= $seRenueva;
    }


public function getObjCliente(){
        return $this->objCliente;
    }

    public function setObjCliente($objCliente){
         $this->objCliente= $objCliente;
    }

public function __toString(){
        //string $cadena
        $cadena = "Fecha inicio: ".$this->getFechaInicio()."\n";
        $cadena = "Fecha Vencimiento: ".$this->getFechaVencimiento()."\n";
        $cadena = $cadena. "Plan: ".$this->getObjPlan()."\n";
        $cadena = $cadena. "Estado: ".$this->getEstado()."\n";
        $cadena = $cadena. "Costo: ".$this->getCosto()."\n";
        $cadena = $cadena. "Se renueva: ".$this->getSeRenueva()."\n";
        $cadena = $cadena. "Cliente: ".$this->getObjCliente()."\n";

 
        return $cadena;
         }

// MÉTODO PARA CALCULAR DÍAS QUE EL CONTRATO LLEVA VENCIDO
public function diasContratoVencido() {
     $hoy = new DateTime();
     $diasVencido = 0;
     $bandera = false;

     if ($hoy > $this->fechaVencimiento) {
         $interval = $hoy->diff($this->fechaVencimiento);
         $diasVencido = $interval->days;
         $bandera = true;
     }

     if ($bandera) {
         return $diasVencido;
     } else {
         return 0;
     }
 }

 // MÉTODO PARA ACTUALIZAR EL ESTADO DEL CONTRATO
 public function actualizarEstadoContrato() {
     $diasVencido = $this->diasContratoVencido();
     $bandera = false;

     if ($diasVencido == 0) {
         $this->estado = 'AL DIA';
         $bandera = true;
     } elseif ($diasVencido > 0 && $diasVencido < 10) {
         $this->estado = 'MOROSO';
         $bandera = true;
     } elseif ($diasVencido >= 10) {
         $this->estado = 'SUSPENDIDO';
         $bandera = true;
     }
     return $bandera;
 }

 public function calcularImporte() {
     // Implementación predeterminada: solo devuelve el importe del plan
     return $this->objPlan->getImporte();
     }    

     public function incorporaPlan($nuevoPlan) {
        $this->objPlan = $nuevoPlan;
        $this->costo = $nuevoPlan->getImporte();
    }

    public function pagarContrato() {
        // Simulación de marcado como pagado (cambio de estado, actualización en base de datos, etc.)
        $this->estado = 'AL DIA'; // Cambiar el estado a "AL DIA" como pagado
    }
}    