<?php 
include_once('../Modelo/dashboard.php');

$res = array(
    'g1' => vendasUltimo7Dias(),
    'g2' => vandasMensais(),
    'g3' => PerformanceUltimos31Dias(),
    'g4' => entradasPorHoraUltimo30Dias(),
);
header('Content-Type: application/json; charset=utf-8');
echo json_encode($res, true);
?>