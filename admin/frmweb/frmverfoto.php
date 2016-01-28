<?php require_once '../clases/clsProducto.php'; ?>
<?php 
    if(isset($_POST['id'])):
        if(!empty($_POST['id'])):
            $objProd=new Producto();
            $fila=$objProd->get_productos_id($_POST['id']);
        endif;
    endif;
?>
    <div class='modal-dialog'>
        <form method='POST' id="formC">
            <div class='modal-content'>
                <div class='modal-header'>
                    <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>&times;</button>
                    <h4 class='modal-title' id='myModalLabel'>FOTO DEL PRODUCTO</h4>
                </div>
                <div class='modal-body'>
                    <div class="row">
                        <div class="col-xs-12">
                            <img class="img-responsive" src="uploads/<?=$fila[5]?>" alt="<?=$fila[5]?>">
                        </div>
                    </div>
                </div>
                <div class='modal-footer'>
                    <button type='button' class="btn btn-danger" data-dismiss='modal'>Cerrar</button> 
                </div>
            </div><!-- /.modal-content -->
        </form>
    </div><!-- /.modal-dialog -->
