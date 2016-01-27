
<?php require_once '../clases/clsProducto.php'; ?>
<?php 

    $objPro2=new Producto();
    $item2=$objPro2->get_und_medida();

    if(isset($_POST['id'])):
        if(!empty($_POST['id'])):
            $objPro=new Producto();
            $item=$objPro->get_productos_id($_POST['id']);
            
        endif;
    endif;
?>
    <div class='modal-dialog modal-lg'>
        <form method='POST' id="formC" enctype="multipart/form-data">
            <div class='modal-content'>
                <div class='modal-header'>
                    <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>&times;</button>
                    <h4 class='modal-title' id='myModalLabel'>PRODUCTO</h4>
                </div>
                <div class='modal-body'>
                    <div class="row">
                        <div class="col-xs-12 col-md-6">
                            <input type='hidden' class='form-control' name="id" value="<?=$_POST['id']?>">
                            <input type='hidden' class='form-control' name="ruta" value="<?= $item[5];?>">
                            <label for="" class="hidden-xs">PRODUCTO</label>
                            <input type="text" name="producto" required placeholder="Producto" 
                                class="form-control" 
                                <?php if(isset($item)){?>
                                value="<?=$item[2]?>"
                            <?php }else{?>
                                value=""
                            <?php } ?>>
                            <label for="" class="hidden-xs">Unidad Medida</label>
                            <select name="unidad_medida" id="unidad_medida" required class="form-control"> 
                                <option value="">Seleccione</option>
                                <?php foreach ($item2 as $key): ?>
                                <option value="<?=$key[0]?>" <?php if(isset($item)){if($item[4]==$key[0]) echo 'Selected'; }?>><?=$key[1]?></option>
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

                        </div>
                        <div class="col-xs-12 col-md-6"><!--
                            <div class="form-group">
                                <label for="">Fecha Vencimiento</label>
                                <div class='input-group date' id='datetimepicker1'>
                                    <input type='text' name="fecha" class="form-control" required 
                                        readonly data-date-format="DD/MM/YYYY hh:mm:ss A"/>
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                            </div>-->
                            <p>
                                <span class="btn btn-success fileinput-button">
                                    <i class="glyphicon glyphicon-plus"></i> Agregar Imagen
                                    <input type="file" name="Imagen" id="Imagen" <?= (empty($_POST['id'])) ? "required":"";?>>
                                </span>
                            </p>
                            <p>
                                <img id="vistaPrevia" class="img-responsive"
                                    <?= (empty($_POST['id'])) ? "":"src='uploads/$item[5]'";?>/>
                            </p>
                        </div>
                    </div>  
                    
                </div>
                <div class='modal-footer'>
                    <button type="submit" class="btn btn-success" name="<?= (empty($_POST['id'])) ? "btnReg":"btnAct";?>">
                        <i class="glyphicon glyphicon-save"></i> Guardar
                    </button>
                    <button type='button' class="btn btn-danger" data-dismiss='modal'>No</button> 
                </div>
            </div><!-- /.modal-content -->
        </form>
    </div><!-- /.modal-dialog -->

        <script type="text/javascript">
            $(function () {
                $('#datetimepicker1').datetimepicker()
            });
        </script>

<script type="text/javascript">
    jQuery('#Imagen').on('change', function(e) {
        var Lector,
            oFileInput = this;
   
        if(oFileInput.files.length === 0) {
            return;
        };

        Lector = new FileReader();
            Lector.onloadend = function(e) {
            jQuery('#vistaPrevia').attr('src', e.target.result);          
        };
        Lector.readAsDataURL(oFileInput.files[0]);
    });
</script>