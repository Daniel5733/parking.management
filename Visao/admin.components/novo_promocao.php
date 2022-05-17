<div class="row">
    <div class="card card-primary col-lg-12">
        <div class="card-header">
            <h3 class="card-title">Formulário</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form action="./Controlo/promocao.php?metodo=gravar" method="POST" enctype="multipart/form-data">
            <div class="card-body">

                <?php if(isset($_GET['error']) && $_GET['error']==1) {?>
                <div class="alert alert-danger" role="alert">
                Por favor, preencha todos os campos
                </div>
                <?php } ?>

                <?php if(isset($_GET['error']) && $_GET['error']==2) {?>
                <div class="alert alert-danger" role="alert">
                Ocorreu um erro ao criar o promocao
                </div>
                <?php } ?>
                <div class="form-group">
                    <label>Titulo</label>
                    <input type="text" required name="titulo" class="form-control" placeholder="Introduza o Titulo">
                </div>
                <div class="form-group">
                  <label>Valor</label>
                    <div class="input-group">
                        <input type="text" required name="valor" class="form-control"  placeholder="Introduza a Percentagem de Desconto">
                        <div class="input-group-append">
                            <div class="input-group-text">%</i></div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                  <label>Data Inicio</label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                    </div>
                    <input type="text" required name="data_inicio" class="form-control" data-inputmask-alias="datetime" data-inputmask-inputformat="dd/mm/yyyy" data-mask>
                  </div>
                </div>
                <div class="form-group">
                  <label>Data Fim</label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                    </div>
                    <input type="text" required name="data_fim" class="form-control" data-inputmask-alias="datetime" data-inputmask-inputformat="dd/mm/yyyy" data-mask>
                  </div>
                </div>
            </div>
            <!-- /.card-body -->

            <div class="card-footer text-right">
                <button type="button" onclick="javascript:location='./?page=admin.promocao'" class="btn btn-danger">Cancelar</button>
                <button type="submit" class="btn btn-primary">Gravar</button>
            </div>
        </form>
    </div>
</div>