<?php 
include_once('config/DB.php');
atualizarPecoTickets();
$conexao = conectaDB();
    $sql = "SELECT 
        e.codigo,
        IF(t.data_entrada IS NOT NULL AND t.data_saida IS NULL, t.montante,0) as montante,
        IF(t.data_entrada IS NOT NULL AND t.data_saida IS NULL, CONCAT(m.nome , ' | ',v.matricula), 'Livre') as veiculo,
        e.estado,
        IF(t.data_entrada IS NOT NULL AND t.data_saida IS NULL, 1,0) as oucupado
    FROM 
        `estacionamento` e
        LEFT JOIN ticket t ON (t.id_estacionamento = e.id)
        LEFT JOIN veiculo v ON (v.id = t.id_veiculo)
        LEFT JOIN modelo m ON (m.id = v.id_modelo)
    ORDER BY 
        oucupado DESC, 
        e.estado DESC, 
        t.montante DESC,
        e.codigo ASC
    ";
    $query = mysqli_query($conexao, $sql);
?>
<div class="row">
<?php 
    while($estacionamento = mysqli_fetch_array($query)) {
?>
<div class="col-md-2 col-sm-6 col-12">
    <div class="info-box <?php if($estacionamento['estado']== 1) { if($estacionamento['oucupado'] == 1) { echo 'bg-gradient-warning'; } else { echo 'bg-gradient-success'; } } else { echo 'bg-gradient-danger'; } ?>">
        <div class="info-box-content">
        <span class="info-box-text"><?php echo ($estacionamento['montante'] ?? '0.00'); ?></span>
        <span class="info-box-number"><?php echo $estacionamento['codigo']; ?></span>
        <div class="progress">
            <div class="progress-bar" style="width: 100%"></div>
        </div>
        <span class="progress-description">
            <?php if($estacionamento['estado']== 0) { echo 'Em Manutenção'; } else { echo ($estacionamento['veiculo'] ?? 'Livre'); } ?>
        </span>
        </div>
        <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
</div>
<?php
}
?>
</div>