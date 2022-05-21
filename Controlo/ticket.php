<?php 
include_once('../Modelo/ticket.php');
$metodo = $_GET['metodo'];
switch(strtolower($metodo)) {
  case 'verificar-matricula':
    if(isset($_POST['matricula']) && !empty($_POST['matricula'])) {
      verificarMatricula($_POST['matricula']);
    } else {
      header('location: ../index.php?page=novo_ticket&matricula='.$matricula);
    }
  break;
  case 'gravar':
    gravarVeiculo($_POST);
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
