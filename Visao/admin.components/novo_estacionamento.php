<div class="row">
    <div class="card card-primary col-lg-12">
        <div class="card-header">
            <h3 class="card-title">Formulário</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form action="./Controlo/estacionamento.php?metodo=gravar" method="POST" enctype="multipart/form-data">
            <div class="card-body">

                <?php if(isset($_GET['error']) && $_GET['error']==1) {?>
                <div class="alert alert-danger" role="alert">
                Por favor, preencha todos os campos
                </div>
                <?php } ?>

                <?php if(isset($_GET['error']) && $_GET['error']==2) {?>
                <div class="alert alert-danger" role="alert">
                Ocorreu um erro ao criar o estacionamento
                </div>
                <?php } ?>
                <div class="form-group">
                    <label>Codigo</label>
                    <input type="text" required class="form-control" name="codigo" placeholder="Introduza o codigo">
                </div>
                <div class="form-group">
                    <label>Descrição</label>
                    <input type="text" required class="form-control" name="descricao" placeholder="Introduza a Descrição">
                </div>
                <div class="form-group">
                    <label>Ordem</label>
                    <input type="number" required class="form-control" name="ordem" placeholder="Introduza a Ordem">
                </div>
                <div class="form-group">
                    <input type="hidden" value="0" name="estado">
                    <div class="icheck-primary d-inline">
                        <input type="checkbox" value="1" name="estado" id="checkboxPrimary1" >
                        <label for="checkboxPrimary1">
                            Activo?
                        </label>
                    </div>
                </div>
            </div>
            <!-- /.card-body -->

            <div class="card-footer text-right">
                <button type="button" onclick="javascript:location='./?page=admin.estacionamentos'" class="btn btn-danger">Cancelar</button>
                <button type="submit" class="btn btn-primary">Gravar</button>
            </div>
        </form>
    </div>
</div>