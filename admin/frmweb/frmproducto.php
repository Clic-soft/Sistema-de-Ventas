<?php require_once '../clases/clsCategoria.php'; ?>
<?php require_once '../clases/clsProducto.php'; ?>
<?php 
    $objCat=new Categoria();
    $fila=$objCat->get_Categoria();
    $objPre=new Presentacion();
    $Prsent=$objPre->get_Presentacion();
    if(isset($_POST['IdProducto'])):
        if(!empty($_POST['IdProducto'])):
            $objPro=new Producto();
            $item=$objPro->get_productos_id($_POST['IdProducto']);
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
                            <input type='hidden' class='form-control' name="IdProd" value="<?=$_POST['IdProducto']?>">
                            <input type='hidden' class='form-control' name="ruta" value="<?= $item[7];?>">
                            <label for="">Categoría</label>
                            <select name="categoria" required class="form-control"> 
                                <option value="">Seleccione</option>
                                <?php foreach ($fila as $key): ?>
                                <option value="<?=$key[0]?>" <?php if($item[1]==$key[0]) echo 'Selected'; ?>><?=$key[1]?></option>
                                <?php endforeach; ?>
                            </select>
                            <label for="" class="hidden-xs">Producto</label>
                            <input type="text" name="producto" required placeholder="Producto" 
                                class="form-control" value="<?=$item[3]?>">
                            <label for="" class="hidden-xs">Presentación</label>
                            <select name="presentacion" required class="form-control"> 
                                <option value="">Seleccione</option>
                                <?php foreach ($Prsent as $key): ?>
                                <option value="<?=$key[0]?>" <?php if($item[2]==$key[0]) echo 'Selected'; ?>><?=$key[1]?></option>
                                <?php endforeach; ?>
                            </select>
                            <label for="">Unid. Medida</label>
                            <input type='text' class='form-control' name="UnidMedida" value="<?=$item[4]?>" placeholder="Unidad de Medida">
                            <label for="">P. Venta</label>
                            <input type='text' class='form-control' name="PVenta" value="<?=$item[5]?>" placeholder="12.20">
                            <label for="">Stock</label>
                            <input type='text' class='form-control' readonly name="stock" value="<?=$item[6]?>" placeholder="60">
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
                                    <input type="file" name="Imagen" id="Imagen" <?= (empty($_POST['IdProducto'])) ? "required":"";?>>
                                </span>
                            </p>
                            <p>
                                <img id="vistaPrevia" class="img-responsive"
                                    <?= (empty($_POST['IdProducto'])) ? "":"src='uploads/$item[7]'";?>/>
                            </p>
                        </div>
                    </div>
                    
                </div>
                <div class='modal-footer'>
                    <button type="submit" class="btn btn-success" name="<?= (empty($_POST['IdProducto'])) ? "btnReg":"btnAct";?>">
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