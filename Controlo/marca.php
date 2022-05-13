<?php 
include_once('../Modelo/marca.php');
$metodo = $_GET['metodo'];
switch(strtolower($metodo)) {
    case 'gravar':
        gravarMarca($_POST);
      break;
    case 'editar':
        $id = $_GET['id'];
        editarMarca($id, $_POST);
        break;
    case 'eliminar':
        $id = $_GET['id'];
        eliminarMarca($id);
        break;
    default:
      // Error Page
      break;
  }

?>
