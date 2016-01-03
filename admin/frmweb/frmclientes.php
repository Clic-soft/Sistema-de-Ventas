<?php require_once '../clases/clsClientes.php'; ?>
<?php 
    if(isset($_POST['dni'])):
        if(!empty($_POST['dni'])):
            $objCli=new Clientes();
            $item=$objCli->getClienteporId($_POST['dni']);
        endif;
    endif;
?>

    <div class='modal-dialog'>
        <form method='POST' name="formClie">
            <div class='modal-content'>
                <div class='modal-header'>
                    <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>&times;</button>
                    <h4 class='modal-title' id='myModalLabel'>CLIENTES</h4>
                </div>
                <div class='modal-body'>
                    <div class="row">
                        <div class="col-xs-12 col-md-12">
                            <label for="" class="hidden-xs">Tipo Persona</label>
                            <select class='form-control' name="tipo" required>
                                <?php $array = array('Natural','Jurídica'); ?>
                                <option value="">Seleccione</option>
                                <?php foreach ($array as $key =>$value):?>
                                <option value="<?=$value?>" <?php if(isset($item)){ if ($item[1]==$value) echo "selected";}?>><?=$value?></option>
                                <?php endforeach; ?>
                            </select>
                            <label for="" class="hidden-xs">D.N.I. / R.U.C.</label>
                            <input type="text" name="dni" minlength="8" maxlength="11" required placeholder="D.N.I. / R.U.C." 
                                class="form-control" 

                                <?php if(isset($_POST['dni'])){?>
                                    value="<?=rtrim($_POST['dni'])?>" readonly
                                <?php }else{?>
                                    value=""
                                <?php } ?>
                                
                            <label for="">Nombre del cliente</label>
                            <input type='text' class='form-control' required name="nombrecliente" 
                            <?php if(isset($item)){?>
                                value="<?=$item[2]?>"
                            <?php }else{?>
                                value=""
                            <?php } ?> placeholder="Nombre del cliente">
                            <label for="">Dirección</label>
                            <input type='text' class='form-control' required name="direccion" 
                            <?php if(isset($item)){?>
                                value="<?=$item[3]?>"
                            <?php }else{?>
                                value=""
                            <?php } ?> placeholder="Cra 1 # 70-210">
                            <label for="">Teléfono</label>
                            <input type='text' class='form-control' name="telefono" 
                            <?php if(isset($item)){?>
                                value="<?=$item[4]?>"
                            <?php }else{?>
                                value=""
                            <?php } ?> placeholder="300234567">
                            <label for="">E-mail</label>
                            <input type='email' class='form-control' name="email" 
                            <?php if(isset($item)){?>
                                value="<?=$item[5]?>"
                            <?php }else{?>
                                value=""
                            <?php } ?> placeholder="ejemplo@gmail.com">
                        </div>
                    </div>
                </div>
                <div class='modal-footer'>
                    <button type="submit" class="btn btn-success" name="<?= (empty($_POST['dni'])) ? "btnReg":"btnAct";?>">
                        <i class="glyphicon glyphicon-save"></i> Guardar
                    </button>
                    <button type='button' class="btn btn-danger" data-dismiss='modal'>No</button> 
                </div>
            </div><!-- /.modal-content -->
        </form>
    </div><!-- /.modal-dialog -->