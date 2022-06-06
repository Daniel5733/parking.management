<?php 
include_once('../config/DB.php');

function totalFaturacaoHoje() {
    $conexao = conectaDB();
    $sql = "SELECT 
        SUM(p.montante) as amount_today
    FROM 
        pagamento p
    WHERE
        DATE(p.data) = DATE(NOW()) 
    LIMIT 1
    ";
    $query = mysqli_query($conexao, $sql);
    $pagamento_hoje = 0;
    if($query->num_rows == 1) {
        $registo = mysqli_fetch_array($query);
        if($registo) {
            $pagamento_hoje = floatval($registo['amount_today']);
        } 
    }
    return $pagamento_hoje;
}

function totalFaturacaoUltimas3Horas() {
  $conexao = conectaDB();
  $sql = "SELECT AVG(p.montante) as amount_today FROM pagamento p WHERE p.data > DATE_ADD(NOW(), INTERVAL -3 HOUR)";
  $query = mysqli_query($conexao, $sql);
  $pagamento_hoje = 0;
  if($query->num_rows == 1) {
      $registo = mysqli_fetch_array($query);
      if($registo) {
          $pagamento_hoje = floatval($registo['amount_today']);
      } 
  }
  return $pagamento_hoje;
}

function previsaoFaturacao() {
  $conexao = conectaDB();
  $sql = "SELECT (AVG(p.montante) + AVG(p.montante)*0.2) as amount_today FROM pagamento p WHERE p.data > DATE_ADD(NOW(), INTERVAL -3 HOUR)";
  $query = mysqli_query($conexao, $sql);
  $pagamento_hoje = 0;
  if($query->num_rows == 1) {
      $registo = mysqli_fetch_array($query);
      if($registo) {
          $pagamento_hoje = floatval($registo['amount_today']);
      } 
  }
  return $pagamento_hoje;
}

function pegarEspacoLivres() {
    $conexao = conectaDB();

    $sql = "SELECT 
        COUNT(*) as total
    FROM 
        estacionamento m
    WHERE 
        estado = 1 AND
        id NOT IN (SELECT id_estacionamento FROM ticket WHERE data_entrada IS NOT NULL AND data_saida IS NULL) 
    LIMIT 1
    ";
    $query = mysqli_query($conexao, $sql);
    $totalLivre = 0;
    if($query->num_rows == 1) {
        $registo = mysqli_fetch_array($query);
        if($registo) {
            $totalLivre = floatval($registo['total']);
        } 
    }
    return $totalLivre;
}

function entradasHojeLivres() {
    $conexao = conectaDB();

    $sql = "SELECT COUNT(*) as total FROM ticket WHERE DATE(data_entrada) = DATE(NOW())";
    $query = mysqli_query($conexao, $sql);
    $total = 0;
    if($query->num_rows == 1) {
        $registo = mysqli_fetch_array($query);
        if($registo) {
            $total = floatval($registo['total']);
        } 
    } //$P$B21JSE9JRhYzZIIKttas9O3HmEYo6W1
    return $total;
}

function saidasHojeLivres() {

  $conexao = conectaDB();

  $sql = "SELECT COUNT(*) as total FROM ticket WHERE DATE(data_saida) = DATE(NOW())";
  $query = mysqli_query($conexao, $sql);
  $total = 0;
  if($query->num_rows == 1) {
      $registo = mysqli_fetch_array($query);
      if($registo) {
          $total = floatval($registo['total']);
      } 
  }
  return $total;
}

function PerformanceUltimos31Dias() {
  $vendas = array();
  $month_first_date =  date('Y-m-d', strtotime('-31 days', strtotime(date('Y-m-d H:i:s')))); //first date
  for ($i = 0; $i <= 31; $i++) {
      $data = date("Y-m-d", strtotime("+" . $i . " day", strtotime($month_first_date)));
      $montante = vendas_dia($data);

      $row = array('dia' => date("d", strtotime($data)).' '.monthName(date("M", strtotime($data))), "valor" => $montante ?? 0);
      $vendas[] =  $row;
  }
  return $vendas;
}

