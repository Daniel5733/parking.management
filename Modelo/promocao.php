<?php 
include_once('../config/DB.php');


function gravarPromocao($variaveis) {
    $titulo = "";
    $valor = "";
    $data_inicio = "";
    $data_fim = "";
   
    if(isset($variaveis['titulo']) && !empty($variaveis['titulo'])){
        $titulo = $variaveis['titulo'];
    } else {
        $campos_vazios = true;
    }

    if(isset($variaveis['valor']) && !empty($variaveis['valor'])){
        $valor = $variaveis['valor'];
    } else {
        $campos_vazios = true;
    }
    
    if(isset($variaveis['data_inicio']) && !empty($variaveis['data_inicio'])){
        $data_inicio = $variaveis['data_inicio'];
    } else {
        $campos_vazios = true;
    }
    
    if(isset($variaveis['data_fim']) && intval($variaveis['data_fim'])>=0){
        $data_fim = $variaveis['data_fim'];
    } else {
        $campos_vazios = true;
    }

    if($campos_vazios){
        header('location: ../index.php?page=admin.promocao.novo&error=1');
    } else {   
        $conexao = conectaDB();

        $dateInicio = DateTime::createFromFormat('d/m/Y', $data_inicio)->format('Y-m-d');
        $dataFim = DateTime::createFromFormat('d/m/Y', $data_fim)->format('Y-m-d');
        $query = "INSERT INTO promocao SET titulo='".$titulo."', valor=".(int)$valor.", data_inicio='".$dateInicio."', data_fim='".$dataFim."'";

        //print_r($variaveis);
        //print_r($query);die();
        mysqli_query($conexao, $query);

        if(mysqli_affected_rows($conexao) > 0) {
            header('location: ../index.php?page=admin.promocao&info=1');
        } else {
            header('location: ../index.php?page=admin.promocao.novo&error=2');
        }

    }
  }

function editarPromocao($id, $variaveis) {
    $titulo = "";
    $valor = "";
    $data_inicio = "";
    $data_fim = "";
   
    if(isset($variaveis['titulo']) && !empty($variaveis['titulo'])){
        $titulo = $variaveis['titulo'];
    } else {
        $campos_vazios = true;
    }

    if(isset($variaveis['valor']) && !empty($variaveis['valor'])){
        $valor = $variaveis['valor'];
    } else {
        $campos_vazios = true;
    }
    
    if(isset($variaveis['data_inicio']) && !empty($variaveis['data_inicio'])){
        $data_inicio = $variaveis['data_inicio'];
    } else {
        $campos_vazios = true;
    }
    
    if(isset($variaveis['data_fim']) && intval($variaveis['data_fim'])>=0){
        $data_fim = $variaveis['data_fim'];
    } else {
        $campos_vazios = true;
    }

    //print '<pre>';print_r($variaveis);die();
    if($campos_vazios){
        header('location: ../index.php?page=admin.promocao.editar&error=1');
    } else {   
        $conexao = conectaDB();

        $dateInicio = DateTime::createFromFormat('d/m/Y', $data_inicio)->format('Y-m-d');
        $dataFim = DateTime::createFromFormat('d/m/Y', $data_fim)->format('Y-m-d');
        $query = "UPDATE promocao SET titulo='".$titulo."', valor='".$valor."', data_inicio='".$dateInicio."', data_fim='".$dataFim."' WHERE id=".$id;

        mysqli_query($conexao, $query);

        if(mysqli_affected_rows($conexao) > 0) {
            header('location: ../index.php?page=admin.promocao&info=1');
        } else {
            header('location: ../index.php?page=admin.promocao.editar&id='.$id.'&error=2');
        }

    }
  }

  function eliminarPromocao($id) {
    $conexao = conectaDB();

    $query = "DELETE FROM promocao WHERE id=".$id;

    mysqli_query($conexao, $query);

    if(mysqli_affected_rows($conexao) > 0) {
        header('location: ../index.php?page=admin.promocao&info=1');
    } else {
        header('location: ../index.php?page=admin.promocao&error=1');
    }
  }
?>