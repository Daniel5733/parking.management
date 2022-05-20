<?php 
include_once('../config/DB.php');

function gerarTicket($variaveis) {
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
        header('location: ../index.php?page=admin.ticket.novo&error=1');
    } else {   
        $conexao = conectaDB();

        $query = "INSERT INTO ticket SET id_marca='".$id_marca."', nome='".$nome."'";

        mysqli_query($conexao, $query);

        if(mysqli_affected_rows($conexao) > 0) {
            header('location: ../index.php?page=admin.tickets&info=1');
        } else {
            header('location: ../index.php?page=admin.ticket.novo&error=2');
        }

    }
  }

function finalizarTicket($id) {

    $conexao = conectaDB();

    $query = "UPDATE ticket SET data_saida=NOW() WHERE id=".$id;

    mysqli_query($conexao, $query);

    if(mysqli_affected_rows($conexao) > 0) {
        header('location: ../index.php?page=tickets&info=1');
    } else {
        header('location: ../index.php?page=tickets&error=1');
    }
  }

?>