<?php 
include_once('../Modelo/usuaio.php');
$metodo = $_GET['metodo'];
switch(strtolower($metodo)) {
    case 'gravar':
        gravarUsuario($_POST);
      break;
    case 'editar':
        $id = $_GET['id'];
        editarUsuario($id, $_POST);
        break;
    case 'eliminar':
        $id = $_GET['id'];
        eliminarUsuario($id);
        break;
    default:
      // Error Page
      break;
  }

?>
