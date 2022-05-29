<?php 
include_once('config/DB.php');
atualizarPecoTickets();
if(!isset($_GET['id'])) {
  header('location: error404.php');
}
$conexao = conectaDB();
$sql = "SELECT 
t.montante,
t.id as id_ticket,
e.codigo,
v.matricula
FROM 
ticket t,
estacionamento e,
veiculo v 
WHERE
t.id_estacionamento = e.id AND
t.id_veiculo = v.id AND
t.data_saida IS NULL AND
t.id = ".(int)$_GET['id']."
LIMIT 1
";
$query = mysqli_query($conexao, $sql);
if($query->num_rows == 1) {
  $registo = mysqli_fetch_array($query);
} else {
  header('location: error404.php');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Garagem MED | Ticket</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="assets/css/adminlte.min.css">
</head>
<body class="hold-transition login-page">
<div class="col-md-4">
            <!-- Widget: user widget style 2 -->
            <div class="card card-widget widget-user-2 shadow-sm">
              <!-- Add the bg color to the header using any of the bg-* classes -->
              <div class="widget-user-header bg-info">
                <!-- /.widget-user-image -->
                <h3 class="text-center">Garagem <b>MED</b></h3>
              </div>
              <div class="card-footer p-0">
                <ul class="nav flex-column">
                  <li class="nav-item">
                    <a href="#" class="nav-link">
                      Ticket <span class="float-right badge bg-info"><?php echo $registo['id_ticket']; ?></span>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="#" class="nav-link">
                      Matricula <span class="float-right badge bg-info"><?php echo $registo['matricula']; ?></span>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="#" class="nav-link">
                      Estacionamento <span class="float-right badge bg-info"><?php echo $registo['codigo']; ?></span>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="#" class="nav-link">
                      Custo <span class="float-right badge bg-danger"><?php echo $registo['montante']; ?></span>
                    </a>
                  </li>
                </ul>
              </div>
            </div>
            <!-- /.widget-user -->
          </div>
<div class="login-box">
  
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="assets/js/adminlte.min.js"></script>
</body>
</html>
