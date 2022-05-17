<?php 
include_once('../Modelo/preco.php');
$metodo = $_GET['metodo'];
switch(strtolower($metodo)) {
    case 'editar':
        editarPreco($_POST);
        break;
    default:
      // Error Page
      break;
  }

?>
