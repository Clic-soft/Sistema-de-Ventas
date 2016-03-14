<?php

//Clase extendida de la clase controller
class clientesController extends Controller {

	private $_clientes;

    //Se crea el constructor
    public function __construct() {
        parent::__construct();
        //Se cargan el modelo
        $this->_clientes = $this->loadModel('clientes');
    }

	public function index() {
		if (Session::Get('autenticado') == true ){ 
			Session::set('modulo', "admin");
			$this->_view->titulo = 'CLIENTES';
			$this->_view->navegacion = '';

				//Se instancia la libreria
			$paginador = new Paginador();
		
			$this->_view->cliente = $paginador->paginar($this->_clientes->getClientes(),1,20);
			$this->_view->paginacion = $paginador->getView('paginacion_dinamica');
			$this->_view->setJs(array('combociudad','clientes'));

			$this->_view->renderizar('index', "clientes");
		} else {
      		$this->redireccionar('admin');
      	}
	}

	// paginacion listado
	public function paginacionDinamicaclientes() {
        
		if (Session::Get('autenticado') == true ){ 
			Session::set('modulo', "admin");
        	$pagina = $this->getInt('pagina');
				
        	$paginador = new Paginador();
        	$this->_view->cliente = $paginador->paginar($this->_clientes->getClientes(), $pagina,20);
        	$this->_view->paginacion = $paginador->getView('paginacion_dinamica');
        	$this->_view->setJs(array('combociudad','clientes'));
        	$this->_view->renderizar('refrescar_listado_clientes', false, true);
        } else {
      		$this->redireccionar('admin');
      	}
		
    }

        public function getciudadcombo() {
		if (Session::Get('autenticado') == true ){ 
			Session::set('modulo', "admin");
        	
        	$id_depto = $_POST['id_depto'];
			$ciudad = $this->_clientes->getciudadcombo($this->filtrarInt($id_depto));
			echo $ciudad;	
        } else {
      		$this->redireccionar('admin');
      	}
	}

