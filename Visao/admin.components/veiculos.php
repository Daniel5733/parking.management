<?php 
include_once('config/DB.php');
$conexao = conectaDB();
    $sql = "SELECT 
        m.nome as modelo,
        v.matricula,
        v.cor,
        v.data_criacao,
        SUM(t.montante) as faturacao,
        v.foto
    FROM 
        veiculo v
        LEFT JOIN modelo m ON (m.id = v.id_modelo)
        LEFT JOIN ticket t On (t.id_veiculo = v.id)
    GROUP BY
        v.id
    ORDER BY 
        v.data_criacao DESC
    ";
    $query = mysqli_query($conexao, $sql);
?>
<div class="row">
    <div class="card col-lg-12">
        <div class="card-header">
            <h3 class="card-title">Veículos Registados</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <table id="users" class="table table-bordered table-hover dataTable dtr-inline list-table">
                <thead>
                    <th>Modelo</th>
                    <th>Matrícula</th>
                    <th>Cor</th>
                    <th>Total Faturação</th>
                    <th>Foto</th>
                    <th class="text-right" width="200px">Data</th>
                </thead>
                <tbody>
                    <?php 
                     while($veiculo = mysqli_fetch_array($query)) {
                    ?>
                    <tr>
                        <td><?php echo $veiculo['modelo']; ?></td>
                        <td><?php echo $veiculo['matricula']; ?></td>
                        <td><?php echo $veiculo['cor']; ?></td>
                        <td><?php echo $veiculo['faturacao']; ?></td>
                        <td><img width="150" src="<?php echo $veiculo['foto']; ?>"></td>
                        <td><?php echo $veiculo['data_criacao']; ?></td>
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