function vendasUltimo7Dias() {
  //hoje
  $faturacao_hoje = vendas_dia(date('Y-m-d'));
  $conexao = conectaDB();
  $sql = "SELECT 
    DATE(`data`) as  dia,
    SUM(`montante`) as montante 
  FROM 
    `pagamento` 
  WHERE 
    `data` BETWEEN NOW() - INTERVAL 6 DAY AND NOW()
  GROUP BY
    dia
  ";
  $query = mysqli_query($conexao, $sql);
  $grafico = array();
  if($query->num_rows > 0) {
    while($registo = mysqli_fetch_array($query)){
      $date = new DateTime($registo['dia']);
      $day_name = $date->format('D');
      $grafico[] = array(
        'dia' => dayName($day_name).'/'.$date->format('d'),
        'valor' => floatval($registo['montante'])
      );
    }
  }
  return array('faturacao_hoje' => (string)number_format((float)$faturacao_hoje, 2, ",", " "), 'grafico' => $grafico);
}

function vendas_dia($data) {
  $conexao = conectaDB();

  $sql = "SELECT SUM(`montante`) as montante FROM `pagamento` WHERE DATE(`data`) = '".$data."' LIMIT 1";
  $query = mysqli_query($conexao, $sql);
  $total = 0;
  if($query->num_rows == 1) {
      $registo = mysqli_fetch_array($query);
      if($registo) {
          $total = floatval($registo['montante']);
      } 
  }
  return $total;
}

function vandasMensais()
{
  $date = new DateTime();

  $first_month = $date->modify("-12 months")->format("Y-m");

    //hoje
  $faturacao_mes = vendas_mes(date('Y-m'));
  $grafico = null;
  for ($i = 0; $i <= 12; $i++) {
      $ano_mes = date("Y-m", strtotime("+" . $i . " months", strtotime($first_month)));
      $date = new DateTime($ano_mes);
      $year = date("Y", strtotime($ano_mes));
      $month_name = $date->format('M');
      $montante = vendas_mes($ano_mes);
      $grafico[] = array('mes' => monthName($month_name) . ' ' . $year , 'valor' => (float)$montante);
  }
  return array('faturacao_mes' => (string)number_format((float)$faturacao_mes, 2, ",", " "), 'grafico' => $grafico);
}

function vendas_mes($ano_mes) {
  $conexao = conectaDB();

  $sql = "SELECT SUM(`montante`) as montante FROM `pagamento` WHERE DATE_FORMAT(`data`, '%Y-%m') = '".$ano_mes."' LIMIT 1";
  $query = mysqli_query($conexao, $sql);
  $total = 0;
  if($query->num_rows == 1) {
      $registo = mysqli_fetch_array($query);
      if($registo) {
          $total = floatval($registo['montante']);
      } 
  }
  return $total;
}

function entradasPorHoraUltimo30Dias() {
  $conexao = conectaDB();
  $sql = "SELECT 
    CONCAT(HOUR(`data_entrada`), 'h') as hora,
    COUNT(*) as valor
  FROM 
    `ticket` 
  WHERE 
    `data_entrada` BETWEEN NOW() - INTERVAL 30 DAY AND NOW()
  GROUP BY hora
  ";
  $query = mysqli_query($conexao, $sql);
  $res = array();
  if($query->num_rows > 0) {
    while($registo = mysqli_fetch_array($query)){
      $res[] = array(
        'hora' => $registo['hora'],
        'val' => floatval($registo['valor'])
      );
    }
  }
  return $res;
}

function dayName($day)
{
    if ($day === 'Mon') {
        return 'Seg';
    } else if ($day === 'Tue') {
        return 'Ter';
    } else if ($day === 'Wed') {
        return 'Qua';
    } else if ($day === 'Thu') {
        return 'Qui';
    } else if ($day === 'Fri') {
        return 'Sex';
    } else if ($day === 'Sat') {
        return 'Sab';
    } else if ($day === 'Sun') {
        return 'Dom';
    }
    return '';
}


function monthName($day)
{
    if ($day === 'Jan') {
        return 'Jan';
    } else if ($day === 'Feb') {
        return 'Fev';
    } else if ($day === 'Mar') {
        return 'Mar';
      } else if ($day === 'Apr') {
          return 'Abr';
    } else if ($day === 'May') {
        return 'Mai';
    } else if ($day === 'Jun') {
        return 'Jun';
    } else if ($day === 'Jul') {
        return 'Jul';
    } else if ($day === 'Aug') {
        return 'Ago';
    } else if ($day === 'Sep') {
      return 'Set';
    } else if ($day === 'Oct') {
      return 'Out';
    } else if ($day === 'Nov') {
      return 'Nov';
    } else if ($day === 'Dec') {
      return 'Dez';
    }
    return '';
}

?>