<?php 
include_once('config/DB.php');
$conexao = conectaDB();
    $sql = "SELECT 
        m.*,
        IF(data_fim > NOW(), 1,0) as estado
    FROM 
        promocao m
    ORDER BY
        m.data_inicio DESC
    ";
    $query = mysqli_query($conexao, $sql);
?>
<div class="row">
    <div class="card col-lg-12">
        <div class="card-header">
            <h3 class="card-title">Lista de Promoções</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <div class="text-right">
                <a href="./?page=admin.promocao.novo" class="btn-lg bg-primary"><i class="fa fa-plus"></i></a>
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
                        <th>Titulo</th>
                        <th>Valor</th>
                        <th class="text-right" width="200px">Data Fim</th>
                        <th class="text-center" width="200px">Data Fim</th>
                        <th class="text-center"  width="200px">Acção</th>
                </thead>
                <tbody>
                    <?php 
                     while($promocao = mysqli_fetch_array($query)) {
                    ?>
                    <tr>
                        <td><?php echo $promocao['titulo']; ?></td>
                        <td><?php echo $promocao['valor']; ?></td>
                        <td class="text-right" ><?php echo $promocao['data_inicio']; ?></td>
                        <td class="text-right" ><?php echo $promocao['data_fim']; ?></td>
                        <td class="text-center"><?php  if($promocao['estado']==1) { ?> <span class="right badge badge-success">Activo</span> <?php } else { ?><span class="right badge badge-danger">Expirado</span><?php } ?></td>
                        <td class="text-center">
                            <a href="./?page=admin.promocao.editar&id=<?php echo $promocao['id']; ?>" class="btn-lg bg-primary"><i class="fa fa-edit"></i></a>
                            <a href="./Controlo/promocao.php?metodo=eliminar&id=<?php echo $promocao['id']; ?>" class="btn-lg bg-danger"><i class="fa fa-trash"></i></a>
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