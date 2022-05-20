<?php

include_once('DB.php');

//Abrir conexão a base de dados
$conexao = conectaDB();

//Verifir se existe utilizador na Base de dados
for($i = 8; $i <= 25; $i++) {
    // se não existir, criar o primeiro utilizador
    $serie = 'ZL';
    if($i < 10) {
        $codigo = $serie.'00'.$i;
    } else {
        $codigo = $serie.'0'.$i;
    }
    //gerarEstacionamentos
    $desc = 'Espaço Leste';
    $sql = "INSERT INTO estacionamento SET codigo='".$codigo."', descricao='".$desc."', ordem='".$i."', estado=1";
    inserir($sql);
}
print('O Sistema já se encontra Inicializado <a href="/isaf/parking.management/index.php">Ir para Página Inicial</a>');

?>