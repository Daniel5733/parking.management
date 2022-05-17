<?php 
include_once('../Modelo/promocao.php');
$metodo = $_GET['metodo'];
switch(strtolower($metodo)) {
    case 'gravar':
        gravarPromocao($_POST);
      break;
    case 'editar':
        $id = $_GET['id'];
        editarPromocao($id, $_POST);
        break;
    case 'eliminar':
        $id = $_GET['id'];
        eliminarPromocao($id);
        break;
    default:
      // Error Page
      break;
  }

?>
