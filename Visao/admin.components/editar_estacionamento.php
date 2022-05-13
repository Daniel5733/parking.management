<?php 
 include_once('config/DB.php');
 if(!isset($_GET['id']) || intval($_GET['id']) <= 0) {
    $error = true;
 } else {
    $id_estacionamento = $_GET['id'];
    $conexao = conectaDB();

    $sql_edit = "SELECT 
        m.*
    FROM 
        estacionamento m
    WHERE
        m.id='".$id_estacionamento."'
    ";
    $query_edit = mysqli_query($conexao, $sql_edit);
    if($query_edit->num_rows == 1) {
        $registo = mysqli_fetch_array($query_edit);
    } else {
        $error = true;
    }
 }
?>
<div class="row">
    <?php if(isset($error) && $error==true) {?>
        <div class="col-lg-12 alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Erro</strong> estacionamento não encontrado!
            <button type="button" onclick="javascript:location='./?page=admin.estacionamentos'" class="close" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php } else { ?>
    <div class="card card-primary col-lg-12">
        <div class="card-header">
            <h3 class="card-title">Formulário</h3>
            </div>
            <form action="./Controlo/estacionamento.php?metodo=editar&id=<?php echo $registo['id'];?>" method="POST" enctype="multipart/form-data">
            <div class="card-body">

            <?php if(isset($_GET['error']) && $_GET['error']==1) {?>
                <div class="alert alert-danger" role="alert">
                Por favor, preencha todos os campos
                </div>
            <?php } ?>

            <?php if(isset($_GET['error']) && $_GET['error']==2) {?>
                <div class="alert alert-danger" role="alert">
                Ocorreu um erro ao atualizar o estacionamento
                </div>
            <?php } ?>

                <div class="form-group">
                    <label>Codigo</label>
                    <input type="text" required class="form-control" name="codigo" value="<?php echo $registo['codigo'];?>" placeholder="Introduza o Codigo">
                </div>
                <div class="form-group">
                    <label>Descrição</label>
                    <input type="text" required class="form-control" name="descricao" value="<?php echo $registo['descricao'];?>" placeholder="Introduza a Descrição">
                </div>
                <div class="form-group">
                    <label>Ordem</label>
                    <input type="number" required class="form-control" name="ordem" value="<?php echo $registo['ordem'];?>" placeholder="Introduza a Ordem">
                </div>
                <div class="form-group">
                    <input type="hidden" value="0" name="estado">
                    <div class="icheck-primary d-inline">
                        <input type="checkbox" name="estado" value="1" id="checkboxPrimary1"<?php  if($registo['estado']==1) { ?> checked="true" <?php } ?> >
                        <label for="checkboxPrimary1">
                            Activo?
                        </label>
                    </div>
                </div>
            </div>

            <div class="card-footer text-right">
                <button type="button" onclick="javascript:location='./?page=admin.estacionamentos'" class="btn btn-danger">Cancelar</button>
                <button type="submit" class="btn btn-primary">Atualizar</button>
            </div>
        </form>
    </div>
    <?php } ?>
</div>