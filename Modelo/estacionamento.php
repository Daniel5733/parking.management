<?php 
include_once('../config/DB.php');


function gravarEstacionamento($variaveis) {
    $codigo = "";
    $descricao = "";
    $ordem = "";
    $estado = "";
   
    if(isset($variaveis['codigo']) && !empty($variaveis['codigo'])){
        $codigo = $variaveis['codigo'];
    } else {
        $campos_vazios = true;
    }

    if(isset($variaveis['descricao']) && !empty($variaveis['descricao'])){
        $descricao = $variaveis['descricao'];
    } else {
        $campos_vazios = true;
    }
    
    if(isset($variaveis['ordem']) && !empty($variaveis['ordem'])){
        $ordem = $variaveis['ordem'];
    } else {
        $campos_vazios = true;
    }
    
    if(isset($variaveis['estado']) && intval($variaveis['estado'])>=0){
        $estado = $variaveis['estado'];
    } else {
        $campos_vazios = true;
    }

    if($campos_vazios){
        header('location: ../index.php?page=admin.estacionamento.novo&error=1');
    } else {   
        $conexao = conectaDB();

        $query = "INSERT INTO estacionamento SET codigo='".$codigo."', descricao='".$descricao."', ordem='".$ordem."', estado='".$estado."'";

        mysqli_query($conexao, $query);

        if(mysqli_affected_rows($conexao) > 0) {
            header('location: ../index.php?page=admin.estacionamentos&info=1');
        } else {
            header('location: ../index.php?page=admin.estacionamento.novo&error=2');
        }

    }
  }

function editarEstacionamento($id, $variaveis) {
    $codigo = "";
    $descricao = "";
    $ordem = "";
    $estado = "";
   
    if(isset($variaveis['codigo']) && !empty($variaveis['codigo'])){
        $codigo = $variaveis['codigo'];
    } else {
        $campos_vazios = true;
    }

    if(isset($variaveis['descricao']) && !empty($variaveis['descricao'])){
        $descricao = $variaveis['descricao'];
    } else {
        $campos_vazios = true;
    }
    
    if(isset($variaveis['ordem']) && !empty($variaveis['ordem'])){
        $ordem = $variaveis['ordem'];
    } else {
        $campos_vazios = true;
    }
    
    if(isset($variaveis['estado']) && intval($variaveis['estado'])>=0){
        $estado = $variaveis['estado'];
    } else {
        $campos_vazios = true;
    }

    //print '<pre>';print_r($variaveis);die();
    if($campos_vazios){
        header('location: ../index.php?page=admin.estacionamento.editar&error=1');
    } else {   
        $conexao = conectaDB();

        $query = "UPDATE estacionamento SET codigo='".$codigo."', descricao='".$descricao."', ordem='".$ordem."', estado='".$estado."' WHERE id=".$id;

        mysqli_query($conexao, $query);

        if(mysqli_affected_rows($conexao) > 0) {
            header('location: ../index.php?page=admin.estacionamentos&info=1');
        } else {
            header('location: ../index.php?page=admin.estacionamento.editar&id='.$id.'&error=2');
        }

    }
  }

  function eliminarEstacionamento($id) {
    $conexao = conectaDB();

    $query = "DELETE FROM estacionamento WHERE id=".$id;

    mysqli_query($conexao, $query);

    if(mysqli_affected_rows($conexao) > 0) {
        header('location: ../index.php?page=admin.estacionamentos&info=1');
    } else {
        header('location: ../index.php?page=admin.estacionamentos&error=1');
    }
  }
?>