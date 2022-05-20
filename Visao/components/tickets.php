<?php 
include_once('config/DB.php');
$conexao = conectaDB();
    $sql = "SELECT 
        t.id as id_ticket,
        e.codigo,
        t.montante,
        t.data_entrada,
        CONCAT(m.nome , ' | ',v.matricula) as veiculo,
        IF(v.matricula IS NOT NULL, 1,0) as oucupado
    FROM 
        `estacionamento` e
        LEFT JOIN ticket t ON (t.id_estacionamento = e.id)
        LEFT JOIN veiculo v ON (v.id = t.id_veiculo)
        LEFT JOIN modelo m ON (m.id = v.id_modelo)
    WHERE
        t.data_saida IS NULL AND 
        t.data_entrada IS NOT NULL
    ORDER BY 
        t.data_entrada ASC, 
        t.montante DESC,
        e.codigo ASC
    ";
    $query = mysqli_query($conexao, $sql);
?>
<div class="row">
    <div class="card col-lg-12">
        <div class="card-header">
            <h3 class="card-title">Tickets Abertos</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <div class="text-right">
                <div class="input-group input-group-sm">
                  <input type="text" class="form-control" placeholder="Pesquisar Matricula">
                  <span class="input-group-append">
                    <button type="button" class="btn btn-info btn-flat"><i class="fa fa-plus"> Adicionar</i></button>
                  </span>
                </div>
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
                        <th>Espaço</th>
                        <th>Montante</th>
                        <th>Veiculo</th>
                        <th class="text-right" width="200px">Data Entrada</th>
                        <th class="text-center" width="100px">Acção</th>
                </thead>
                <tbody>
                    <?php 
                     while($ticket = mysqli_fetch_array($query)) {
                    ?>
                    <tr>
                        <td><?php echo $ticket['codigo']; ?></td>
                        <td><?php echo $ticket['montante']; ?></td>
                        <td><?php echo $ticket['veiculo']; ?></td>
                        <td><?php echo $ticket['data_entrada']; ?></td>
                        <td class="text-center">
                            <a href="./?page=ticket.finalizar&id=<?php echo $ticket['id_ticket']; ?>" class="btn-lg bg-danger"><i class="fa fa-check"></i></a>
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