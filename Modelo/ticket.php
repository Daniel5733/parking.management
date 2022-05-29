<?php 
include_once('../config/DB.php');
include_once('../config/qrcode.php');
require_once('../dompdf/autoload.inc.php'); 

use Dompdf\Dompdf;

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
    $foto = "";
    $id_estacionamento = "";
    $campos_vazios = false;

    if(isset($variaveis['id_veiculo']) && intval($variaveis['id_veiculo']) > 0){
        $id_veiculo = $variaveis['id_veiculo'];
        if(isset($variaveis['matricula']) && !empty($variaveis['matricula'])){
            $matricula = $variaveis['matricula'];
        }
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

    if(isset($variaveis['foto']) && !empty($variaveis['foto'])){
        $foto = $variaveis['foto'];
    }
    
    if(isset($variaveis['id_estacionamento']) && !empty($variaveis['id_estacionamento'])){
        $id_estacionamento = $variaveis['id_estacionamento'];
    } else {
        $id_estacionamento = pegarEspacoAleatorio($conexao);
    }

    if($campos_vazios){
        header('location: ../index.php?page=novo_ticket&error=1');
    } else {
        $data_e = date('Y-m-d H:i:s'); 
        if(empty($id_veiculo)) {
            $query = "INSERT INTO veiculo  SET id_modelo='".$id_modelo."', matricula='".$matricula."', cor='".$cor."', foto='".$foto."', id_usuario='".$_SESSION['usuario']['id']."', data_criacao='".$data_e."'";
            mysqli_query($conexao, $query);
            $id_veiculo = mysqli_insert_id($conexao);
        }
        if($id_veiculo > 0) {
            $montante = precoHoje($conexao);
            if(!empty($foto)) {
                $sqlFotoveiculo = "UPDATE veiculo SET foto='".$foto."' WHERE id = ".$id_veiculo;
                actualizar($sqlFotoveiculo);
            }
            $sqlTicket = "INSERT INTO ticket SET id_estacionamento='".$id_estacionamento."', id_veiculo='".$id_veiculo."', montante='".$montante."', id_usuario='".$_SESSION['usuario']['id']."', foto='".$foto."', data_entrada='".$data_e."'";
            $id_ticket = inserir($sqlTicket);
            inserirPromocao($conexao, $id_ticket);
            //header('location: ../index.php?page=tickets&info=1');
            generateTicketPdf($matricula, $id_ticket, $data_e);
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

function calcularPecoTicket($conexao, $id) {
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
function finalizarTicket($variaveis) {

    $conexao = conectaDB();
    $id_ticket = "";
    $montante = "";
    $campos_vazios = false;
    if(isset($variaveis['id']) && !empty($variaveis['id'])){
        $id_ticket = $variaveis['id'];
        if(!isset($variaveis['pago']) || intval($variaveis['pago']) < 1){
            $campos_vazios = true;
        }

        if(isset($variaveis['montante']) && intval($variaveis['montante'])> 0){
            $montante = $variaveis['montante'];
        } else {
            $campos_vazios = true;
        }
    
        if($campos_vazios){
            header('location: ../index.php?page=finalizar_ticket&id='.$id_ticket.'&error=1');
        } else {   
            if(!empty($id_ticket)) {
                $data_s = date('Y-m-d H:i:s'); 
                $query = "UPDATE ticket SET data_saida='".$data_s."' WHERE id=".$id_ticket;
    
                mysqli_query($conexao, $query);
                if(mysqli_affected_rows($conexao) > 0) {
                    $sqlPagamento = "INSERT INTO pagamento SET id_ticket='".$id_ticket."', montante='".$montante."', data='".$data_s."'";
                    inserir($sqlPagamento);
                    generateTicketSaidaPdf($montante, $data_s, $conexao);
                }
                //header('location: ../index.php?page=tickets&info=1');
            }
        }
    } else {
        header('location: ../index.php?page=tickets&error=1');
    }
}
function  listPromosFuturas($conexao) {
    $sql = "SELECT 
        p.*
    FROM 
        promocao p
    WHERE
        data_inicio > NOW() AND
        data_fim > NOW()
    LIMIT 3
    ";
    return mysqli_query($conexao, $sql);
  }
  function generateTicketPdf($matricula, $id_ticket, $data_e) {
    //Gerar QrCode
    $qc = new QRCODE();
    //$localIP = "192.168.238.59";
    $localIP = getHostByName(getHostName()) ;
    $qc->URL('http://'.$localIP.':8888/isaf/parking.management/cliente.php?id='.$id_ticket);
    $qrFicheiro = "../qrCodes/ticket".$id_ticket.".png";
    $qc->QRCODE(100, $qrFicheiro);

    //Gerar PDF
    $dompdf = new Dompdf();
    $options = $dompdf->getOptions(); 
    $options->set(array('isRemoteEnabled' => true));
    $dompdf->setOptions($options);
    $qr = 'http://'.$localIP.':8888/isaf/parking.management/qrCodes/ticket'.$id_ticket.'.png';
	$dompdf->loadHtml('<html>
    <head>
    <title>Garagem MED</title>
    <style>
    @page { margin: 0px; }
    body {
      margin: 2px;
      text-align: center;
      color: black;
      font-family: Arial, Helvetica, sans-serif;
      font-size: 12px;
    }
    </style>
    </head>
    <body>
    <h3>Garagem MED</h3>
    <p>Bem-vindo ao Parque</p>
    <p>'.$matricula.'</p>
    <p>Ticket: '.$id_ticket.'</p>
    <p>'.date('d/m/Y H:i:s', strtotime($data_e)).'</p>
    <img src="'.$qr.'" alt="qrcode" style="width:200px">
    </body>
    </html>');

	// (Optional) Setup the paper size and orientation
	$dompdf->setPaper('A7', 'portrait');

	// Render the HTML as PDF
	$dompdf->render();

	// Output the generated PDF to Browser
	$dompdf->stream();
  }

  function generateTicketSaidaPdf($montante, $data_s, $conexao) {
    
    $promos = listPromosFuturas($conexao);
    //Gerar PDF
    $dompdf = new Dompdf();
    $options = $dompdf->getOptions(); 
    $options->set(array('isRemoteEnabled' => true));
    $dompdf->setOptions($options);
    $htmlPromos = '';
    while($promo = mysqli_fetch_array($promos)) {
        $htmlPromos .= '<p>'.$promo['titulo'].' - '.$promo['valor'].'% ('.$promo['data_inicio'].') </p>';
    }
	$dompdf->loadHtml('<html>
    <head>
    <title>Garagem MED</title>
    <style>
    @page { margin: 0px; }
    body {
      margin: 2px;
      text-align: center;
      color: black;
      font-family: Arial, Helvetica, sans-serif;
      font-size: 12px;
    }
    </style>
    </head>
    <body>
    <h3>Garagem MED</h3>
    <p>Volte Sempre</p>
    <p>Pago: '.$montante.'</p>
    <p>'.date('d/m/Y H:i:s', strtotime($data_s)).'</p>
	<h4>Promoções Futuras: </h4>
    '.$htmlPromos.'
    </body>
    </html>');

	// (Optional) Setup the paper size and orientation
	$dompdf->setPaper('A7', 'portrait');

	// Render the HTML as PDF
	$dompdf->render();

	// Output the generated PDF to Browser
	$dompdf->stream();
  }

?>