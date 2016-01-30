<?php require_once '../clases/clsVentas.php'; ?>
<?php 

   $objClientes=new Ventas();
    $item2=$objClientes->getClientes();
    $objproductos=new Ventas();
    $item4=$objproductos->getProductos();

    if(isset($_POST['id'])):
        if(!empty($_POST['id'])):
            $objven=new Ventas();
            $item=$objven->get_venta_id($_POST['id']);
            $item3=$objven->get_detalles_ventas($_POST['id']);            
        endif;
    endif;
?>

    <div class='modal-dialog' style="width:90%">
        <div class='modal-content'>
            <form method='POST' id="formC">
            
                <div class='modal-header'>
                    <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>&times;</button>
                    <h4 class='modal-title' id='myModalLabel'>VENTAS</h4>
                </div>
                <div class='modal-body'>
                    <input type='hidden' class='form-control' name="id" value="<?=$_POST['id']?>">
                    <label for="" class="hidden-xs">CLIENTE</label>
                    <select name="id_cliente" id="id_cliente" required class="form-control"> 
                        <option value="">Seleccione</option>
                        <?php foreach ($item2 as $key): ?>
                        <option value="<?=$key[0]?>" <?php if(isset($item)){if($item[3]==$key[0]) echo 'Selected'; }?>><?=$key[4]?></option>
                        <?php endforeach; ?>
                    </select>
                    <label for="" class="hidden-xs">FORMA DE PAGO</label>
                    <select name="forma_pago" id="forma_pago" required <?php if(isset($item)){echo 'disabled'; }?> class="form-control"> 
                        <option value="">Seleccione</option>
                        <option value="1" <?php if(isset($item)){if($item[5]==1) echo 'Selected'; }?>>Efectivo</option>
                        <option value="2" <?php if(isset($item)){if($item[5]==2) echo 'Selected'; }?>>Credito</option>
                    </select>
                </div>
                <div class='modal-footer'>
                    <button type="submit" class="btn btn-success" name="<?= (empty($_POST['id'])) ? "btnRegve":"btnActve";?>">
                        <i class="glyphicon glyphicon-save"></i>Guardar
                    </button>
                    <button type='button' class="btn btn-danger" data-dismiss='modal'>No</button> 
                </div>
            
            </form>


    
            <?php if(isset($item)){ ?>

                
                <div class="content-form">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <br>
                        <div class="form-group">
                            <input type="hidden" name="id" id="id" value="<?=$_POST['id']?>">
                            <label for="" class="control-label col-xs-1">PRODUCTO</label>
                            <div class="col-xs-2">
                                <select name="producton" id="producton" required class="form-control"> 
                                    <option value="">Seleccione</option>
                                    <?php foreach ($item4 as $key): ?>
                                    <option value="<?=$key[0]?>"><?=$key[2]?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <label for="" class="control-label col-xs-1">P. Venta</label>
                            <div class="col-xs-2">
                                    <input type='text' class='form-control' id="precion" name="precion" value="" placeholder="1200">
                            </div>

                            <label for="" class="control-label col-xs-1">Cantidad</label>
                            <div class="col-xs-2">
                                <input type="text" id="cantidad" class="form-control" placeholder="20">
                            </div>

                            <div class="col-xs-2">
                                <button type="submit" class="btn btn-success" name="additem";?>">
                                    <i class="glyphicon glyphicon-save"></i>AgregarItem
                                </button>
                            </div>
                        </div>
                    </div>

                    <br>
                <div class='content-form'>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <table class='table  table-bordered table-hover table-condensed' id="Tabla-Categoria">
                                        <thead class="alert alert-info text-head">
                                            <tr>
                                                <th class="text-center">PRODUCTO</th>
                                                <th class="text-center">VR. UNITARIO</th>
                                                <th class="text-center">CANTIDAD</th>
                                                <th class="text-center">TOTAL</th>
                                                <th class="text-center">OPCIONES</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php if(!empty($item3)):?>
                                            <?php foreach ($item3 as $item3):?>
                                            <tr>
                                                <td class="text-center"><?=$item3[6]." (".$item3[7].")"?></td>
                                                <td class="text-center"><?=$item3[3]?></td>
                                                <td class="text-center"><?=$item3[4]?></td>
                                                <td class="text-center"><?=$item3[5]?></td>
                                                <td>
                                                    <center>
                                                        <span title="Editar Detalle" class="btn btn-xs btn-success" 
                                                            onclick="FormCabezaVenta('<?=$item3[0]?>');" data-toggle='modal' 
                                                            data-target='#Modal_Mante_Venta' id="tooltip<?=$item3[0]?>" data-toggle="tooltip"
                                                            data-placement="top">
                                                            <i class="glyphicon glyphicon-edit"></i>
                                                        </span>

                                                        <span title="Eliminar Detalle" class="btn btn-xs btn-danger" 
                                                            onclick="Formadditems('<?=$item3[0]?>');" data-toggle='modal' 
                                                            data-target='#Modal_Mante_Venta' id="tooltip<?=$item3[0]?>" data-toggle="tooltip"
                                                            data-placement="top">
                                                            <i class="glyphicon glyphicon-trash"></i>
                                                        </span>
                                                    </center>
                                                </td>
                                            </tr>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->