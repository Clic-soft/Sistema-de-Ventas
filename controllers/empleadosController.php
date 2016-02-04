<?php

//Clase extendida de la clase controller
class empleadosController extends Controller {

	private $_empleados;

    //Se crea el constructor
    public function __construct() {
        parent::__construct();
        //Se cargan el modelo
        $this->_empleados = $this->loadModel('empleados');
    }

	public function index() {
		if (Session::Get('autenticado') == true ){ 
			$this->_view->titulo = 'EMPLEADOS';
			$this->_view->navegacion = '';

				//Se instancia la libreria
			$paginador = new Paginador();
		
			$this->_view->empleado = $paginador->paginar($this->_empleados->getEmpleados(),1,20);
			$this->_view->paginacion = $paginador->getView('paginacion_dinamica');
			$this->_view->setJs(array('empleados'));

			$this->_view->renderizar('index', "empleados");
		} else {
      		$this->redireccionar('index');
      	}
	}

	// paginacion listado
	public function paginacionDinamicaempleados() {
        
		if (Session::Get('autenticado') == true ){ 
        	$pagina = $this->getInt('pagina');
				
        	$paginador = new Paginador();
        	$this->_view->empleado = $paginador->paginar($this->_empleados->getEmpleados(), $pagina,20);
        	$this->_view->paginacion = $paginador->getView('paginacion_dinamica');
        	$this->_view->setJs(array('empleados'));
        	$this->_view->renderizar('refrescar_listado_empleados', false, true);
        } else {
      		$this->redireccionar('index');
      	}
		
    }

    public function nuevo_empleado() {
		if (Session::Get('autenticado') == true ){ 
			$this->_view->titulo = 'Nuevo Empleado';
			$this->_view->navegacion = '';

			$this->_view->documento = $this->_empleados->gettido();

			if ($this->getInt('guardar') == 1) {
				
				$this->_view->datos = (object) $_POST; /* No se debe realizar de esta formaaaa */
			//Se valida que las dos contraseñas digitadas coincidan

				if (!$this->getTexto('codigo')) {
					//Si no cumple la validacion sale mensaje de error
					$this->_view->_error = 'Debe Ingresar el codigo del empleado';
					//Vista de la pagina actual
					$this->_view->renderizar('nuevo_empleado','empleados');
					//Saca de la funcion principal
					exit;
				}

				if (!$this->getInt('tipo_doc') || $this->getInt('tipo_doc')== 0) {
					//Si no cumple la validacion sale mensaje de error
					$this->_view->_error = 'Debe Ingresar Tipo de Documento';
					//Vista de la pagina actual
					$this->_view->renderizar('nuevo_empleado','empleados');
					//Saca de la funcion principal
					exit;
				}


				if (!$this->getTexto('numdoc')) {
					//Si no cumple la validacion sale mensaje de error
					$this->_view->_error = 'Debe Ingresar el numero de documento';
					//Vista de la pagina actual
					$this->_view->renderizar('nuevo_empleado','empleados');
					//Saca de la funcion principal
					exit;
				}

				if (!$this->getTexto('nombres')) {
					//Si no cumple la validacion sale mensaje de error
					$this->_view->_error = 'Debe Ingresar el/los nombre del empleado';
					//Vista de la pagina actual
					$this->_view->renderizar('nuevo_empleado','empleados');
					//Saca de la funcion principal
					exit;
				}

				if (!$this->getTexto('apellidos')) {
					//Si no cumple la validacion sale mensaje de error
					$this->_view->_error = 'Debe Ingresar los apellidos del empleado';
					//Vista de la pagina actual
					$this->_view->renderizar('nuevo_empleado','empleados');
					//Saca de la funcion principal
					exit;
				}

				if (!$this->getInt('salario')) {
					//Si no cumple la validacion sale mensaje de error
					$this->_view->_error = 'Debe Ingresar el salario basico';
					//Vista de la pagina actual
					$this->_view->renderizar('nuevo_empleado','empleados');
					//Saca de la funcion principal
					exit;
				}

				//Se valida que no exista otro usuario con el mismo nombre
				if ($this->_empleados->validarnumdoc($this->getInt('tipo_doc'),$this->getTexto('numdoc'))) {
					//Si no cumple la validacion sale mensaje de error
					$this->_view->_error = 'El numero de documento ya existe con este tipo de documento';
					//Vista de la pagina actual
					$this->_view->renderizar('nuevo_empleado','empleados');
					//Saca de la funcion principal
					exit;
				}
	
				$this->_empleados->crear_empleado($this->getTexto('codigo'),
					$this->getInt('tipo_doc'),
					$this->getTexto('numdoc'),
					$this->getTexto('nombres'),
					$this->getTexto('apellidos'),
					$this->getInt('salario'));
				$this->_view->_mensaje = 'Datos Creados Correctamente';
			}

			$this->_view->renderizar('nuevo_empleado', "empleados");
		} else {
      		$this->redireccionar('index');
      	}
	}

