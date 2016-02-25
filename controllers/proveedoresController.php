<?php

//Clase extendida de la clase controller
class proveedoresController extends Controller {

	private $_proveedores;

    //Se crea el constructor
    public function __construct() {
        parent::__construct();
        //Se cargan el modelo
       $this->_proveedores = $this->loadModel('proveedores');
    }

	public function index() {
		if (Session::Get('autenticado') == true ){ 
			Session::set('modulo', "admin");
			$this->_view->titulo = 'PROVEEDORES';
			$this->_view->navegacion = '';

				//Se instancia la libreria
			$paginador = new Paginador();
		
			$this->_view->proveedores = $paginador->paginar($this->_proveedores->getProveedores(),1,20);
			$this->_view->paginacion = $paginador->getView('paginacion_dinamica');
			$this->_view->setJs(array('proveedores'));

			$this->_view->renderizar('index', "proveedores");
		} else {
      		$this->redireccionar('admin');
      	}
	}

	// paginacion listado
	public function paginacionDinamicaproveedores() {
        
		if (Session::Get('autenticado') == true ){ 
			Session::set('modulo', "admin");
        	$pagina = $this->getInt('pagina');
				
        	$paginador = new Paginador();
        	$this->_view->proveedores = $paginador->paginar($this->_proveedores->getProveedores(), $pagina,20);
        	$this->_view->paginacion = $paginador->getView('paginacion_dinamica');
        	$this->_view->setJs(array('proveedores'));
        	$this->_view->renderizar('refrescar_listado_proveedores', false, true);
        } else {
      		$this->redireccionar('admin');
      	}
		
    }

    public function nuevo_proveedores() {
		if (Session::Get('autenticado') == true ){ 
			Session::set('modulo', "admin");
			$this->_view->titulo = 'Nuevo Proveedor';
			$this->_view->navegacion = '';

			$this->_view->empresa = $this->_proveedores->gettipe();

			if ($this->getInt('guardar') == 1) {
				
				$this->_view->datos = (object) $_POST; /* No se debe realizar de esta formaaaa */
			//Se valida que las dos contraseñas digitadas coincidan

				if (!$this->getInt('tipo_empresa') || $this->getInt('tipo_empresa')== 0) {
					//Si no cumple la validacion sale mensaje de error
					$this->_view->_error = 'Debe Ingresar Tipo de Empresa';
					//Vista de la pagina actual
					$this->_view->renderizar('nuevo_proveedores','proveedores');
					//Saca de la funcion principal
					exit;
				}

				if (!$this->getInt('tipo_pro') || $this->getInt('tipo_pro')== 0) {
					//Si no cumple la validacion sale mensaje de error
					$this->_view->_error = 'Debe Ingresar Tipo de Proveedor';
					//Vista de la pagina actual
					$this->_view->renderizar('nuevo_proveedores','proveedores');
					//Saca de la funcion principal
					exit;
				}

				if (!$this->getInt('autorretenedor') || $this->getInt('autorretenedor')== 0) {
					//Si no cumple la validacion sale mensaje de error
					$this->_view->_error = 'Debe Indicar si es autorretenedor o no';
					//Vista de la pagina actual
					$this->_view->renderizar('nuevo_proveedores','proveedores');
					//Saca de la funcion principal
					exit;
				}


				if (!$this->getTexto('numdoc')) {
					//Si no cumple la validacion sale mensaje de error
					$this->_view->_error = 'Debe Ingresar el numero de documento';
					//Vista de la pagina actual
					$this->_view->renderizar('nuevo_proveedores','proveedores');
					//Saca de la funcion principal
					exit;
				}

				if (!$this->getTexto('rep')) {
					//Si no cumple la validacion sale mensaje de error
					$this->_view->_error = 'Debe Ingresar el representante legal';
					//Vista de la pagina actual
					$this->_view->renderizar('nuevo_proveedores','proveedores');
					//Saca de la funcion principal
					exit;
				}

				if (!$this->getTexto('rsocial')) {
					//Si no cumple la validacion sale mensaje de error
					$this->_view->_error = 'Debe Ingresar la razon social';
					//Vista de la pagina actual
					$this->_view->renderizar('nuevo_proveedores','proveedores');
					//Saca de la funcion principal
					exit;
				}

				if (!$this->getTexto('con')) {
					//Si no cumple la validacion sale mensaje de error
					$this->_view->_error = 'Debe Ingresar el nombre del contacto';
					//Vista de la pagina actual
					$this->_view->renderizar('nuevo_proveedores','proveedores');
					//Saca de la funcion principal
					exit;
				}

				if (!$this->getTexto('tel')) {
					//Si no cumple la validacion sale mensaje de error
					$this->_view->_error = 'Debe Ingresar el telefono ';
					//Vista de la pagina actual
					$this->_view->renderizar('nuevo_proveedores','proveedores');
					//Saca de la funcion principal
					exit;
				}

				if (!$this->getSql('dir')) {
	                //Si no cumple la validacion sale mensaje de error
	                $this->_view->_error = 'Debe introducir la direccion';
	                //Vista de la pagina actual
	                $this->_view->renderizar('nuevo_proveedores','proveedores');
	                //Saca de la funcion principal
	                exit;
            	}

            	if (!$this->getSql('email')) {
					//Si no cumple la validacion sale mensaje de error
					$this->_view->_error = 'Debe ingresar el email.';
					//Se renderiza a la pagina actual
					$this->_view->renderizar('nuevo_proveedores','proveedores');
					//Saca de la funcion principal
					exit;
				}

				//Se valida que no exista otro usuario con el mismo nombre
				if ($this->_proveedores->validarnumdoc($this->getTexto('numdoc'))) {
					//Si no cumple la validacion sale mensaje de error
					$this->_view->_error = 'El numero de documento ya existe';
					//Vista de la pagina actual
					$this->_view->renderizar('nuevo_proveedores','proveedores');
					//Saca de la funcion principal
					exit;
				}
				
				$this->_proveedores->crear_proveedores($this->getInt('tipo_pro'),
					$this->getInt('tipo_empresa'),
					$this->getInt('autorretenedor'),
					$this->getTexto('numdoc'),
					$this->getTexto('rep'),
					$this->getTexto('rsocial'),
					$this->getTexto('con'),
					$this->getTexto('tel'),
					$this->getSql('dir'),
					$this->getSql('email'));
				$this->_view->_mensaje = 'Datos Creados Correctamente';
			}

			$this->_view->renderizar('nuevo_proveedores', "proveedores");
		} else {
      		$this->redireccionar('admin');
      	}
	}

