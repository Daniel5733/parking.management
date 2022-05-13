<?php 
include_once('../config/DB.php');


function gravarMarca($variaveis) {
    $nome = "";
   
    if(isset($variaveis['nome']) && !empty($variaveis['nome'])){
        $nome = $variaveis['nome'];
    } else {
        $campos_vazios = true;
    }

    if($campos_vazios){
        header('location: ../index.php?page=admin.marca.novo&error=1');
    } else {   
        $conexao = conectaDB();

        $query = "INSERT INTO marca SET nome='".$nome."'";

        mysqli_query($conexao, $query);

        if(mysqli_affected_rows($conexao) > 0) {
            header('location: ../index.php?page=admin.marcas&info=1');
        } else {
            header('location: ../index.php?page=admin.marca.novo&error=2');
        }

    }
  }

function editarMarca($id, $variaveis) {
    $nome = "";
    
    if(isset($variaveis['nome']) && !empty($variaveis['nome'])){
        $nome = $variaveis['nome'];
    } else {
        $campos_vazios = true;
    }

    if($campos_vazios){
        header('location: ../index.php?page=admin.marca.editar&error=1');
    } else {   
        $conexao = conectaDB();

        $query = "UPDATE marca SET nome='".$nome."' WHERE id=".$id;

        mysqli_query($conexao, $query);

        if(mysqli_affected_rows($conexao) > 0) {
            header('location: ../index.php?page=admin.marcas&info=1');
        } else {
            header('location: ../index.php?page=admin.marca.editar&id='.$id.'&error=2');
        }

    }
  }

  function eliminarMarca($id) {
    $conexao = conectaDB();

    $query = "DELETE FROM marca WHERE id=".$id;

    mysqli_query($conexao, $query);

    if(mysqli_affected_rows($conexao) > 0) {
        header('location: ../index.php?page=admin.marcas&info=1');
    } else {
        header('location: ../index.php?page=admin.marcas&error=1');
    }
  }
?>