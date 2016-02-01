<?php

//Clase extendida de la clase controller
class usuariosController extends Controller {

	private $_usuarios;

    //Se crea el constructor
    public function __construct() {
        parent::__construct();
        //Se cargan el modelo
        $this->_usuarios = $this->loadModel('usuarios');
    }

	public function index() {
		if (Session::Get('autenticado') == true ){ 
			Session::set('modulo', "admin");
			$this->_view->titulo = 'USUARIOS';
			$this->_view->navegacion = '';

				//Se instancia la libreria
			$paginador = new Paginador();
		
			$this->_view->usuario = $paginador->paginar($this->_usuarios->getUsuarios(),1,20);
			$this->_view->paginacion = $paginador->getView('paginacion_dinamica');
			$this->_view->setJs(array('usuarios'));

			$this->_view->renderizar('index', "usuarios");
		} else {
      		$this->redireccionar('admin');
      	}
	}

	// paginacion listado
	public function paginacionDinamicausuarios() {
        
		if (Session::Get('autenticado') == true ){ 
			Session::set('modulo', "admin");
        	$pagina = $this->getInt('pagina');
				
        	$paginador = new Paginador();
        	$this->_view->usuario = $paginador->paginar($this->_usuarios->getUsuarios(), $pagina,20);
        	$this->_view->paginacion = $paginador->getView('paginacion_dinamica');
        	$this->_view->setJs(array('usuarios'));
        	$this->_view->renderizar('refrescar_listado_usuarios', false, true);
        } else {
      		$this->redireccionar('admin');
      	}
		
    }

    public function nuevo_usuario() {
		if (Session::Get('autenticado') == true ){ 
			Session::set('modulo', "admin");
			$this->_view->titulo = 'Nuevo Usuario';
			$this->_view->navegacion = '';

			if ($this->getInt('guardar') == 1) {
				
				$this->_view->datos = (object) $_POST; /* No se debe realizar de esta formaaaa */
			//Se valida que las dos contraseñas digitadas coincidan

				if (!$this->getTexto('usuario')) {
					//Si no cumple la validacion sale mensaje de error
					$this->_view->_error = 'Debe Ingresar el rol';
					//Vista de la pagina actual
					$this->_view->renderizar('nuevo_usuario','usuarios');
					//Saca de la funcion principal
					exit;
				}

				if (!$this->getSql('pass')) {
	                //Si no cumple la validacion sale mensaje de error
	                $this->_view->_error = 'Debe introducir su contrase&ntilde;a';
	                //Vista de la pagina actual
	                $this->_view->renderizar('nuevo_usuario','usuarios');
	                //Saca de la funcion principal
	                exit;
            	}

            	if (!$this->getSql('repitepass')) {
					//Si no cumple la validacion sale mensaje de error
					$this->_view->_error = 'Debe ingresar la contrase&ntilde;a nuevamente.';
					//Se renderiza a la pagina actual
					$this->_view->renderizar('nuevo_usuario','usuarios');
					//Saca de la funcion principal
					exit;
				}

				//Se valida que las dos contraseñas digitadas coincidan
				if (!$this->_usuarios->validarPassword($this->getSql('pass'), $this->getSql('repitepass'))) {
					//Si no cumple la validacion sale mensaje de error
					$this->_view->_error = 'Las contrase&ntilde;as no coiniciden';
					//Vista de la pagina actual
					$this->_view->renderizar('nuevo_usuario','usuarios');
					//Saca de la funcion principal
					exit;
				}

				//Se valida que no exista otro usuario con el mismo nombre
				if ($this->_usuarios->validarusuario($this->getTexto('usuario'))) {
					//Si no cumple la validacion sale mensaje de error
					$this->_view->_error = 'El nombre de usuario ya existe';
					//Vista de la pagina actual
					$this->_view->renderizar('nuevo_usuario','usuarios');
					//Saca de la funcion principal
					exit;
				}	

				
				$this->_usuarios->crear_usuario($this->getTexto('usuario'),$this->getSql('pass'));
				$this->_view->_mensaje = 'Datos Creados Correctamente';
			}

			$this->_view->renderizar('nuevo_usuario', "usuarios");
		} else {
      		$this->redireccionar('admin');
      	}
	}

