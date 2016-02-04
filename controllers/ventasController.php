<?php

//Clase extendida de la clase controller
class ventasController extends Controller {

	private $_ventas;

    //Se crea el constructor
    public function __construct() {
        parent::__construct();
        //Se cargan el modelo
        $this->_ventas = $this->loadModel('ventas');
    }

	public function index() {
		if (Session::Get('autenticado') == true ){ 
			$this->_view->titulo = 'VENTAS';
			$this->_view->navegacion = '';

				//Se instancia la libreria
			$paginador = new Paginador();
		
			$this->_view->encabezado = $paginador->paginar($this->_ventas->getEncabezados(),1,20);
			$this->_view->paginacion = $paginador->getView('paginacion_dinamica');
			$this->_view->setJs(array('ventas'));

			$this->_view->renderizar('index', "ventas");
		} else {
      		$this->redireccionar('admin');
      	}
	}

	// paginacion listado
	public function paginacionDinamicaventas() {
        
		if (Session::Get('autenticado') == true ){ 
			Session::set('modulo', "admin");
        	$pagina = $this->getInt('pagina');
				
        	$paginador = new Paginador();
        	$this->_view->encabezado = $paginador->paginar($this->_ventas->getEncabezados(),$pagina,20);
        	$this->_view->paginacion = $paginador->getView('paginacion_dinamica');
        	$this->_view->setJs(array('ventas'));
        	$this->_view->renderizar('refrescar_listado_ventas', false, true);
        } else {
      		$this->redireccionar('admin');
      	}
		
    }

    public function nueva_venta() {
		if (Session::Get('autenticado') == true ){ 
			$this->_view->titulo = 'Nueva Venta';
			$this->_view->navegacion = '';

			$this->_view->cliente = $this->_ventas->getclientes();
			$this->_view->empleado = $this->_ventas->getempleados();
			$this->_view->placa = $this->_ventas->getplacas();

			if ($this->getInt('guardar') == 1) {
				
				$this->_view->datos = (object) $_POST; /* No se debe realizar de esta formaaaa */
			//Se valida que las dos contraseñas digitadas coincidan

				if (!$this->getInt('id_cliente') || $this->getInt('id_cliente')== 0) {
					//Si no cumple la validacion sale mensaje de error
					$this->_view->_error = 'Debe Ingresar el cliente';
					//Vista de la pagina actual
					$this->_view->renderizar('nueva_venta','ventas');
					//Saca de la funcion principal
					exit;
				}

				if (!$this->getInt('id_empleado') || $this->getInt('id_empleado')== 0) {
					//Si no cumple la validacion sale mensaje de error
					$this->_view->_error = 'Debe Ingresar el empleado';
					//Vista de la pagina actual
					$this->_view->renderizar('nueva_venta','ventas');
					//Saca de la funcion principal
					exit;
				}

				if (!$this->getInt('id_placa') || $this->getInt('id_placa')== 0) {
					//Si no cumple la validacion sale mensaje de error
					$this->_view->_error = 'Debe Ingresar la placa del vehiculo';
					//Vista de la pagina actual
					$this->_view->renderizar('nueva_venta','ventas');
					//Saca de la funcion principal
					exit;
				}

				if (!$this->getInt('forma') || $this->getInt('forma')== 0) {
					//Si no cumple la validacion sale mensaje de error
					$this->_view->_error = 'Debe Ingresar la forma de pago';
					//Vista de la pagina actual
					$this->_view->renderizar('nueva_venta','ventas');
					//Saca de la funcion principal
					exit;
				}

				$prefijo;
				$numero;
				$id_cons;
				$nactual;

				if($this->getInt('forma') ==1){
				$pref = $this->_ventas->get_prefijo(1);
				$id_cons=$pref->id;
				$prefijo=$pref->prefijo;
				$numero=$pref->actual;;

				}else if($this->getInt('forma') ==2){
				$pref = $this->_ventas->get_prefijo(2);
				$id_cons=$pref->id;
				$prefijo=$pref->prefijo;
				$numero=$pref->actual;;
				} 

				else if($this->getInt('forma') ==3){
				$pref = $this->_ventas->get_prefijo(2);
				$id_cons=$pref->id;
				$prefijo=$pref->prefijo;
				$numero=$pref->actual;;
				} 

				$nactual=$numero+1;
				
				

				$this->_ventas->crear_venta($this->getInt('id_cliente'),
					$this->getInt('id_empleado'),
					$this->getInt('id_placa'),
					$this->getInt('forma'),
					$prefijo,
					$numero);

				$this->_ventas->act_consecutivo($id_cons,$nactual);

				$this->_view->_mensaje = 'Datos Creados Correctamente';
			}

			$this->_view->renderizar('nueva_venta', "ventas");
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
