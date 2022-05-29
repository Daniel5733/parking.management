<?php 
include_once('config/DB.php');
atualizarPecoTickets();
$conexao = conectaDB();
    $sql = "SELECT 
        t.id as id_ticket,
        e.codigo,
        t.montante,
        t.data_entrada,
        t.data_saida,
        CONCAT(m.nome , ' | ',v.matricula) as veiculo,
        IF(v.matricula IS NOT NULL, 1,0) as oucupado,
        t.foto
    FROM 
        `ticket` t
        LEFT JOIN estacionamento e ON (t.id_estacionamento = e.id)
        LEFT JOIN veiculo v ON (v.id = t.id_veiculo)
        LEFT JOIN modelo m ON (m.id = v.id_modelo)
    ORDER BY 
        t.data_saida ASC, 
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
            <table id="users" class="table table-bordered table-hover dataTable dtr-inline list-table">
                <thead>
                    <th>Espaço</th>
                    <th>Montante</th>
                    <th>Veiculo</th>
                    <th>Foto</th>
                    <th class="text-right" width="200px">Data Entrada</th>
                    <th class="text-right" width="200px">Data Saída</th>
                </thead>
                <tbody>
                    <?php 
                     while($ticket = mysqli_fetch_array($query)) {
                    ?>
                    <tr>
                        <td><?php echo $ticket['codigo']; ?></td>
                        <td><?php echo $ticket['montante']; ?></td>
                        <td><?php echo $ticket['veiculo']; ?></td>
                        <td><img width="150" src="<?php echo $ticket['foto']; ?>"></td>
                        <td><?php echo $ticket['data_entrada']; ?></td>
                        <td><?php echo $ticket['data_saida']; ?></td>
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