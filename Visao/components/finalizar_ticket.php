<?php 
include_once('config/DB.php');
atualizarPecoTickets();
$conexao = conectaDB();
$registo = null;
if(isset($_GET['id']) && intval($_GET['id']) > 0) {
    $sql = "SELECT 
        t.montante,
        t.id as id_ticket,
        e.codigo,
        v.matricula,
        v.cor,
        (SELECT SUM(`valor`) as value FROM `promocao` WHERE DATE(`data_inicio`) <= NOW() AND DATE(`data_fim`) >= NOW()) as desconto
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
        //verificarPromoção
    }
}
?>
<div class="row">
    <div class="card card-primary col-lg-12">
        <div class="card-header">
            <h3 class="card-title">Informações</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form action="./Controlo/ticket.php?metodo=finalizar" method="POST" enctype="multipart/form-data">
            <div class="card-body">

                <?php if(isset($_GET['error']) && $_GET['error']==1) {?>
                <div class="alert alert-danger" role="alert">
                 O ticket deve estar pago antes de ser fechado!
                </div>
                <?php } ?>

                <?php if(isset($_GET['error']) && $_GET['error']==2) {?>
                <div class="alert alert-danger" role="alert">
                Ocorreu um erro ao criar o Veiculo.
                </div>
                <?php } ?>
                <div class="form-group">
                    <label>Nº Ticket</label>
                    <input type="text" required class="form-control" name="id" readonly value="<?php echo $registo['id_ticket'] ?? ''; ?>">
                </div>
                <div class="form-group">
                    <label>Matricula</label>
                    <input type="text" class="form-control" value="<?php echo $registo['matricula'] ?? '';?>" readonly>
                </div>
                <div class="form-group">
                    <label>Cor</label>
                    <input type="text" class="form-control" value="<?php echo $registo['cor'] ?? ''; ?>"  readonly>
                </div>
                <div class="form-group">
                    <label>Estacionamento</label>
                    <input type="text" class="form-control" value="<?php echo $registo['codigo'] ?? ''; ?>"  readonly>
                </div>
                <div class="form-group">
                    <label>Custo <?php if(!empty($registo['desconto'])){ echo '(Desconto de '.$registo['desconto'].' % Incluído)' ?? ''; } ?></label>
                    <input type="text" class="form-control" name="montante" value="<?php echo $registo['montante'] ?? ''; ?>"  readonly>
                </div>
                <div class="form-group">
                    <input type="hidden" value="0" name="pago">
                    <div class="icheck-primary d-inline">
                        <input type="checkbox" value="1" name="pago" id="checkboxPrimary1" >
                        <label for="checkboxPrimary1">
                            Pago?
                        </label>
                    </div>
                </div>
            </div>
            <!-- /.card-body -->

            <div class="card-footer text-right">
                <button type="button" onclick="javascript:location='./?page=tickets'" class="btn btn-danger">Cancelar</button>
                <button type="submit" class="btn btn-primary">Finalizar</button>
            </div>
        </form>
    </div>
</div>