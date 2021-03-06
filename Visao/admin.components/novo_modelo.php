<?php 
 include_once('config/DB.php');
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
?>
<div class="row">
    <div class="card card-primary col-lg-12">
        <div class="card-header">
            <h3 class="card-title">Formulário</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form action="./Controlo/modelo.php?metodo=gravar" method="POST" enctype="multipart/form-data">
            <div class="card-body">

                <?php if(isset($_GET['error']) && $_GET['error']==1) {?>
                <div class="alert alert-danger" role="alert">
                Por favor, preencha todos os campos
                </div>
                <?php } ?>

                <?php if(isset($_GET['error']) && $_GET['error']==2) {?>
                <div class="alert alert-danger" role="alert">
                Ocorreu um erro ao criar o modelo
                </div>
                <?php } ?>

                <div class="form-group">
                <label>Marca</label>
                <select required class="form-control" name="id_marca">
                    <?php 
                     while($marca = mysqli_fetch_array($query)) {
                    ?>
                    <option value="<?php echo $marca['id']; ?>"><?php echo $marca['nome']; ?></option>
                    <?php
                    }
                    ?>
                </select>
                </div>
                <div class="form-group">
                <label>Nome</label>
                <input type="text" required class="form-control" name="nome" placeholder="Introduza o Nome">
                </div>
            </div>
            <!-- /.card-body -->

            <div class="card-footer text-right">
                <button type="button" onclick="javascript:location='./?page=admin.modelos'" class="btn btn-danger">Cancelar</button>
                <button type="submit" class="btn btn-primary">Gravar</button>
            </div>
        </form>
    </div>
</div>