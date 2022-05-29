<?php 

function conectaDB() {
    $host = "127.0.0.1";
    $user = 'root';
    $pass = 'root';
    $database = 'gest_parque';
    $port = '8889';
    
    return mysqli_connect($host, $user, $pass, $database, $port);
}

function inserir($query) {
    try {
        $con = conectaDB();
        mysqli_query($con, $query);
        return mysqli_insert_id($con);
    } catch(Exception $e) {
        return $e->getMessage();
    }
}

function actualizar($query) {
    try {
        $con = conectaDB();
        mysqli_query($con, $query);
        return true;
    } catch(Exception $e) {
        return false;
    }
}


function apagar($query) {
    try {
        $con = conectaDB();
        mysqli_query($con, $query);
        return true;
    } catch(Exception $e) {
        return false;
    }
}

function atualizarPecoTickets() {
    $conexao = conectaDB();
    $query_ticket = mysqli_query($conexao, 'SELECT * FROM ticket WHERE data_saida IS NULL');
    while($tk = mysqli_fetch_array($query_ticket)) {

        $totalDesconto = 0;
        $sql = "SELECT SUM(`valor`) as value FROM `promocao` WHERE DATE(`data_inicio`) <= NOW() AND DATE(`data_fim`) >= NOW() ";
        $query_desconto = mysqli_query($conexao, $sql);
        if($query_desconto->num_rows == 1) {
          $desconto = mysqli_fetch_array($query_desconto);
          $totalDesconto = $desconto['value'];
        }
        $dia_semana = date('N', strtotime($tk['data_entrada']));
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
          $dataInicio = $tk['data_entrada'];
          $date1 = strtotime($dataInicio);
          $date2 = strtotime('now');
          $diff = $date2 - $date1;
          $hours = $diff / ( 60*60 );
          //$hours = $hours + 1;
          //print_r($tk['data_entrada']);
          $preco_actual = 0;
          for($i = 0; $i <= $hours; $i++) {
            if($i==0) {
              $preco_actual = $preco_actual + $preco['primeira_hora'];
            } else if($i == 1) {
              $preco_actual = $preco_actual + $preco['segunda_hora'];
            } else {
              $preco_actual = $preco_actual + $preco['restante'];
            }
          }
          //print_r($preco_actual);die();
          if(floatval($totalDesconto) > 0) {
            $preco_actual = ($preco_actual - ($preco_actual * (floatval($totalDesconto) / 100)));
          }
          $sqlAtualizar = "UPDATE ticket SET montante=".$preco_actual." WHERE id=".$tk['id'];
          actualizar($sqlAtualizar);
        }
    }
  }

?>