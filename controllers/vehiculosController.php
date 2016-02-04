<?php

//Clase extendida de la clase controller
class vehiculosController extends Controller {

	private $_vehiculos;

    //Se crea el constructor
    public function __construct() {
        parent::__construct();
        //Se cargan el modelo
        $this->_vehiculos = $this->loadModel('vehiculos');
    }

	public function index() {
		if (Session::Get('autenticado') == true ){ 
			Session::set('modulo', "admin");
			$this->_view->titulo = 'VEHICULOS';
			$this->_view->navegacion = '';

				//Se instancia la libreria
			$paginador = new Paginador();
		
			$this->_view->vehiculo = $paginador->paginar($this->_vehiculos->getVehiculos(),1,20);
			$this->_view->paginacion = $paginador->getView('paginacion_dinamica');
			$this->_view->setJs(array('vehiculos'));

			$this->_view->renderizar('index', "vehiculos");
		} else {
      		$this->redireccionar('admin');
      	}
	}

	// paginacion listado
	public function paginacionDinamicavehiculos() {
        
		if (Session::Get('autenticado') == true ){ 
			Session::set('modulo', "admin");
        	$pagina = $this->getInt('pagina');
				
        	$paginador = new Paginador();
        	$this->_view->vehiculo = $paginador->paginar($this->_vehiculos->getVehiculos(), $pagina,20);
        	$this->_view->paginacion = $paginador->getView('paginacion_dinamica');
        	$this->_view->setJs(array('vehiculos'));
        	$this->_view->renderizar('refrescar_listado_vehiculos', false, true);
        } else {
      		$this->redireccionar('admin');
      	}
		
    }

    public function nuevo_vehiculo() {
		if (Session::Get('autenticado') == true ){ 
			Session::set('modulo', "admin");
			$this->_view->titulo = 'Nuevo Vehiculo';
			$this->_view->navegacion = '';

			$this->_view->cliente = $this->_vehiculos->getcliente();

			if ($this->getInt('guardar') == 1) {
				
				$this->_view->datos = (object) $_POST; /* No se debe realizar de esta formaaaa */
			//Se valida que las dos contraseñas digitadas coincidan

				if (!$this->getInt('id_cliente') || $this->getInt('id_cliente')== 0) {
					//Si no cumple la validacion sale mensaje de error
					$this->_view->_error = 'Debe Ingresar el cliente';
					//Vista de la pagina actual
					$this->_view->renderizar('nuevo_vehiculo','vehiculos');
					//Saca de la funcion principal
					exit;
				}


				if (!$this->getTexto('placa')) {
					//Si no cumple la validacion sale mensaje de error
					$this->_view->_error = 'Debe Ingresar la placa del vehiculo';
					//Vista de la pagina actual
					$this->_view->renderizar('nuevo_vehiculo','vehiculos');
					//Saca de la funcion principal
					exit;
				}

				//Se valida que no exista otro usuario con el mismo nombre
				if ($this->_vehiculos->validavehiculo($this->getInt('id_cliente'),$this->getTexto('placa'))) {
					//Si no cumple la validacion sale mensaje de error
					$this->_view->_error = 'esta placa ya esta registrada para este cliente';
					//Vista de la pagina actual
					$this->_view->renderizar('nuevo_vehiculo','vehiculos');
					//Saca de la funcion principal
					exit;
				}
		
				$this->_vehiculos->crear_vehiculo($this->getInt('id_cliente'),
					$this->getTexto('placa'));
				$this->_view->_mensaje = 'Datos Creados Correctamente';
			}

			$this->_view->renderizar('nuevo_vehiculo', "vehiculos");
		} else {
      		$this->redireccionar('admin');
      	}
	}

	public function editar_vehiculo($id) {
		
		//VALIDAR QUE ESTE LOGUEADO EL USUARIO
    	if (Session::Get('autenticado') == true ){ 
			Session::set('modulo', "admin");
		
			if (!$this->filtrarInt($id)) {
	            //Se redirecciona al index
	            $this->redireccionar('index','vehiculos');
	        }
	        //Si no existe un registro con ese id
	        if (!$this->_vehiculos->getVehiculo($this->filtrarInt($id))) {
	            //Se redirecciona al index
	            $this->redireccionar('index','vehiculos');
	        }

				
			$this->_view->cliente = $this->_vehiculos->getcliente();
			$this->_view->datos = $this->_vehiculos->getVehiculo($this->filtrarInt($id));
			 /* VALIDACION */
				if ($this->getInt('guardar') == 1) {
					
					$this->_view->datos = (object) $_POST; /* No se debe realizar de esta formaaaa */
				//Se valida que las dos contraseñas digitadas coincidan
				
				if (!$this->getInt('id_cliente') || $this->getInt('id_cliente')== 0) {
					//Si no cumple la validacion sale mensaje de error
					$this->_view->_error = 'Debe Ingresar el cliente';
					//Vista de la pagina actual
					$this->_view->renderizar('editar_vehiculo',false,true);
					//Saca de la funcion principal
					exit;
				}

				if (!$this->getTexto('placa')) {
					//Si no cumple la validacion sale mensaje de error
					$this->_view->_error = 'Debe Ingresar la placa del vehiculo';
					//Vista de la pagina actual
					$this->_view->renderizar('editar_vehiculo',false,true);
					//Saca de la funcion principal
					exit;
				}

				//Se valida que no exista otro usuario con el mismo nombre
				if ($this->_vehiculos->validavehiculoedita($this->filtrarInt($id),$this->getInt('id_cliente'),$this->getTexto('placa'))) {
					//Si no cumple la validacion sale mensaje de error
					$this->_view->_error = 'esta placa ya esta registrada para este cliente';
					//Vista de la pagina actual
					$this->_view->renderizar('editar_vehiculo',false,true);
					//Saca de la funcion principal
					exit;
				}

				
					$this->_vehiculos->editar_vehiculo($this->filtrarInt($id),
						$this->getInt('id_cliente'),
						$this->getTexto('placa'));
				
				$this->_view->_mensaje = 'Datos Actualizados Correctamente';
				}		
			 	
				$this->_view->datos = $this->_vehiculos->getVehiculo($this->filtrarInt($id));
				
			 $this->_view->renderizar('editar_vehiculo',false,true);

		} else {
      		$this->redireccionar('admin');
      	}
    }

    public function eliminarvehiculo($id) {
		
		//VALIDAR QUE ESTE LOGUEADO EL USUARIO
    	if (Session::Get('autenticado') == true ){ 
			Session::set('modulo', "admin");
	        //Si el id no es un nro entero
	        if (!$this->filtrarInt($id)) {
	            //Se redirecciona al index
	            $this->redireccionar('index','vehiculos');
	        }
	        //Si no existe un registro con ese id
	        if (!$this->_vehiculos->getVehiculo($this->filtrarInt($id))) {
	            //Se redirecciona al index
	            $this->redireccionar('index','vehiculos');
	        }

        	$this->_vehiculos->eliminar_vehiculo($this->filtrarInt($id));
        } else {
      		$this->redireccionar('admin');
      	}
    }
	
}

?>
