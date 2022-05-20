<!-- Sidebar Menu -->
<nav class="mt-2">
<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
    <li class="nav-item">
    <a href="?page=dashboard" class="nav-link">
        <i class="nav-icon fas fa-tachometer-alt"></i>
        <p>
        Dashboard
        </p>
    </a>
    </li>
    
    <li class="nav-item">
    <a href="?page=tickets" class="nav-link">
        <i class="nav-icon fas fa-clipboard-list"></i>
        <p>
        Tickets
        </p>
    </a>
    </li>
    <li class="nav-item">
    <a href="?page=estacionamentos" class="nav-link">
        <i class="nav-icon fas fa-th"></i>
        <p>
        Espaços
        </p>
    </a>
    </li>
    <?php if($_SESSION['usuario']['id_perfil']==1) {?>
    <li class="nav-item">
    <a href="#" class="nav-link">
        <i class="nav-icon fas fa-chart-pie"></i>
        <p>
        Gestão
        </p>
    </a>
    <ul class="nav nav-treeview" style="display: block;">
        <li class="nav-item">
        <a href="?page=admin.usuarios" class="nav-link">
            <i class="fas fa-angle-right nav-icon"></i>
            <p>Utilizadores</p>
        </a>
        </li>
        <li class="nav-item">
        <a href="?page=admin.tickets" class="nav-link">
            <i class="fas fa-angle-right nav-icon"></i>
            <p>
            Historico de Tickets
            </p>
        </a>
        </li>
        <li class="nav-item">
        <a href="?page=admin.estacionamentos" class="nav-link">
            <i class="fas fa-angle-right nav-icon"></i>
            <p>Estacionamentos</p>
        </a>
        </li>
        <li class="nav-item">
        <a href="?page=admin.marcas" class="nav-link">
            <i class="fas fa-angle-right nav-icon"></i>
            <p>Marcas</p>
        </a>
        </li>
        <li class="nav-item">
        <a href="?page=admin.modelos" class="nav-link">
            <i class="fas fa-angle-right nav-icon"></i>
            <p>Modelos</p>
        </a>
        </li>
        <li class="nav-item">
        <a href="?page=admin.preco" class="nav-link">
            <i class="fas fa-angle-right nav-icon"></i>
            <p>Tabela de Preços</p>
        </a>
        </li>
        <li class="nav-item">
        <a href="?page=admin.promocao" class="nav-link">
            <i class="fas fa-angle-right nav-icon"></i>
            <p>Promoções</p>
        </a>
        </li>
    </ul>
    </li>
<?php } ?>
</ul>
</nav>
<!-- /.sidebar-menu -->