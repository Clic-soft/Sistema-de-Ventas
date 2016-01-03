<?php require_once '../clases/clsCategoria.php'; ?>
<?php 
    if(isset($_POST['IdCategoria'])):
        if(!empty($_POST['IdCategoria'])):
            $objCat=new Categoria();
            $fila=$objCat->get_categoria_id($_POST['IdCategoria']);
        endif;
    endif;
?>
    <div class='modal-dialog'>
        <form method='POST' id="formC">
            <div class='modal-content'>
                <div class='modal-header'>
                    <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>&times;</button>
                    <h4 class='modal-title' id='myModalLabel'>CATEGORIA</h4>
                </div>
                <div class='modal-body'>
                    <input type='hidden' class='form-control' name="IdCat" value="<?=$_POST['IdCategoria']?>">
                    <label for="" class="hidden-xs">Categoria</label>
                    <input type="text" name="categoria" required placeholder="Categoria" 
                        class="form-control" 
                        <?php if(isset($fila)){?>
                            value="<?=$fila[0]?>"
                        <?php }else{?>
                            value=""
                        <?php } ?> >
                </div>
                <div class='modal-footer'>
                    <button type="submit" class="btn btn-success" name="<?= (empty($_POST['IdCategoria'])) ? "btnReg":"btnAct";?>">
                        <i class="glyphicon glyphicon-save"></i>Guardar
                    </button>
                    <button type='button' class="btn btn-danger" data-dismiss='modal'>No</button> 
                </div>
            </div><!-- /.modal-content -->
        </form>
    </div><!-- /.modal-dialog -->
