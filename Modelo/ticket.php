<?php 
include_once('../config/DB.php');
include_once('../config/qrcode.php');

session_start();

function verificarMatricula($matricula) {
    $conexao = conectaDB();

    $sql = "SELECT 
        v.*
    FROM 
        veiculo v
    WHERE
        v.matricula='".$matricula."'
    LIMIT 1
    ";
    $query = mysqli_query($conexao, $sql);
    if($query->num_rows == 1) {
        $registo = mysqli_fetch_array($query);
        $resposta = verificarEntrada($conexao, $registo['id']);
        if($resposta) {
            header('location: ../index.php?page=tickets&warn=1');
        } else {
            header('location: ../index.php?page=novo_ticket&id='.$registo['id']);
        }
    } else {
        header('location: ../index.php?page=novo_ticket&matricula='.$matricula);
    }
    //print '<pre>'; print_r($registo); die();
}
function verificarEntrada($conexao, $id_veiculo) {
    $sql = "SELECT 
        *
    FROM 
        ticket
    WHERE
        data_saida IS NULL AND
        id_veiculo = '".$id_veiculo."'
    LIMIT 1
    ";
    $query_preco = mysqli_query($conexao, $sql);
    if($query_preco->num_rows == 1) {
        return true;
    } 
    return false;
}

function gravarVeiculo($variaveis) {
    $conexao = conectaDB();
    $id_veiculo = "";
    $id_modelo = "";
    $matricula = "";
    $cor = "";
    $id_estacionamento = "";
    $campos_vazios = false;

    if(isset($variaveis['id_veiculo']) && intval($variaveis['id_veiculo']) > 0){
        $id_veiculo = $variaveis['id_veiculo'];
    } else {
        if(isset($variaveis['id_modelo']) && !empty($variaveis['id_modelo'])){
            $id_modelo = $variaveis['id_modelo'];
        } else {
            $campos_vazios = true;
        }
    
        if(isset($variaveis['matricula']) && !empty($variaveis['matricula'])){
            $matricula = $variaveis['matricula'];
        } else {
            $campos_vazios = true;
        }
    
        if(isset($variaveis['cor']) && !empty($variaveis['cor'])){
            $cor = $variaveis['cor'];
        } else {
            $campos_vazios = true;
        }
    }

    if(isset($variaveis['id_estacionamento']) && !empty($variaveis['id_estacionamento'])){
        $id_estacionamento = $variaveis['id_estacionamento'];
    } else {
        $id_estacionamento = pegarEspacoAleatorio($conexao);
    }

    if($campos_vazios){
        header('location: ../index.php?page=novo_ticket&error=1');
    } else {   
        if(empty($id_veiculo)) {
            $query = "INSERT INTO veiculo  SET id_modelo='".$id_modelo."', matricula='".$matricula."', cor='".$cor."', id_usuario='".$_SESSION['usuario']['id']."', data_criacao=NOW()";

            mysqli_query($conexao, $query);
            $id_veiculo = mysqli_insert_id($conexao);
        }
        if($id_veiculo > 0) {
            $montante = precoHoje($conexao);
            $sqlTicket = "INSERT INTO ticket SET id_estacionamento='".$id_estacionamento."', id_veiculo='".$id_veiculo."', montante='".$montante."', id_usuario='".$_SESSION['usuario']['id']."', data_entrada=NOW()";
            $id_ticket = inserir($sqlTicket);
            inserirPromocao($conexao, $id_ticket);
            //header('location: ../index.php?page=tickets&info=1');
            //Ir para impressão
            $qc = new QRCODE();
            // Create Text Code
            $localIP = "192.168.1.4";
            $qc->URL('http://'.$localIP.':8888/isaf/parking.management/index.php?page=novo_ticket&id='.$id_ticket);
            // Save QR Code
            $qc->QRCODE(400, "ticket".$id_ticket.".png");
        } else {
            header('location: ../index.php?page=tickets&error=1');
        }
    }
  }

function pegarEspacoAleatorio($conexao) {
    $sql = "SELECT 
        m.id,
        m.codigo,
        m.descricao
    FROM 
        estacionamento m
    WHERE 
        estado = 1 AND
        id NOT IN (SELECT id_estacionamento FROM ticket WHERE data_entrada IS NOT NULL AND data_saida IS NULL) 
    ORDER BY
        RAND()
    LIMIT 1
    ";
    $query_espaco = mysqli_query($conexao, $sql);
    if($query_espaco->num_rows == 1) {
        $espaco = mysqli_fetch_array($query_espaco);
        return $espaco['id'];
    } else {
        return 0;
    }
}

function inserirPromocao($conexao, $id_ticket) {
    $sql = "SELECT 
        *
    FROM 
        `promocao` 
    WHERE
        data_inicio <= DATE(NOW()) AND data_fim >= DATE(NOW())
    ";
    $query = mysqli_query($conexao, $sql);

    while($promo = mysqli_fetch_array($query)) {
        $ticketPromoSql = "INSERT INTO ticket_promocao  SET id_ticket='".$id_ticket."', id_promocao='".$promo['id']."'";
        inserir($ticketPromoSql);
    }
}

function precoHoje($conexao) {
    $dia_semana = date('N', strtotime('Now'));
    $sql = "SELECT 
        p.*
    FROM 
        preco p
    WHERE
        p.dia_semana='".$dia_semana."'
    LIMIT 1
    ";
    $query_preco = mysqli_query($conexao, $sql);
    if($query_preco->num_rows == 1) {
        $preco = mysqli_fetch_array($query_preco);
        return $preco['primeira_hora'];
    } else {
        return 0;
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