	public function editar_proveedor($id) {
		
		//VALIDAR QUE ESTE LOGUEADO EL USUARIO
    	if (Session::Get('autenticado') == true ){ 
			Session::set('modulo', "admin");
		
			if (!$this->filtrarInt($id)) {
	            //Se redirecciona al index
	            $this->redireccionar('index','proveedores');
	        }
	        //Si no existe un registro con ese id
	        if (!$this->_proveedores->getProveedor($this->filtrarInt($id))) {
	            //Se redirecciona al index
	            $this->redireccionar('index','proveedores');
	        }

				
			$this->_view->empresa = $this->_proveedores->gettipe();
			$this->_view->datos = $this->_proveedores->getProveedor($this->filtrarInt($id));
			 /* VALIDACION */
				if ($this->getInt('guardar') == 1) {
					
					$this->_view->datos = (object) $_POST; /* No se debe realizar de esta formaaaa */
				//Se valida que las dos contraseñas digitadas coincidan
				
				if (!$this->getInt('tipo_empresa') || $this->getInt('tipo_empresa')== 0) {
					//Si no cumple la validacion sale mensaje de error
					$this->_view->_error = 'Debe Ingresar Tipo de Empresa';
					//Vista de la pagina actual
					$this->_view->renderizar('editar_proveedores',false, true);
					//Saca de la funcion principal
					exit;
				}

				if (!$this->getInt('tipo_pro') || $this->getInt('tipo_pro')== 0) {
					//Si no cumple la validacion sale mensaje de error
					$this->_view->_error = 'Debe Ingresar Tipo de Proveedor';
					//Vista de la pagina actual
					$this->_view->renderizar('editar_proveedores',false, true);
					//Saca de la funcion principal
					exit;
				}

				if (!$this->getInt('autorretenedor') || $this->getInt('autorretenedor')== 0) {
					//Si no cumple la validacion sale mensaje de error
					$this->_view->_error = 'Debe Indicar si es autorretenedor o no';
					//Vista de la pagina actual
					$this->_view->renderizar('editar_proveedores',false, true);
					//Saca de la funcion principal
					exit;
				}


				if (!$this->getTexto('numdoc')) {
					//Si no cumple la validacion sale mensaje de error
					$this->_view->_error = 'Debe Ingresar el numero de documento';
					//Vista de la pagina actual
					$this->_view->renderizar('editar_proveedores',false, true);
					//Saca de la funcion principal
					exit;
				}

				if (!$this->getTexto('rep')) {
					//Si no cumple la validacion sale mensaje de error
					$this->_view->_error = 'Debe Ingresar el representante legal';
					//Vista de la pagina actual
					$this->_view->renderizar('editar_proveedores',false, true);
					//Saca de la funcion principal
					exit;
				}

				if (!$this->getTexto('rsocial')) {
					//Si no cumple la validacion sale mensaje de error
					$this->_view->_error = 'Debe Ingresar la razon social';
					//Vista de la pagina actual
					$this->_view->renderizar('editar_proveedores',false, true);
					//Saca de la funcion principal
					exit;
				}

				if (!$this->getTexto('con')) {
					//Si no cumple la validacion sale mensaje de error
					$this->_view->_error = 'Debe Ingresar el nombre del contacto';
					//Vista de la pagina actual
					$this->_view->renderizar('editar_proveedores',false, true);
					//Saca de la funcion principal
					exit;
				}

				if (!$this->getTexto('tel')) {
					//Si no cumple la validacion sale mensaje de error
					$this->_view->_error = 'Debe Ingresar el telefono ';
					//Vista de la pagina actual
					$this->_view->renderizar('editar_proveedores',false, true);
					//Saca de la funcion principal
					exit;
				}

				if (!$this->getSql('dir')) {
	                //Si no cumple la validacion sale mensaje de error
	                $this->_view->_error = 'Debe introducir la direccion';
	                //Vista de la pagina actual
	                $this->_view->renderizar('editar_proveedores',false, true);
	                //Saca de la funcion principal
	                exit;
            	}

            	if (!$this->getSql('email')) {
					//Si no cumple la validacion sale mensaje de error
					$this->_view->_error = 'Debe ingresar el email.';
					//Se renderiza a la pagina actual
					$this->_view->renderizar('editar_proveedores',false, true);
					//Saca de la funcion principal
					exit;
				}

				//Se valida que no exista otro usuario con el mismo nombre
				if ($this->_proveedores->validarnumdocedita($this->filtrarInt($id),$this->getTexto('numdoc'))) {
					//Si no cumple la validacion sale mensaje de error
					$this->_view->_error = 'El numero de documento ya existe';
					//Vista de la pagina actual
					$this->_view->renderizar('editar_proveedores',false, true);
					//Saca de la funcion principal
					exit;
				}
					
					$this->_proveedores->editar_proveedores($this->filtrarInt($id),
						$this->getInt('tipo_pro'),
						$this->getInt('tipo_empresa'),
						$this->getInt('autorretenedor'),
						$this->getTexto('numdoc'),
						$this->getTexto('rep'),
						$this->getTexto('rsocial'),
						$this->getTexto('con'),
						$this->getTexto('tel'),
						$this->getSql('dir'),
						$this->getSql('email'),
						$this->getInt('estado'));
				
				$this->_view->_mensaje = 'Datos Actualizados Correctamente';
				}		
			 	
				$this->_view->datos = $this->_proveedores->getProveedor($this->filtrarInt($id));
				
			 $this->_view->renderizar('editar_proveedores',false,true);

		} else {
      		$this->redireccionar('admin');
      	}
    }

    public function eliminarproveedores($id) {
		
		//VALIDAR QUE ESTE LOGUEADO EL USUARIO
    	if (Session::Get('autenticado') == true ){ 
			Session::set('modulo', "admin");
	        //Si el id no es un nro entero
	        if (!$this->filtrarInt($id)) {
	            //Se redirecciona al index
	            $this->redireccionar('index','proveedores');
	        }
	        //Si no existe un registro con ese id
	        if (!$this->_proveedores->getProveedor($this->filtrarInt($id))) {
	            //Se redirecciona al index
	            $this->redireccionar('index','proveedores');
	        }

        	$this->_proveedores->eliminar_proveedor($this->filtrarInt($id));
        } else {
      		$this->redireccionar('admin');
      	}
    }
	
}

?>