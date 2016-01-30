
<?php require_once '../clases/clsVentas.php'; ?>
<?php 
$objPro=new Ventas();
$item2=$objPro->getProductos();

if(isset($_POST['id'])):
        if(!empty($_POST['id'])):
            $objPro=new Ventas();
            $item=$objPro->get_detalle($_POST['id']);
            
        endif;
    endif;

?>
    <div class='modal-dialog modal-lg'>
        <form method='POST' id="formC" enctype="multipart/form-data">
            <div class='modal-content'>
                <div class='modal-header'>
                    <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>&times;</button>
                    <h4 class='modal-title' id='myModalLabel'>AGREGAR ITEM</h4>
                </div>
                <div class='modal-body'>
                    <div class="row">
                        <div class="col-xs-12">
                            <input type='hidden' class='form-control' name="id" value="<?=$_POST['id']?>">
                            <input type='hidden' class='form-control' name="idventa" value="<?= $_POST['idenc'];?>">
                            <label for="" class="hidden-xs">PRODUCTO</label>
                            <select name="unidad_medida" id="unidad_medida" required class="form-control"> 
                                <option value="">Seleccione</option>
                                <?php foreach ($item2 as $key): ?>
                                <option value="<?=$key[0]?>" <?php if(isset($item)){if($item[2]==$key[0]) echo 'Selected'; }?>><?=$key[2]?></option>
                                <?php endforeach; ?>
                            </select>

                            <label for="">P. Venta</label>
                            <input type='text' class='form-control' name="precio" 
                                <?php if(isset($item)){?>
                                value="<?=$item[3]?>"
                            <?php }else{?>
                                value=""
                            <?php } ?>
                            placeholder="1200">

                            <label for="">Cantidad</label>
                            <input type='text' class='form-control' name="cantidad" 
                                <?php if(isset($item)){?>
                                value="<?=$item[4]?>"
                            <?php }else{?>
                                value=""
                            <?php } ?>
                            placeholder="20">

                        </div>
                    </div>  
                    
                </div>
                <div class='modal-footer'>
                    <button type="submit" class="btn btn-success" name="<?= (empty($_POST['id'])) ? "btnRegdet":"btnActdet";?>">
                        <i class="glyphicon glyphicon-save"></i> Guardar
                    </button>
                    <button type='button' class="btn btn-danger" data-dismiss='modal'>No</button> 
                </div>
            </div><!-- /.modal-content -->
        </form>
    </div><!-- /.modal-dialog -->