<?php 
include_once('../config/DB.php');

function editarPreco($variaveis) {
    $precos = "";
   
    if(isset($variaveis['preco']) && !empty($variaveis['preco'])){
        $precos = $variaveis['preco'];
    } else {
        $campos_vazios = true;
    }

    //print '<pre>';print_r($variaveis);die();
    if($campos_vazios){
        header('location: ../index.php?page=admin.preco&error=1');
    } else {   
        $conexao = conectaDB();

        //Foreach here
        foreach($precos as $dia_semana => $preco) {
            $query = "UPDATE preco SET primeira_hora='".$preco['primeira_hora']."', segunda_hora='".$preco['segunda_hora']."', restante='".$preco['restante']."' WHERE dia_semana=".(int)$dia_semana."";

            mysqli_query($conexao, $query);

        }

        header('location: ../index.php?page=admin.preco&info=1');

    }
  }

?>