<?php require_once '../clases/clsClientes.php'; 
    $objCli=new Clientes();
    $fila=$objCli->getClientes();
?>
    <div class='modal-dialog modal-lg'>
        <form method='POST' name="formProv">
            <div class='modal-content'>
                <div class='modal-header'>
                    <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>&times;</button>
                    <h4 class='modal-title' id='myModalLabel'>LISTADO DE CLIENTES</h4>
                </div>
                <div class='modal-body'>
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <table class='table  table-bordered table-hover table-condensed' id="Tabla-Categoria">
                                <thead class="alert alert-info thead">
                                    <tr>
                                        <th class="text-center">D.N.I. / R.U.C.</th>
                                        <th>Nombre Cliente</th>
                                        <th>Tipo</th>
                                        <th class="text-center">Dirección</th>
                                        <th>Opciones</th>
                                    </tr>
                                </thead>
                                <tbody class="text-body">
                                    <?php foreach ($fila as $item):?>
                                    <tr>
                                        <td class="text-center"><?=$item[0]?></td>
                                        <td><?=$item[2]?></td>
                                        <td><?=$item[1]?></td>
                                        <td>
                                            <?= $item[3] //(empty($item[4])) ? "-":$item[4];?>
                                        </td>
                                        <td>
                                            <center>
                                                <span title="Agregar Cliente" class="btn btn-xs btn-info" 
                                                    onclick="AgregarClie('<?=$item[0]?>','<?=$item[2]?>','<?=$item[3]?>');" data-toggle='modal'>
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