    public function nuevo_cliente() {
		if (Session::Get('autenticado') == true ){ 
			Session::set('modulo', "admin");
			$this->_view->titulo = 'Nuevo Cliente';
			$this->_view->navegacion = '';
			$this->_view->setJs(array('combociudad'));

			$this->_view->empresa = $this->_clientes->gettipe();
			$this->_view->documento = $this->_clientes->gettido();
			$this->_view->depto = $this->_clientes->getdepartamentos();

			if ($this->getInt('guardar') == 1) {
				
				$this->_view->datos = (object) $_POST; /* No se debe realizar de esta formaaaa */
			//Se valida que las dos contraseñas digitadas coincidan

				if (!$this->getInt('tipo_empresa') || $this->getInt('tipo_empresa')== 0) {
					//Si no cumple la validacion sale mensaje de error
					$this->_view->_error = 'Debe Ingresar Tipo de Empresa';
					//Vista de la pagina actual
					$this->_view->renderizar('nuevo_cliente','clientes');
					//Saca de la funcion principal
					exit;
				}

				if (!$this->getInt('tipo_doc') || $this->getInt('tipo_doc')== 0) {
					//Si no cumple la validacion sale mensaje de error
					$this->_view->_error = 'Debe Ingresar Tipo de Documento';
					//Vista de la pagina actual
					$this->_view->renderizar('nuevo_cliente','clientes');
					//Saca de la funcion principal
					exit;
				}

				if (!$this->getInt('id_depto') || $this->getInt('id_depto')== 0) {
					//Si no cumple la validacion sale mensaje de error
					$this->_view->_error = 'Debe Ingresar el departamento';
					//Vista de la pagina actual
					$this->_view->renderizar('nuevo_cliente','clientes');
					//Saca de la funcion principal
					exit;
				}

				if (!$this->getInt('id_ciudad') || $this->getInt('id_ciudad')== 0) {
					//Si no cumple la validacion sale mensaje de error
					$this->_view->_error = 'Debe Ingresar la ciudad';
					//Vista de la pagina actual
					$this->_view->renderizar('nuevo_cliente','clientes');
					//Saca de la funcion principal
					exit;
				}


				if (!$this->getTexto('numdoc')) {
					//Si no cumple la validacion sale mensaje de error
					$this->_view->_error = 'Debe Ingresar el numero de documento';
					//Vista de la pagina actual
					$this->_view->renderizar('nuevo_cliente','clientes');
					//Saca de la funcion principal
					exit;
				}

				if (!$this->getTexto('rucom')) {
					//Si no cumple la validacion sale mensaje de error
					$this->_view->_error = 'Debe Ingresar el numero de rucom';
					//Vista de la pagina actual
					$this->_view->renderizar('nuevo_cliente','clientes');
					//Saca de la funcion principal
					exit;
				}

				if (!$this->getTexto('rsocial')) {
					//Si no cumple la validacion sale mensaje de error
					$this->_view->_error = 'Debe Ingresar la razon social';
					//Vista de la pagina actual
					$this->_view->renderizar('nuevo_cliente','clientes');
					//Saca de la funcion principal
					exit;
				}

				if (!$this->getTexto('nomcom')) {
					//Si no cumple la validacion sale mensaje de error
					$this->_view->_error = 'Debe Ingresar el nombre comercial';
					//Vista de la pagina actual
					$this->_view->renderizar('nuevo_cliente','clientes');
					//Saca de la funcion principal
					exit;
				}

				if (!$this->getTexto('tel1')) {
					//Si no cumple la validacion sale mensaje de error
					$this->_view->_error = 'Debe Ingresar el telefono 1 ';
					//Vista de la pagina actual
					$this->_view->renderizar('nuevo_cliente','clientes');
					//Saca de la funcion principal
					exit;
				}

				if (!$this->getSql('dir')) {
	                //Si no cumple la validacion sale mensaje de error
	                $this->_view->_error = 'Debe introducir la direccion';
	                //Vista de la pagina actual
	                $this->_view->renderizar('nuevo_cliente','clientes');
	                //Saca de la funcion principal
	                exit;
            	}

            	if (!$this->getSql('email')) {
					//Si no cumple la validacion sale mensaje de error
					$this->_view->_error = 'Debe ingresar el email.';
					//Se renderiza a la pagina actual
					$this->_view->renderizar('nuevo_cliente','clientes');
					//Saca de la funcion principal
					exit;
				}

				//Se valida que no exista otro usuario con el mismo nombre
				if ($this->_clientes->validarnumdoc($this->getInt('tipo_doc'),$this->getTexto('numdoc'))) {
					//Si no cumple la validacion sale mensaje de error
					$this->_view->_error = 'El numero de documento ya existe con este tipo de documento';
					//Vista de la pagina actual
					$this->_view->renderizar('nuevo_cliente','clientes');
					//Saca de la funcion principal
					exit;
				}

				//Se valida que no exista otro usuario con el mismo nombre
				if ($this->_clientes->validarrucom($this->getTexto('rucom'))) {
					//Si no cumple la validacion sale mensaje de error
					$this->_view->_error = 'El numero rucom ya existe';
					//Vista de la pagina actual
					$this->_view->renderizar('nuevo_cliente','clientes');
					//Saca de la funcion principal
					exit;
				}	

				
				$this->_clientes->crear_cliente($this->getInt('tipo_empresa'),
					$this->getInt('tipo_doc'),
					$this->getTexto('numdoc'),
					$this->getTexto('rucom'),
					$this->getTexto('rsocial'),
					$this->getTexto('nomcom'),
					$this->getTexto('tel1'),
					$this->getTexto('tel2'),
					$this->getSql('dir'),
					$this->getSql('email'),
					$this->getInt('id_depto'),
					$this->getInt('id_ciudad'));
				$this->_view->_mensaje = 'Datos Creados Correctamente';
			}

			$this->_view->renderizar('nuevo_cliente', "clientes");
		} else {
      		$this->redireccionar('admin');
      	}
	}

