    <div class='modal-dialog'>
        <form method='POST' id="formC">
            <div class='modal-content'>
                <div class='modal-header'>
                    <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>&times;</button>
                    <h4 class='modal-title' id='myModalLabel'>USUARIOS</h4>
                </div>
                <div class='modal-body'>
                    <label for="" class="hidden-xs">USUARIO</label>
                    <input type="text" name="usuario" required placeholder="Usuario" class="form-control">
                    <label for="" class="hidden-xs">Contraseña</label>
                    <input type="password" name="password" required placeholder="**************" class="form-control">
                </div>
                <div class='modal-footer'>
                    <button type="submit" class="btn btn-success" name="btnReg">
                        <i class="glyphicon glyphicon-save"></i>Guardar
                    </button>
                    <button type='button' class="btn btn-danger" data-dismiss='modal'>No</button> 
                </div>
            </div><!-- /.modal-content -->
        </form>
    </div><!-- /.modal-dialog -->
