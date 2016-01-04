<?php require_once '../clases/clsProveedor.php'; ?>
<?php 
    if(isset($_POST['ruc'])):
        if(!empty($_POST['ruc'])):
            $objPro=new Proveedores();
            $item=$objPro->get_proveedores_ruc($_POST['ruc']);
        endif;
    endif;
?>
    <div class='modal-dialog'>
        <form method='POST' name="formProv">
            <div class='modal-content'>
                <div class='modal-header'>
                    <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>&times;</button>
                    <h4 class='modal-title' id='myModalLabel'>PROVEEDORES</h4>
                </div>
                <div class='modal-body'>
                    <div class="row">
                        <div class="col-xs-12 col-md-12">
                            <label for="" class="hidden-xs">R.U.C.</label>
                            <input type="text" name="ruc" minlength="11" maxlength="11" required placeholder="R.U.C." 
                                class="form-control" 
                                <?php if(isset($_POST['ruc'])){?>
                                    value="<?=rtrim($_POST['ruc'])?>" readonly
                                <?php }else{?>
                                    value=""
                                <?php } ?>>
                            <label for="">Razón Social</label>
                            <input type='text' class='form-control' required name="rasonsocial" 
                            <?php if(isset($item)){?>
                                value="<?=$item[1]?>"
                            <?php }else{?>
                                value=""
                            <?php } ?> placeholder="Razón Social">
                            <label for="">Dirección</label>
                            <input type='text' class='form-control' required name="direccion" <?php if(isset($item)){?>
                                value="<?=$item[2]?>"
                            <?php }else{?>
                                value=""
                            <?php } ?> placeholder="Av. Pachacutec N° 1234, Urb. Santa Rosa - La Victoria Chiclayo">
                            <label for="">Teléfono</label>
                            <input type='text' class='form-control' name="telefono" <?php if(isset($item)){?>
                                value="<?=$item[3]?>"
                            <?php }else{?>
                                value=""
                            <?php } ?> placeholder="234567">
                            <label for="">E-mail</label>
                            <input type='email' class='form-control' name="email" <?php if(isset($item)){?>
                                value="<?=$item[4]?>"
                            <?php }else{?>
                                value=""
                            <?php } ?> placeholder="ejemplo@gmail.com">
                        </div>
                    </div>
                </div>
                <div class='modal-footer'>
                    <button type="submit" class="btn btn-success" name="<?= (empty($_POST['ruc'])) ? "btnReg":"btnAct";?>">
                        <i class="glyphicon glyphicon-save"></i> Guardar
                    </button>
                    <button type='button' class="btn btn-danger" data-dismiss='modal'>No</button> 
                </div>
            </div><!-- /.modal-content -->
        </form>
    </div><!-- /.modal-dialog -->