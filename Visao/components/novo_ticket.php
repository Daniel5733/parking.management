<?php 
 include_once('config/DB.php');
 $conexao = conectaDB();
    $sql = "SELECT 
        m.id,
        m.nome
    FROM 
        modelo m
    ORDER BY
        m.id_marca ASC
    ";
    $query = mysqli_query($conexao, $sql);

    $sql2 = "SELECT 
        m.id,
        m.codigo,
        m.descricao
    FROM 
        estacionamento m
    WHERE 
        estado = 1 AND
        id NOT IN (SELECT id_estacionamento FROM ticket WHERE data_entrada IS NOT NULL AND data_saida IS NULL) 
    ORDER BY
        m.codigo ASC
    ";
    $query2 = mysqli_query($conexao, $sql2);
    $registo = null;
    if(isset($_GET['id']) && intval($_GET['id']) > 0) {
        $sql_edit = "SELECT 
            *
        FROM 
            veiculo
        WHERE
            id='".$_GET['id']."'
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
    <div class="card card-primary col-lg-12">
        <div class="card-header">
            <h3 class="card-title">Formulário</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form action="./Controlo/ticket.php?metodo=gravar" method="POST" enctype="multipart/form-data">
            <div class="card-body">

                <?php if(isset($_GET['error']) && $_GET['error']==1) {?>
                <div class="alert alert-danger" role="alert">
                Por favor, preencha todos os campos
                </div>
                <?php } ?>

                <?php if(isset($_GET['error']) && $_GET['error']==2) {?>
                <div class="alert alert-danger" role="alert">
                Ocorreu um erro ao criar o Veiculo
                </div>
                <?php } ?>
                <input type="hidden" name="id_veiculo" value="<?php echo $registo['id']; ?>">
                <div class="form-group">
                <label>Modelo do veiculo</label>
                <select required class="form-control select2bs4" name="id_modelo" <?php if((isset($registo['matricula']) && !empty($registo['matricula']))){?> disabled <?php }; ?>>
                    <?php 
                     while($modelo = mysqli_fetch_array($query)) {
                    ?>
                    <option value="<?php echo $modelo['id']; ?>" <?php if(isset($registo['id_modelo']) && $registo['id_modelo'] == $modelo['id']) {?>selected="true"<?php } ?>>
                        <?php echo $modelo['nome']; ?>
                    </option>
                    <?php
                    }
                    ?>
                </select>
                </div>
                <div class="form-group">
                <label>Matricula</label>
                <input type="text" required class="form-control" name="matricula" <?php if((isset($_GET['matricula']) && !empty($_GET['matricula'])) || (isset($registo['matricula']) && !empty($registo['matricula']))){?> readonly <?php }; ?> value="<?php echo $_GET['matricula'] ?? ($registo['matricula'] ?? ''); ?>" placeholder="Introduza a Matricula">
                </div>
                <div class="form-group">
                <label>Cor</label>
                <input type="text" required class="form-control" name="cor" value="<?php echo $registo['cor'] ?? ''; ?>" placeholder="Introduza a Cor" <?php if((isset($registo['matricula']) && !empty($registo['matricula']))){?> readonly <?php }; ?>>
                </div>
                <div class="form-group">
                    <div class="col-md-12">
                        <button class="btn btn-default" type="button" id="start-camera">Ligar Camera</button>
                        <button  class="btn btn-success" type="button" id="click-photo">Capturar Foto</button>
                    </div>
                    <div class="col-md-12">
                        <br />
                        <video id="video" width="320" height="240" autoplay style="display: none;"></video>
                        <canvas id="canvas" width="320" height="240" style="display: none;"></canvas>
                        <input type="hidden" name="foto" id="car-image" />
                    </div>
                </div>
                <div class="form-group">
                  <label>Estacionamento</label>
                  <select name="id_estacionamento" class="form-control select2bs4" style="width: 100%;">
                    <option value="">Selecionar Aleatório</option>
                    <?php 
                    while($estacionamento = mysqli_fetch_array($query2)) {
                    ?>
                    <option value="<?php echo $estacionamento['id']; ?>"><?php echo $estacionamento['codigo']; ?></option>
                    <?php
                    }
                    ?>
                  </select>
                </div>
            </div>
            <!-- /.card-body -->

            <div class="card-footer text-right">
                <button type="button" onclick="javascript:location='./?page=tickets'" class="btn btn-danger">Cancelar</button>
                <button type="submit" class="btn btn-primary">Gravar</button>
            </div>
        </form>
    </div>
</div>
<script>
let camera_button = document.querySelector("#start-camera");
let video = document.querySelector("#video");
let click_button = document.querySelector("#click-photo");
let canvas = document.querySelector("#canvas");
let camera;
camera_button.addEventListener('click', async function() {
    $('#video').show();
   	let stream = await navigator.mediaDevices.getUserMedia({ video: true, audio: false });
	video.srcObject = stream;
    camera = stream;
});

click_button.addEventListener('click', function() {
   	canvas.getContext('2d').drawImage(video, 0, 0, canvas.width, canvas.height);
   	let image_data_url = canvas.toDataURL('image/jpeg');
    $('#car-image').val(image_data_url);
    $('#video').hide();
    $('#canvas').show();
   	// data url of the image
   	console.log(image_data_url);
    camera.getTracks().forEach(function(track) {
        if (track.readyState == 'live' && track.kind === 'video') {
            track.stop();
        }
    });

});
// stop only camera
function stopVideoOnly() {
    stream.getTracks().forEach(function(track) {
        if (track.readyState == 'live' && track.kind === 'video') {
            track.stop();
        }
    });
}
</script>