	public function editar_empleado($id) {
		
		//VALIDAR QUE ESTE LOGUEADO EL USUARIO
    	if (Session::Get('autenticado') == true ){ 
		
			if (!$this->filtrarInt($id)) {
	            //Se redirecciona al index
	            $this->redireccionar('index','empleados');
	        }
	        //Si no existe un registro con ese id
	        if (!$this->_empleados->getEmpleado($this->filtrarInt($id))) {
	            //Se redirecciona al index
	            $this->redireccionar('index','empleados');
	        }

			$this->_view->documento = $this->_empleados->gettido();
			$this->_view->datos = $this->_empleados->getEmpleado($this->filtrarInt($id));
			 /* VALIDACION */
				if ($this->getInt('guardar') == 1) {
					
					$this->_view->datos = (object) $_POST; /* No se debe realizar de esta formaaaa */
				//Se valida que las dos contraseñas digitadas coincidan
				
				if (!$this->getTexto('codigo')) {
					//Si no cumple la validacion sale mensaje de error
					$this->_view->_error = 'Debe Ingresar el codigo del empleado';
					//Vista de la pagina actual
					$this->_view->renderizar('editar_empleado',false,true);
					//Saca de la funcion principal
					exit;
				}

				if (!$this->getInt('tipo_doc') || $this->getInt('tipo_doc')== 0) {
					//Si no cumple la validacion sale mensaje de error
					$this->_view->_error = 'Debe Ingresar Tipo de Documento';
					//Vista de la pagina actual
					$this->_view->renderizar('editar_empleado',false,true);
					//Saca de la funcion principal
					exit;
				}


				if (!$this->getTexto('numdoc')) {
					//Si no cumple la validacion sale mensaje de error
					$this->_view->_error = 'Debe Ingresar el numero de documento';
					//Vista de la pagina actual
					$this->_view->renderizar('editar_empleado',false,true);
					//Saca de la funcion principal
					exit;
				}

				if (!$this->getTexto('nombres')) {
					//Si no cumple la validacion sale mensaje de error
					$this->_view->_error = 'Debe Ingresar el/los nombre del empleado';
					//Vista de la pagina actual
					$this->_view->renderizar('editar_empleado',false,true);
					//Saca de la funcion principal
					exit;
				}

				if (!$this->getTexto('apellidos')) {
					//Si no cumple la validacion sale mensaje de error
					$this->_view->_error = 'Debe Ingresar los apellidos del empleado';
					//Vista de la pagina actual
					$this->_view->renderizar('editar_empleado',false,true);
					//Saca de la funcion principal
					exit;
				}

				if (!$this->getInt('salario')) {
					//Si no cumple la validacion sale mensaje de error
					$this->_view->_error = 'Debe Ingresar el salario basico';
					//Vista de la pagina actual
					$this->_view->renderizar('editar_empleado',false,true);
					//Saca de la funcion principal
					exit;
				}

				//Se valida que no exista otro usuario con el mismo nombre
				if ($this->_empleados->validarnumdocedita($this->getInt('tipo_doc'),$this->getTexto('numdoc'))) {
					//Si no cumple la validacion sale mensaje de error
					$this->_view->_error = 'El numero de documento ya existe con este tipo de documento';
					//Vista de la pagina actual
					$this->_view->renderizar('editar_empleado',false,true);
					//Saca de la funcion principal
					exit;
				}
					
					$this->_empleados->editar_empleado($this->filtrarInt($id),
						$this->getTexto('codigo'),
						$this->getInt('tipo_doc'),
						$this->getTexto('numdoc'),
						$this->getTexto('nombres'),
						$this->getTexto('apellidos'),
						$this->getInt('salario'));
				
				$this->_view->_mensaje = 'Datos Actualizados Correctamente';
				}		
			 	
				$this->_view->datos = $this->_empleados->getEmpleado($this->filtrarInt($id));
				
			 $this->_view->renderizar('editar_empleado',false,true);

		} else {
      		$this->redireccionar('index');
      	}
    }

    public function eliminarempleado($id) {
		
		//VALIDAR QUE ESTE LOGUEADO EL USUARIO
    	if (Session::Get('autenticado') == true ){ 
	        //Si el id no es un nro entero
	        if (!$this->filtrarInt($id)) {
	            //Se redirecciona al index
	            $this->redireccionar('index','empleados');
	        }
	        //Si no existe un registro con ese id
	        if (!$this->_empleados->getEmpleado($this->filtrarInt($id))) {
	            //Se redirecciona al index
	            $this->redireccionar('index','empleados');
	        }

        	$this->_empleados->eliminar_empleado($this->filtrarInt($id));
        } else {
      		$this->redireccionar('index');
      	}
    }
	
}

?>
