<?php require_once '../clases/clsProveedor.php'; 
    $objPro=new Proveedores();
    $fila=$objPro->get_Proveedores();
?>
    <div class='modal-dialog modal-lg'>
        <form method='POST' name="formProv">
            <div class='modal-content'>
                <div class='modal-header'>
                    <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>&times;</button>
                    <h4 class='modal-title' id='myModalLabel'>LISTADO DE PROVEEDORES</h4>
                </div>
                <div class='modal-body'>
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <table class='table  table-bordered table-hover table-condensed' id="Tabla-Categoria">
                                <thead class="alert alert-info thead">
                                    <tr>
                                        <th class="text-center">R.U.C.</th>
                                        <th>Razón Social</th>
                                        <th>Dirección</th>
                                        <th class="text-center">Estado</th>
                                        <th>Teléfono</th>
                                    </tr>
                                </thead>
                                <tbody class="text-body">
                                    <?php foreach ($fila as $item):?>
                                    <tr>
                                        <td class="text-center"><?=$item[0]?></td>
                                        <td><?=$item[1]?></td>
                                        <td><?=$item[2]?></td>
                                        <td class="text-center">
                                            <span class="<?= ($item[5]=='Activo') ? "label label-success":"label label-danger";?>" 
                                                style="cursor:pointer;font-size:13px; font-weight:normal"><?= $item['Estado']?>
                                            </span>
                                        </td>
                                        <td>
                                            <center>
                                                <span title="Agregar Proveedor" class="btn btn-xs btn-info" 
                                                    onclick="AgregarProv('<?=$item[0]?>','<?=$item[1]?>','<?=$item[2]?>');" data-toggle='modal' 
                                                    data-target='#Modal_Mante_Categoria'>
                                                    <i class="glyphicon glyphicon-download-alt"></i> Agregar
                                                </span>
                                            </center>
                                        </td>
                                    </tr>
                                    <?php
                                        endforeach; 
                                    ?>
                                    
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class='modal-footer'>
                    <button type='button' class="btn btn-danger" data-dismiss='modal'>Cerrar</button> 
                </div>
            </div><!-- /.modal-content -->
        </form>
    </div><!-- /.modal-dialog -->

<script type="text/javascript" src="js/dataTables-scrept-Jquery.js"></script>