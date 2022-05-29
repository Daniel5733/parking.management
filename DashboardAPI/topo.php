<?php 
include_once('../Modelo/dashboard.php');

$res = array(
    'pagamento_hoje' => totalFaturacaoHoje(),
    'espaco_livre' => pegarEspacoLivres(),
    'entradas_hoje' => entradasHojeLivres(),
    'saidas_hoje' => saidasHojeLivres(),
    'ultimas3Horas' => totalFaturacaoUltimas3Horas(),
    'previsaoFaturacao' => previsaoFaturacao()
);
header('Content-Type: application/json; charset=utf-8');
echo json_encode($res, true);
?>