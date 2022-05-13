<?php 
include_once('config/DB.php');
$conexao = conectaDB();
    $sql = "SELECT 
        u.*,
        p.nome as marca
    FROM 
        modelo u,
        marca p
    WHERE 
        u.id_marca = p.id
    ORDER BY
        p.nome ASC
    ";
    $query = mysqli_query($conexao, $sql);
?>
<div class="row">
    <div class="card col-lg-12">
        <div class="card-header">
            <h3 class="card-title">Lista de Modelos</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <div class="text-right">
                <a href="./?page=admin.modelo.novo" class="btn-lg bg-primary"><i class="fa fa-plus"></i></a>
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
                    <strong>Erro:</strong> Operação não realizada!
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <?php } ?>

            <table id="users" class="table table-bordered table-hover dataTable dtr-inline">
                <thead>
                    <tr>
                        <th>Marca</th>
                        <th>Nome</th>
                        <th class="text-center"  width="200px">Acção</th>
                </thead>
                <tbody>
                    <?php 
                     while($modelo = mysqli_fetch_array($query)) {
                    ?>
                    <tr>
                        <td><?php echo $modelo['marca']; ?></td>
                        <td><?php echo $modelo['nome']; ?></td>
                        <td class="text-center">
                            <a href="./?page=admin.modelo.editar&id=<?php echo $modelo['id']; ?>" class="btn-lg bg-primary"><i class="fa fa-edit"></i></a>
                            <a href="./Controlo/modelo.php?metodo=eliminar&id=<?php echo $modelo['id']; ?>" class="btn-lg bg-danger"><i class="fa fa-trash"></i></a>
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