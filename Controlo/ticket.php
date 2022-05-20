<?php 
include_once('../Modelo/ticket.php');
$metodo = $_GET['metodo'];
switch(strtolower($metodo)) {
  case 'gravar':
    gerarTicket($_POST);
  break;
  case 'finalizar':
    $id = $_GET['id'];
    finalizarTicket($id);
  break;
  default:
    // Error Page
    break;
  }

?>
