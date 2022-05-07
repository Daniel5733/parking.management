<?php 
include_once('../config/DB.php');

$variaveis = $_POST;
$email = "";
$senha = "";
$campos_vazios = false;
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
    header('location: ../login.php?error=1');
} else {   
    $conexao = conectaDB();

    $query = "SELECT * from usuario WHERE email='$email' AND senha='".md5($senha)."' LIMIT 1";

    $consulta = mysqli_query($conexao, $query);

    if($consulta->num_rows >= 1) {
        $registo = mysqli_fetch_array($consulta);
        unset( $registo['senha']);
        // print'<pre>';print_r($registo);die();
        session_start();
        $_SESSION['usuario'] = $registo;
        header('location: ../index.php');
    } else {
        header('location: ../login.php?error=2');
    }

}

?>