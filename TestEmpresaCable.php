<?php

require_once 'EmpresaCable.php'; // Asumo que la clase EmpresaCable está en un archivo separado
require_once 'Plan.php'; // Asumo que la clase Plan está en un archivo separado
require_once 'Contrato.php'; // Asumo que la clase Contrato está en un archivo separado
require_once 'ContratoWeb.php'; // Asumo que la clase ContratoWeb está en un archivo separado
require_once 'ContratoEmpresa.php'; // Asumo que la clase ContratoEmpresa está en un archivo separado
require_once 'Cliente.php'; // Asumo que la clase Cliente está en un archivo separado

// Crear instancias de la clase Canal
$canal1 = new Canal("Noticias", 10.99, true, false);
$canal2 = new Canal("Deportivo", 15.99, true, true);
$canal3 = new Canal("Infantil", 8.99, false, false);

// Imprimir la información de cada canal
echo $canal1->__toString() . "\n";
echo $canal2->__toString() . "\n";
echo $canal3->__toString() . "\n";

// Crear instancias de la clase Plan
$plan1 = new Plan(111, [$canal1, $canal2], 10.99);
$plan2 = new Plan(222, [$canal2, $canal3], 12.99);

// Crear una instancia de la clase Cliente
$clienteA = new Cliente("Cliente A", "20-12345678-9", "AL DIA");
$clienteB = new Cliente("Cliente B", "20-23456789-0", "AL DIA");
$clienteC = new Cliente("Cliente C", "20-34567890-1", "AL DIA");

// Crear una instancia de la clase Contrato
$contrato = new Contrato("2024-01-01", "2024-12-31", $plan1, 0, true, $clienteA);
echo $contrato->__toString() . "\n";

// Invocar el método incorporaPlan con uno de los planes creados
$contrato->incorporaPlan($plan2);
echo "Después de incorporar el nuevo plan:\n";
echo $contrato->__toString() . "\n";

// Creación de instancia de ContratoEmpresa con el plan1
$contratoEmpresa = new ContratoEmpresa("2024-06-12", "2025-06-12", $plan1, 0, true, $clienteA, [$canal1, $canal2]);

// Imprimir información del contrato antes de incorporar el nuevo plan
echo "Contrato antes de incorporar el nuevo plan:\n";
echo $contratoEmpresa->__toString() . "\n";

// Incorporar el plan2 al contrato existente
$contratoEmpresa->incorporaPlan($plan2);

// Imprimir información del contrato después de incorporar el nuevo plan
echo "Contrato después de incorporar el nuevo plan:\n";
echo $contratoEmpresa->__toString() . "\n";

// Obtener la fecha de hoy y la fecha de vencimiento (hoy + 30 días)
$hoy = new DateTime();
$vencimiento = clone $hoy;
$vencimiento->add(new DateInterval('P30D'));

// Crear instancia de ContratoWeb con los parámetros indicados
$contratoWeb = new ContratoWeb($hoy->format('Y-m-d'), $vencimiento->format('Y-m-d'), $plan1, 0, false, $clienteA);

// Imprimir información del contrato antes de incorporar
echo "Contrato Web antes de incorporar:\n";
echo $contratoWeb->__toString() . "\n";

// Imprimir información del contrato después de incorporar (simulado)
echo "Contrato Web después de incorporar:\n";
echo $contratoWeb->__toString() . "\n";

// Creación de instancia de ContratoEmpresa (ejemplo)
$contratoEmpresa = new ContratoEmpresa("2024-06-12", "2025-06-12", $plan1, 0, true, $clienteA, [$canal1, $canal2]);

// Imprimir información del contrato antes de pagar
echo "Contrato Empresa antes de pagar:\n";
echo $contratoEmpresa->__toString() . "\n";

// Invocar al método pagarContrato
$contratoEmpresa->pagarContrato($contratoEmpresa);

// Imprimir información del contrato después de pagar
echo "Contrato Empresa después de pagar:\n";
echo $contratoEmpresa->__toString() . "\n";

// Verificar si $contratoWeb es una instancia de ContratoWeb
if ($contratoWeb instanceof ContratoWeb) {
    // Imprimir información del contrato antes de pagar
    echo "Contrato Web antes de pagar:\n";
    echo $contratoWeb . "\n";

    // Invocar al método pagarContrato
    $contratoWeb->pagarContrato();

    // Imprimir información del contrato después de pagar
    echo "Contrato Web después de pagar:\n";
    echo $contratoWeb . "\n";
} else {
    echo "No se encontró un contrato válido de tipo ContratoWeb.\n";
}

$listaContratos = [
    new ContratoEmpresa("2024-06-12", "2025-06-12", $plan1, 1000, true, $clienteA, ["canal1", "canal2"]),
    new ContratoWeb("2024-06-12", "2025-06-12", $plan2, true, 1100, $clienteB),
    new ContratoWeb("2024-06-12", "2025-06-12", $plan1, true, 900, $clienteC),
];

// Función para retornar el importe de un contrato por código
function retornarImporteContratos($listaContratos, $codigoContrato) {
    $encontrado = false;
    $importeContrato = null;
    $iterator = 0;
    while (!$encontrado && $iterator < count($listaContratos)) {
        $contrato = $listaContratos[$iterator];
        if ($contrato->getObjPlan()->getCodigo() == $codigoContrato) {
            $importeContrato = $contrato->calcularImporte();
            $encontrado = true; // Cambiar la bandera a true cuando se encuentra el contrato
        }
        $iterator++;
    }
    return $importeContrato; // Retornar el importe del contrato o null si no se encuentra
}

// Código de contrato a buscar
$codigoContrato = 111;

// Llamar a la función para obtener el importe del contrato con código 111
$importeContrato = retornarImporteContratos($listaContratos, $codigoContrato);

// Verificar si se obtuvo un importe válido
if ($importeContrato !== null) {
    echo "El importe del contrato con código $codigoContrato es: $importeContrato\n";
} else {
    echo "No se encontró ningún contrato con el código $codigoContrato\n";
}