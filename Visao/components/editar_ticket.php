<?php 
 include_once('config/DB.php');
 if(!isset($_GET['id']) || intval($_GET['id']) <= 0) {
    $error = true;
 } else {
    $id_ticket = $_GET['id'];
    $conexao = conectaDB();
    $sql = "SELECT 
        p.id,
        p.nome
    FROM 
        marca p
    ORDER BY
        p.nome ASC
    ";
    $query = mysqli_query($conexao, $sql);

    $sql_edit = "SELECT 
        u.*
    FROM 
        ticket u
    WHERE
        id='".$id_ticket."'
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
            <strong>Erro</strong> Ticket não encontrado!
            <button type="button" onclick="javascript:location='./?page=admin.tickets'" class="close" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php } else { ?>
    <div class="card card-primary col-lg-12">
        <div class="card-header">
            <h3 class="card-title">Formulário</h3>
            </div>
            <form action="./Controlo/ticket.php?metodo=editar&id=<?php echo $registo['id'];?>" method="POST" enctype="multipart/form-data">
            <div class="card-body">

            <?php if(isset($_GET['error']) && $_GET['error']==1) {?>
                <div class="alert alert-danger" role="alert">
                Por favor, preencha todos os campos
                </div>
            <?php } ?>

            <?php if(isset($_GET['error']) && $_GET['error']==2) {?>
                <div class="alert alert-danger" role="alert">
                Ocorreu um erro ao atualizar o ticket
                </div>
            <?php } ?>

                <div class="form-group">
                <label>Marca</label>
                <select required class="form-control" name="id_marca">
                    <?php 
                     while($marca = mysqli_fetch_array($query)) {
                    ?>
                    <option value="<?php echo $marca['id']; ?>" <?php if($registo['id_marca'] == $marca['id']) {?>selected="true"<?php } ?>>
                        <?php echo $marca['nome']; ?>
                    </option>
                    <?php
                    }
                    ?>
                </select>
                </div>
                <div class="form-group">
                <label>Nome</label>
                <input type="text" required class="form-control" name="nome" value="<?php echo $registo['nome'];?>" placeholder="Introduza o Seu Nome">
                </div>
            </div>

            <div class="card-footer text-right">
                <button type="button" onclick="javascript:location='./?page=admin.tickets'" class="btn btn-danger">Cancelar</button>
                <button type="submit" class="btn btn-primary">Atualizar</button>
            </div>
        </form>
    </div>
    <?php } ?>
</div>