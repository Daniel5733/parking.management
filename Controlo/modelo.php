<?php 
include_once('../Modelo/modelo.php');
$metodo = $_GET['metodo'];
switch(strtolower($metodo)) {
    case 'gravar':
        gravarModelo($_POST);
      break;
    case 'editar':
        $id = $_GET['id'];
        editarModelo($id, $_POST);
        break;
    case 'eliminar':
        $id = $_GET['id'];
        eliminarModelo($id);
        break;
    default:
      // Error Page
      break;
  }

?>
