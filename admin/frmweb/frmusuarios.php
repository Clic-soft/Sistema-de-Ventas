    <div class='modal-dialog'>
        <form method='POST' id="formC">
            <div class='modal-content'>
                <div class='modal-header'>
                    <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>&times;</button>
                    <h4 class='modal-title' id='myModalLabel'>USUARIOS</h4>
                </div>
                <div class='modal-body'>
                    <label for="" class="hidden-xs">Nombres</label>
                    <input type="text" name="nombres" required placeholder="Nombres" class="form-control">
                    <label for="" class="hidden-xs">Apellidos</label>
                    <input type="text" name="apellidos" required placeholder="Apellidos" class="form-control">
                    <label for="" class="hidden-xs">Tipo</label>
                    <select name="tipo" required class="form-control">
                        <option value="">Seleccione</option>
                        <option value="Administrador">Administrador</option>
                        <option value="Trabajador">Trabajador</option>
                    </select>
                    <label for="" class="hidden-xs">Celular</label>
                    <input type="text" name="celular" required placeholder="Celular" class="form-control">
                    <label for="" class="hidden-xs">E-mail</label>
                    <input type="text" name="email" required placeholder="E-mail" class="form-control">
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
