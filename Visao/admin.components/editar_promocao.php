<?php 
 include_once('config/DB.php');
 if(!isset($_GET['id']) || intval($_GET['id']) <= 0) {
    $error = true;
 } else {
    $id_promocao = $_GET['id'];
    $conexao = conectaDB();

    $sql_edit = "SELECT 
        m.id,
        m.titulo,
        m.valor,
        DATE_FORMAT(m.data_inicio, '%d/%m/%Y') as data_inicio,
        DATE_FORMAT(m.data_fim, '%d/%m/%Y') as data_fim
    FROM 
        promocao m
    WHERE
        m.id='".$id_promocao."'
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
            <strong>Erro</strong> promocao não encontrado!
            <button type="button" onclick="javascript:location='./?page=admin.promocao'" class="close" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php } else { ?>
    <div class="card card-primary col-lg-12">
        <div class="card-header">
            <h3 class="card-title">Formulário</h3>
            </div>
            <form action="./Controlo/promocao.php?metodo=editar&id=<?php echo $registo['id'];?>" method="POST" enctype="multipart/form-data">
            <div class="card-body">

            <?php if(isset($_GET['error']) && $_GET['error']==1) {?>
                <div class="alert alert-danger" role="alert">
                Por favor, preencha todos os campos
                </div>
            <?php } ?>

            <?php if(isset($_GET['error']) && $_GET['error']==2) {?>
                <div class="alert alert-danger" role="alert">
                Ocorreu um erro ao atualizar o promocao
                </div>
            <?php } ?>

                <div class="form-group">
                    <label>Titulo</label>
                    <input type="text" required class="form-control" name="titulo" value="<?php echo $registo['titulo'];?>" placeholder="Introduza o Codigo">
                </div>
                <div class="form-group">
                    <label>Valor</label>
                    <input type="text" required class="form-control" name="valor" value="<?php echo $registo['valor'];?>" placeholder="Introduza a Descrição">
                </div>
                <div class="form-group">
                  <label>Data Inicio</label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                    </div>
                    <input type="text" required name="data_inicio" class="form-control" value="<?php echo $registo['data_inicio'];?>" data-inputmask-alias="datetime" data-inputmask-inputformat="dd/mm/yyyy" data-mask>
                  </div>
                </div>
                <div class="form-group">
                  <label>Data Fim</label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                    </div>
                    <input type="text" required name="data_fim" class="form-control" value="<?php echo $registo['data_fim'];?>" data-inputmask-alias="datetime" data-inputmask-inputformat="dd/mm/yyyy" data-mask>
                  </div>
                </div>
            </div>
            </div>

            <div class="card-footer text-right">
                <button type="button" onclick="javascript:location='./?page=admin.promocao'" class="btn btn-danger">Cancelar</button>
                <button type="submit" class="btn btn-primary">Atualizar</button>
            </div>
        </form>
    </div>
    <?php } ?>
</div>