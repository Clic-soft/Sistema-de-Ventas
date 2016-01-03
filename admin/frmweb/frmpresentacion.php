<?php require_once '../clases/clsProducto.php'; ?>
<?php 
    if(isset($_POST['IdPresen'])):
        if(!empty($_POST['IdPresen'])):
            $objPre=new Presentacion();
            $fila=$objPre->get_presentacion_id($_POST['IdPresen']);
        endif;
    endif;
?>
    <div class='modal-dialog'>
        <form method='POST' id="formPre">
            <div class='modal-content'>
                <div class='modal-header'>
                    <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>&times;</button>
                    <h4 class='modal-title' id='myModalLabel'>PRESENTACIÓN</h4>
                </div>
                <div class='modal-body'>
                    <input type='hidden' class='form-control' name="IdPre" value="<?=$_POST['IdPresen']?>">
                    <label for="" class="hidden-xs">Presentación</label>
                    <input type="text" name="presentacion" required placeholder="Presentación" 
                        class="form-control" value="<?=$fila[0]?>">
                </div>
                <div class='modal-footer'>
                    <button type="submit" class="btn btn-success" name="<?= (empty($_POST['IdPresen'])) ? "btnReg":"btnAct";?>">
                        <i class="glyphicon glyphicon-save"></i> Guardar
                    </button>
                    <button type='button' class="btn btn-danger" data-dismiss='modal'>No</button> 
                </div>
            </div><!-- /.modal-content -->
        </form>
    </div><!-- /.modal-dialog -->