	public function editar_usuario($id) {
		
		//VALIDAR QUE ESTE LOGUEADO EL USUARIO
    	if (Session::Get('autenticado') == true ){ 
			Session::set('modulo', "admin");
		
			if (!$this->filtrarInt($id)) {
	            //Se redirecciona al index
	            $this->redireccionar('index','usuarios');
	        }
	        //Si no existe un registro con ese id
	        if (!$this->_usuarios->getUsuario($this->filtrarInt($id))) {
	            //Se redirecciona al index
	            $this->redireccionar('index','usuarios');
	        }
				
			$this->_view->datos = $this->_usuarios->getUsuario($this->filtrarInt($id));
			 /* VALIDACION */
				if ($this->getInt('guardar') == 1) {
					
					$this->_view->datos = (object) $_POST; /* No se debe realizar de esta formaaaa */
				//Se valida que las dos contraseñas digitadas coincidan
				
				if (!$this->getTexto('usuario')) {
					//Si no cumple la validacion sale mensaje de error
					$this->_view->_error = 'Debe Ingresar el rol';
					//Vista de la pagina actual
					$this->_view->renderizar('editar_usuario',false,true);
					//Saca de la funcion principal
					exit;
				}

				if (!$this->getInt('estado')) {
					//Si no cumple la validacion sale mensaje de error
					$this->_view->_error = 'Debe Ingresar el estado del tipo de novedad';
					//Vista de la pagina actual
					$this->_view->renderizar('editar_usuario',false,true);
					//Saca de la funcion principal
					exit;
				}

				//Se valida que no exista otro usuario con el mismo nombre
				if ($this->_usuarios->validarusuarioedita($this->getTexto('usuario'),$this->filtrarInt($id))) {
					//Si no cumple la validacion sale mensaje de error
					$this->_view->_error = 'El nombre de usuario ya existe';
					//Vista de la pagina actual
					$this->_view->renderizar('editar_usuario',false,true);
					//Saca de la funcion principal
					exit;
				}
					
					$this->_usuarios->editar_usuario($this->filtrarInt($id),
						$this->getTexto('usuario'),
						$this->getInt('estado'));
				
				$this->_view->_mensaje = 'Datos Actualizados Correctamente';
				}		
			 	
				$this->_view->datos = $this->_usuarios->getUsuario($this->filtrarInt($id));
				
			 $this->_view->renderizar('editar_usuario',false,true);

		} else {
      		$this->redireccionar('admin');
      	}
    }


    public function cambio_clave($id) {
		
		//VALIDAR QUE ESTE LOGUEADO EL USUARIO
    	if (Session::Get('autenticado') == true ){ 
			Session::set('modulo', "admin");
		
			if (!$this->filtrarInt($id)) {
	            //Se redirecciona al index
	            $this->redireccionar('index','usuarios');
	        }
	        //Si no existe un registro con ese id
	        if (!$this->_usuarios->getUsuario($this->filtrarInt($id))) {
	            //Se redirecciona al index
	            $this->redireccionar('index','usuarios');
	        }
				
			$this->_view->datos = $this->_usuarios->getUsuario($this->filtrarInt($id));
			 /* VALIDACION */
				if ($this->getInt('guardar') == 1) {
					
					$this->_view->datos = (object) $_POST; /* No se debe realizar de esta formaaaa */
				//Se valida que las dos contraseñas digitadas coincidan
				
				if (!$this->getSql('anteriorpass')) {
	                //Si no cumple la validacion sale mensaje de error
	                $this->_view->_error = 'Debe introducir la contrase&ntilde;a actual';
	                //Vista de la pagina actual
	                $this->_view->renderizar('cambiar_clave',false,true);
	                //Saca de la funcion principal
	                exit;
            	}

				if (!$this->getSql('pass')) {
	                //Si no cumple la validacion sale mensaje de error
	                $this->_view->_error = 'Debe introducir su nueva contrase&ntilde;a';
	                //Vista de la pagina actual
	                $this->_view->renderizar('cambiar_clave',false,true);
	                //Saca de la funcion principal
	                exit;
            	}

            	if (!$this->getSql('repitepass')) {
					//Si no cumple la validacion sale mensaje de error
					$this->_view->_error = 'Debe ingresar la contrase&ntilde;a nuevamente.';
					//Se renderiza a la pagina actual
					$this->_view->renderizar('cambiar_clave',false,true);
					//Saca de la funcion principal
					exit;
				}

				//Se valida que las dos contraseñas digitadas coincidan
				if (!$this->_usuarios->validarPassword($this->getSql('pass'), $this->getSql('repitepass'))) {
					//Si no cumple la validacion sale mensaje de error
					$this->_view->_error = 'Las contrase&ntilde;as no coiniciden';
					//Vista de la pagina actual
					$this->_view->renderizar('cambiar_clave',false,true);
					//Saca de la funcion principal
					exit;
				}

				//Se valida que no exista otro usuario con el mismo nombre
				if (!$this->_usuarios->validarclave($this->getSql('anteriorpass'),$this->filtrarInt($id))) {
					//Si no cumple la validacion sale mensaje de error
					$this->_view->_error = 'La contrase&ntilde;a actual no coincide';
					//Vista de la pagina actual
					$this->_view->renderizar('cambiar_clave',false,true);
					//Saca de la funcion principal
					exit;
				}
					
					$this->_usuarios->editar_clave($this->filtrarInt($id),
						$this->getSql('pass'));
				
				$this->_view->_mensaje = 'Datos Actualizados Correctamente';
				}		
			 	
				$this->_view->datos = $this->_usuarios->getUsuario($this->filtrarInt($id));
				
			 $this->_view->renderizar('cambiar_clave',false,true);

		} else {
      		$this->redireccionar('admin');
      	}
    }

    public function eliminarusuario($id) {
		
		//VALIDAR QUE ESTE LOGUEADO EL USUARIO
    	if (Session::Get('autenticado') == true ){ 
			Session::set('modulo', "admin");
	        //Si el id no es un nro entero
	        if (!$this->filtrarInt($id)) {
	            //Se redirecciona al index
	            $this->redireccionar('index','usuarios');
	        }
	        //Si no existe un registro con ese id
	        if (!$this->_usuarios->getUsuario($this->filtrarInt($id))) {
	            //Se redirecciona al index
	            $this->redireccionar('index','usuarios');
	        }

        	$this->_usuarios->eliminar_usuario($this->filtrarInt($id));
        } else {
      		$this->redireccionar('admin');
      	}
    }
	
}

?>