	public function editar_cliente($id) {
		
		//VALIDAR QUE ESTE LOGUEADO EL USUARIO
    	if (Session::Get('autenticado') == true ){ 
			Session::set('modulo', "admin");
		
			if (!$this->filtrarInt($id)) {
	            //Se redirecciona al index
	            $this->redireccionar('index','clientes');
	        }
	        //Si no existe un registro con ese id
	        if (!$this->_clientes->getCliente($this->filtrarInt($id))) {
	            //Se redirecciona al index
	            $this->redireccionar('index','clientes');
	        }

	        $this->_view->setJs(array('combociudad'));
								
			$this->_view->empresa = $this->_clientes->gettipe();
			$this->_view->documento = $this->_clientes->gettido();
			$this->_view->datos = $this->_clientes->getCliente($this->filtrarInt($id));
			$d= $this->_clientes->getCliente($this->filtrarInt($id));
			$this->_view->depto = $this->_clientes->getdepartamentos();
			$this->_view->ciudad = $this->_clientes->getciudades($d->id_depto);
			 /* VALIDACION */
				if ($this->getInt('guardar') == 1) {
					
					$this->_view->datos = (object) $_POST; /* No se debe realizar de esta formaaaa */
				//Se valida que las dos contraseñas digitadas coincidan
				
				if (!$this->getInt('tipo_empresa') || $this->getInt('tipo_empresa')== 0) {
					//Si no cumple la validacion sale mensaje de error
					$this->_view->_error = 'Debe Ingresar Tipo de Empresa';
					//Vista de la pagina actual
					$this->_view->renderizar('editar_cliente',false,true);
					//Saca de la funcion principal
					exit;
				}

				if (!$this->getInt('tipo_doc') || $this->getInt('tipo_doc')== 0) {
					//Si no cumple la validacion sale mensaje de error
					$this->_view->_error = 'Debe Ingresar Tipo de Documento';
					//Vista de la pagina actual
					$this->_view->renderizar('editar_cliente',false,true);
					//Saca de la funcion principal
					exit;
				}

				if (!$this->getInt('tipo_doc') || $this->getInt('tipo_doc')== 0) {
					//Si no cumple la validacion sale mensaje de error
					$this->_view->_error = 'Debe Ingresar Tipo de Documento';
					//Vista de la pagina actual
					$this->_view->renderizar('editar_cliente',false,true);
					//Saca de la funcion principal
					exit;
				}

				if (!$this->getInt('id_depto') || $this->getInt('id_depto')== 0) {
					//Si no cumple la validacion sale mensaje de error
					$this->_view->_error = 'Debe Ingresar el departamento';
					//Vista de la pagina actual
					$this->_view->renderizar('editar_cliente',false,true);
					//Saca de la funcion principal
					exit;
				}


				if (!$this->getTexto('numdoc')) {
					//Si no cumple la validacion sale mensaje de error
					$this->_view->_error = 'Debe Ingresar el numero de documento';
					//Vista de la pagina actual
					$this->_view->renderizar('editar_cliente',false,true);
					//Saca de la funcion principal
					exit;
				}

				if (!$this->getTexto('rucom')) {
					//Si no cumple la validacion sale mensaje de error
					$this->_view->_error = 'Debe Ingresar el numero de rucom';
					//Vista de la pagina actual
					$this->_view->renderizar('editar_cliente',false,true);
					//Saca de la funcion principal
					exit;
				}

				if (!$this->getTexto('rsocial')) {
					//Si no cumple la validacion sale mensaje de error
					$this->_view->_error = 'Debe Ingresar la razon social';
					//Vista de la pagina actual
					$this->_view->renderizar('editar_cliente',false,true);
					//Saca de la funcion principal
					exit;
				}

				if (!$this->getTexto('nomcom')) {
					//Si no cumple la validacion sale mensaje de error
					$this->_view->_error = 'Debe Ingresar el nombre comercial';
					//Vista de la pagina actual
					$this->_view->renderizar('editar_cliente',false,true);
					//Saca de la funcion principal
					exit;
				}

				if (!$this->getTexto('tel1')) {
					//Si no cumple la validacion sale mensaje de error
					$this->_view->_error = 'Debe Ingresar el telefono 1 ';
					//Vista de la pagina actual
					$this->_view->renderizar('editar_cliente',false,true);
					//Saca de la funcion principal
					exit;
				}

				if (!$this->getSql('dir')) {
	                //Si no cumple la validacion sale mensaje de error
	                $this->_view->_error = 'Debe introducir la direccion';
	                //Vista de la pagina actual
	                $this->_view->renderizar('editar_cliente',false,true);
	                //Saca de la funcion principal
	                exit;
            	}

            	if (!$this->getSql('email')) {
					//Si no cumple la validacion sale mensaje de error
					$this->_view->_error = 'Debe ingresar el email.';
					//Se renderiza a la pagina actual
					$this->_view->renderizar('editar_cliente',false,true);
					//Saca de la funcion principal
					exit;
				}

				if (!$this->getInt('estado')) {
					//Si no cumple la validacion sale mensaje de error
					$this->_view->_error = 'Debe Ingresar el estado del tipo de novedad';
					//Vista de la pagina actual
					$this->_view->renderizar('editar_cliente',false,true);
					//Saca de la funcion principal
					exit;
				}

				//Se valida que no exista otro usuario con el mismo nombre
				if ($this->_clientes->validarnumdocedita($this->filtrarInt($id),$this->getInt('tipo_doc'),$this->getTexto('numdoc'))) {
					//Si no cumple la validacion sale mensaje de error
					$this->_view->_error = 'El numero de documento ya existe con este tipo de documento';
					//Vista de la pagina actual
					$this->_view->renderizar('editar_cliente',false,true);
					//Saca de la funcion principal
					exit;
				}

				//Se valida que no exista otro usuario con el mismo nombre
				if ($this->_clientes->validarrucomedita($this->filtrarInt($id),$this->getTexto('rucom'))) {
					//Si no cumple la validacion sale mensaje de error
					$this->_view->_error = 'El numero rucom ya existe';
					//Vista de la pagina actual
					$this->_view->renderizar('editar_cliente',false,true);
					//Saca de la funcion principal
					exit;
				}
					
					$this->_clientes->editar_cliente($this->filtrarInt($id),
						$this->getInt('tipo_empresa'),
						$this->getInt('tipo_doc'),
						$this->getTexto('numdoc'),
						$this->getTexto('rucom'),
						$this->getTexto('rsocial'),
						$this->getTexto('nomcom'),
						$this->getTexto('tel1'),
						$this->getTexto('tel2'),
						$this->getSql('dir'),
						$this->getSql('email'),
						$this->getInt('estado'),
						$this->getInt('id_depto'),
						$this->getInt('id_ciudad'));
				
				$this->_view->_mensaje = 'Datos Actualizados Correctamente';
				}		
			 	
				$this->_view->datos = $this->_clientes->getCliente($this->filtrarInt($id));
				
			 $this->_view->renderizar('editar_cliente',false,true);

		} else {
      		$this->redireccionar('admin');
      	}
    }

    public function eliminarcliente($id) {
		
		//VALIDAR QUE ESTE LOGUEADO EL USUARIO
    	if (Session::Get('autenticado') == true ){ 
			Session::set('modulo', "admin");
	        //Si el id no es un nro entero
	        if (!$this->filtrarInt($id)) {
	            //Se redirecciona al index
	            $this->redireccionar('index','clientes');
	        }
	        //Si no existe un registro con ese id
	        if (!$this->_clientes->getCliente($this->filtrarInt($id))) {
	            //Se redirecciona al index
	            $this->redireccionar('index','clientes');
	        }

        	$this->_clientes->eliminar_cliente($this->filtrarInt($id));
        } else {
      		$this->redireccionar('admin');
      	}
    }
	
}

?>
