<?php 
include_once('config/DB.php');
$conexao = conectaDB();
    $sql = "SELECT 
        m.*
    FROM 
        preco m
    ORDER BY
        m.dia_semana ASC
    ";
    $query = mysqli_query($conexao, $sql);

    $day_of_week = array(
    1 => 'Segunda-Feira',
    2 => 'Terça-Feira',
    3 => 'Quarta-Feira',
    4 => 'Quinta-Feira',
    5 => 'Sexta-Feira',
    6 => 'Sábado',
    7 => 'Domingo'
);

?>
<div class="row">
    <div class="card col-lg-12">
        <div class="card-header">
            <h3 class="card-title">Matriz de Preços</h3>
        </div>
        <!-- /.card-header -->
        <form action="./Controlo/preco.php?metodo=editar" method="POST" enctype="multipart/form-data">
        <div class="card-body">
            <div class="text-right">
                <button type="submit" class="btn btn-primary">Atualizar</button>
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
                <div class="alert alert-danger" role="alert">
                Por favor, preencha todos os campos
                </div>
                <?php } ?>

                <?php if(isset($_GET['error']) && $_GET['error']==2) {?>
                <div class="alert alert-danger" role="alert">
                Ocorreu um erro ao atualizar os dados
                </div>
                <?php } ?>
            <table id="users" class="table table-bordered table-hover dataTable dtr-inline">
                <thead>
                    <tr>
                        <th>Dia da Semana</th>
                        <th>Primeira Hora</th>
                        <th>Segunda Hora</th>
                        <th>Hora Restante</th>
                </thead>
                <tbody>
                    <?php 
                     while($preco = mysqli_fetch_array($query)) {
                    ?>
                    <tr>
                        <td><?php echo $day_of_week[$preco['dia_semana']]; ?></td>
                        <td><input type="text" required class="form-control" name="preco[<?php echo$preco['dia_semana']; ?>][primeira_hora]" value="<?php echo $preco['primeira_hora']; ?>" placeholder="Introduza o Valor"></td>
                        <td><input type="text" required class="form-control" name="preco[<?php echo$preco['dia_semana']; ?>][segunda_hora]" value="<?php echo $preco['segunda_hora']; ?>" placeholder="Introduza o Valor"></td>
                        <td><input type="text" required class="form-control" name="preco[<?php echo$preco['dia_semana']; ?>][restante]" value="<?php echo $preco['restante']; ?>" placeholder="Introduza o Valor"></td>
                    </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
        </form>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->
</div>