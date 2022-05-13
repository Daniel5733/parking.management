<?php 
include_once('../config/DB.php');


function gravarModelo($variaveis) {
    $id_marca = "";
    $nome = "";
    $email = "";
    $senha = "";
    if(isset($variaveis['id_marca']) && !empty($variaveis['id_marca'])){
        $id_marca = $variaveis['id_marca'];
    } else {
        $campos_vazios = true;
    }

    if(isset($variaveis['nome']) && !empty($variaveis['nome'])){
        $nome = $variaveis['nome'];
    } else {
        $campos_vazios = true;
    }

    if($campos_vazios){
        header('location: ../index.php?page=admin.modelo.novo&error=1');
    } else {   
        $conexao = conectaDB();

        $query = "INSERT INTO modelo SET id_marca='".$id_marca."', nome='".$nome."'";

        mysqli_query($conexao, $query);

        if(mysqli_affected_rows($conexao) > 0) {
            header('location: ../index.php?page=admin.modelos&info=1');
        } else {
            header('location: ../index.php?page=admin.modelo.novo&error=2');
        }

    }
  }

function editarModelo($id, $variaveis) {
    $id_marca = "";
    $nome = "";
    if(isset($variaveis['id_marca']) && !empty($variaveis['id_marca'])){
        $id_marca = $variaveis['id_marca'];
    } else {
        $campos_vazios = true;
    }

    if(isset($variaveis['nome']) && !empty($variaveis['nome'])){
        $nome = $variaveis['nome'];
    } else {
        $campos_vazios = true;
    }

    if($campos_vazios){
        header('location: ../index.php?page=admin.modelo.editar&error=1');
    } else {   
        $conexao = conectaDB();

        $query = "UPDATE modelo SET id_marca='".$id_marca."', nome='".$nome."' WHERE id=".$id;

        mysqli_query($conexao, $query);

        if(mysqli_affected_rows($conexao) > 0) {
            header('location: ../index.php?page=admin.modelos&info=1');
        } else {
            header('location: ../index.php?page=admin.modelo.editar&id='.$id.'&error=2');
        }

    }
  }

  function eliminarModelo($id) {
    $conexao = conectaDB();

    $query = "DELETE FROM modelo WHERE id=".$id;

    mysqli_query($conexao, $query);

    if(mysqli_affected_rows($conexao) > 0) {
        header('location: ../index.php?page=admin.modelos&info=1');
    } else {
        header('location: ../index.php?page=admin.modelos&error=1');
    }
  }
?>