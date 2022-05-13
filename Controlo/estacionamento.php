<?php 
include_once('../Modelo/estacionamento.php');
$metodo = $_GET['metodo'];
switch(strtolower($metodo)) {
    case 'gravar':
        gravarEstacionamento($_POST);
      break;
    case 'editar':
        $id = $_GET['id'];
        editarEstacionamento($id, $_POST);
        break;
    case 'eliminar':
        $id = $_GET['id'];
        eliminarEstacionamento($id);
        break;
    default:
      // Error Page
      break;
  }

?>
