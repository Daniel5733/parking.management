<?php 
include_once('config/DB.php');
$conexao = conectaDB();
    $sql = "SELECT 
        u.*,
        p.nome as perfil
    FROM 
        usuario u,
        perfil p
    WHERE 
        u.id_perfil = p.id AND
        u.id != ".$_SESSION['usuario']['id']."
    ORDER BY
        u.nome ASC
    ";
    $query = mysqli_query($conexao, $sql);
?>
<div class="row">
    <div class="card col-lg-12">
        <div class="card-header">
            <h3 class="card-title">Lista de Utilizadores</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <div class="text-right">
                <a href="./?page=admin.usuario.novo" class="btn-lg bg-primary"><i class="fa fa-plus"></i></a>
                <br/>
                <br/>
            </div>

            <?php if(isset($_GET['info']) && $_GET['info']==1) {?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Sucesso:</strong> Operação completada com sucesso!
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <?php } ?>

                <?php if(isset($_GET['error']) && $_GET['error']==1) {?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Erro:</strong> Ocorreu um erro ao finalizar a operação!
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <?php } ?>

            <table id="users" class="table table-bordered table-hover dataTable dtr-inline list-table">
                <thead>
                    <th>Perfil</th>
                    <th>Nome</th>
                    <th>Email</th>
                    <th class="text-center"  width="200px">Acção</th>
                </thead>
                <tbody>
                    <?php 
                     while($usuario = mysqli_fetch_array($query)) {
                    ?>
                    <tr>
                        <td><?php echo $usuario['perfil']; ?></td>
                        <td><?php echo $usuario['nome']; ?></td>
                        <td><?php echo $usuario['email']; ?></td>
                        <td class="text-center">
                            <a href="./?page=admin.usuario.editar&id=<?php echo $usuario['id']; ?>" class="btn-lg bg-primary"><i class="fa fa-edit"></i></a>
                            <a href="./Controlo/usuario.php?metodo=eliminar&id=<?php echo $usuario['id']; ?>" class="btn-lg bg-danger"><i class="fa fa-trash"></i></a>
                        </td>
                    </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->
</div>