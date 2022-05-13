<?php 
include_once('../config/DB.php');


function gravarUsuario($variaveis) {
    $id_perfil = "";
    $nome = "";
    $email = "";
    $senha = "";
    if(isset($variaveis['id_perfil']) && !empty($variaveis['id_perfil'])){
        $id_perfil = $variaveis['id_perfil'];
    } else {
        $campos_vazios = true;
    }

    if(isset($variaveis['nome']) && !empty($variaveis['nome'])){
        $nome = $variaveis['nome'];
    } else {
        $campos_vazios = true;
    }

    if(isset($variaveis['email']) && !empty($variaveis['email'])){
        $email = $variaveis['email'];
    } else {
        $campos_vazios = true;
    }

    if(isset($variaveis['senha']) && !empty($variaveis['senha'])){
        $senha = $variaveis['senha'];
    } else {
        $campos_vazios = true;
    }

    if($campos_vazios){
        header('location: ../index.php?page=admin.usuario.novo&error=1');
    } else {   
        $conexao = conectaDB();

        $query = "INSERT INTO usuario SET id_perfil='".$id_perfil."', nome='".$nome."', email='".$email."', senha='".md5($senha)."'";

        mysqli_query($conexao, $query);

        if(mysqli_affected_rows($conexao) > 0) {
            header('location: ../index.php?page=admin.usuarios&info=1');
        } else {
            header('location: ../index.php?page=admin.usuario.novo&error=2');
        }

    }
  }

function editarUsuario($id, $variaveis) {
    $id_perfil = "";
    $nome = "";
    $email = "";
    $senha = "";
    if(isset($variaveis['id_perfil']) && !empty($variaveis['id_perfil'])){
        $id_perfil = $variaveis['id_perfil'];
    } else {
        $campos_vazios = true;
    }

    if(isset($variaveis['nome']) && !empty($variaveis['nome'])){
        $nome = $variaveis['nome'];
    } else {
        $campos_vazios = true;
    }

    if(isset($variaveis['email']) && !empty($variaveis['email'])){
        $email = $variaveis['email'];
    } else {
        $campos_vazios = true;
    }

    if(isset($variaveis['senha']) && !empty($variaveis['senha'])){
        $senha = $variaveis['senha'];
    } else {
        $campos_vazios = true;
    }

    if($campos_vazios){
        header('location: ../index.php?page=admin.usuario.editar&error=1');
    } else {   
        $conexao = conectaDB();

        $query = "UPDATE usuario SET id_perfil='".$id_perfil."', nome='".$nome."', email='".$email."', senha='".md5($senha)."' WHERE id=".$id;

        mysqli_query($conexao, $query);

        if(mysqli_affected_rows($conexao) > 0) {
            header('location: ../index.php?page=admin.usuarios&info=1');
        } else {
            header('location: ../index.php?page=admin.usuario.editar&id='.$id.'&error=2');
        }

    }
  }

  function eliminarUsuario($id) {
    $conexao = conectaDB();

    $query = "DELETE FROM usuario WHERE id=".$id;

    mysqli_query($conexao, $query);

    if(mysqli_affected_rows($conexao) > 0) {
        header('location: ../index.php?page=admin.usuarios&info=1');
    } else {
        header('location: ../index.php?page=admin.usuarios&error=1');
    }
  }
?>