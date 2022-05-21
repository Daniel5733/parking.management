<?php 
session_start();
if(!isset($_SESSION['usuario'])) {
  header('location: login.php');
} else {
  $page = $_GET['page'] ?? 'dashboard';
  $page_include = "";
  $title = "";
  switch(strtolower($page)) {
    case 'estacionamentos':
      $title = "Espaços de Estacionamento";
      $page_include = "Visao/components/estacionamentos.php";
      break;
    case 'tickets':
      $title = "Tickets";
      $page_include = "Visao/components/tickets.php";
      break;
    case 'novo_ticket':
      $title = "Informe o Veículo";
      $page_include = "Visao/components/novo_ticket.php";
      break;
    // Admin
    case 'admin.usuarios':
      $title = "Gestão de Utilizadores";
      $page_include = "Visao/admin.components/usuarios.php";
      break;
    case 'admin.usuario.novo':
      $title = "Novo Utilizador";
      $page_include = "Visao/admin.components/novo_usuario.php";
      break;
    case 'admin.usuario.editar':
      $title = "Editar Utilizador";
      $page_include = "Visao/admin.components/editar_usuario.php";
      break;
    case 'admin.marcas':
      $title = "Gestão de Marcas";
      $page_include = "Visao/admin.components/marca.php";
      break;
    case 'admin.marca.novo':
      $title = "Nova Marca";
      $page_include = "Visao/admin.components/nova_marca.php";
      break;
    case 'admin.marca.editar':
      $title = "Editar Marca";
      $page_include = "Visao/admin.components/editar_marca.php";
      break;
    case 'admin.modelos':
      $title = "Gestão de Modelos";
      $page_include = "Visao/admin.components/modelo.php";
      break;
    case 'admin.modelo.novo':
      $title = "Novo Modelo";
      $page_include = "Visao/admin.components/novo_modelo.php";
      break;
    case 'admin.modelo.editar':
      $title = "Editar Modelo";
      $page_include = "Visao/admin.components/editar_modelo.php";
      break;
    case 'admin.estacionamentos':
      $title = "Gestão de Estacionamentos";
      $page_include = "Visao/admin.components/estacionamento.php";
      break;
    case 'admin.estacionamento.novo':
      $title = "Novo Estacionamento";
      $page_include = "Visao/admin.components/novo_estacionamento.php";
      break;
    case 'admin.estacionamento.editar':
      $title = "Editar Estacionamento";
      $page_include = "Visao/admin.components/editar_estacionamento.php";
      break;
    case 'admin.promocao':
      $title = "Gestão de Promoções";
      $page_include = "Visao/admin.components/promocao.php";
      break;
    case 'admin.promocao.novo':
      $title = "Novo Promoção";
      $page_include = "Visao/admin.components/novo_promocao.php";
      break;
    case 'admin.promocao.editar':
      $title = "Editar Promoção";
      $page_include = "Visao/admin.components/editar_promocao.php";
      break;
    case 'admin.preco':
      $title = "Gestão de Preços";
      $page_include = "Visao/admin.components/preco.php";
      break;
    case 'admin.preco.novo':
      $title = "Novo Preço";
      $page_include = "Visao/admin.components/novo_preco.php";
      break;
    case 'admin.preco.editar':
      $title = "Editar Preço";
      $page_include = "Visao/admin.components/editar_preco.php";
      break;
    default:
      $title = "Dashboard";
      $page_include = "Visao/components/dashboard.php";
      break;
  }
}
?>
<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Garagem MED | <?php echo $title; ?></title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">  
  <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">
  <link rel="stylesheet" href="plugins/select2/css/select2.min.css">
  <link rel="stylesheet" href="plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="assets/css/adminlte.min.css">
  <!-- REQUIRED SCRIPTS -->
  <!-- jQuery -->
  <script src="plugins/jquery/jquery.min.js"></script>
  <!-- Bootstrap 4 -->
  <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="plugins/select2/js/select2.full.min.js"></script>
   <!-- AdminLTE App -->
  <script src="assets/js/adminlte.min.js"></script>
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
      <img src="assets/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">Garagem MED</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="assets/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block"><?php echo $_SESSION['usuario']['nome'];?></a>
        </div>
      </div>
      <?php include('Visao/commons.components/menu.php'); ?>
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0"><?php echo $title; ?></h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">App</a></li>
              <li class="breadcrumb-item active"><?php echo $title; ?></li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <!-- /Every include page will have this Row at first -->
        <?php include($page_include); ?>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Main Footer -->
  <footer class="main-footer">
    <!-- To the right -->
    <div class="float-right d-none d-sm-inline">
      <a href="./Controlo/logout.php">Terminar a sessão</a>
    </div>
    <!-- Default to the left -->
    <strong>Copyright &copy; 2022 <a href="javascript:void(0)">ISAF::IGF - GRUPO 3</a>.</strong> All rights reserved.
  </footer>
</div>
<!-- ./wrapper -->

  <!-- InputMask -->
  <script src="plugins/moment/moment.min.js"></script>
  <script src="plugins/inputmask/jquery.inputmask.min.js"></script>
<script>

$(document).ready( function () {
    $('[data-mask]').inputmask();
    $('.select2bs4').select2({
      theme: 'bootstrap4'
    })

});
</script>
</body>
</html>
