<?php

include_once('DB.php');

//Abrir conexão a base de dados
$conexao = conectaDB();

//verificar se existe o utilizador superAdmin do sistema
$query = mysqli_query($conexao, 'SELECT * FROM usuario');

//Verifir se existe utilizador na Base de dados
if($query->num_rows == 0) {
    // se não existir, criar o primeiro utilizador
    $senha = md5('superadmin');
    $sql = "INSERT INTO usuario SET id_perfil=1, nome='Super Administrador', email='admin@isaf.co.ao',senha='".$senha."' ";
    inserir($sql);

    header('location: ../index.php');
}
print('O Sistema já se encontra Inicializado <a href="/isaf/parking.management/index.php">Ir para Página Inicial</a>');

?>