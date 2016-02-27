<?php

//Clase extendida de la clase controller
class insumosController extends Controller {

	private $_insumos;

    //Se crea el constructor
    public function __construct() {
        parent::__construct();
        //Se cargan el modelo
        $this->_insumos = $this->loadModel('insumos');
    }

	public function index() {
		if (Session::Get('autenticado') == true ){ 
			Session::set('modulo', "admin");
			$this->_view->titulo = 'insumos';
			$this->_view->navegacion = '';

				//Se instancia la libreria
			$paginador = new Paginador();
		
			$this->_view->insumos = $paginador->paginar($this->_insumos->getinsumos(),1,20);
			$this->_view->paginacion = $paginador->getView('paginacion_dinamica');
			$this->_view->setJs(array('insumos'));

			$this->_view->renderizar('index', "insumos");
		} else {
      		$this->redireccionar('admin');
      	}
	}

	// paginacion listado
	public function paginacionDinamicainsumos() {
        
		if (Session::Get('autenticado') == true ){ 
			Session::set('modulo', "admin");
        	$pagina = $this->getInt('pagina');
				
        	$paginador = new Paginador();
        	$this->_view->insumos = $paginador->paginar($this->_insumos->getinsumos(), $pagina,20);
        	$this->_view->paginacion = $paginador->getView('paginacion_dinamica');
        	$this->_view->setJs(array('insumos'));
        	$this->_view->renderizar('refrescar_listado_insumos', false, true);
        } else {
      		$this->redireccionar('admin');
      	}
		
    }

     public function nuevo_insumos() {
		if (Session::Get('autenticado') == true ){ 
			Session::set('modulo', "admin");
			$this->_view->titulo = 'Nuevo insumos';
			$this->_view->navegacion = '';

			
			$this->_view->unidad = $this->_insumos->getcategorias();

			if ($this->getInt('guardar') == 1) {
				
				$this->_view->datos = (object) $_POST; /* No se debe realizar de esta formaaaa */
			//Se valida que las dos contraseñas digitadas coincidan

				if (!$this->getInt('unidad') || $this->getInt('unidad')== 0) {
					//Si no cumple la validacion sale mensaje de error
					$this->_view->_error = 'Debe Ingresar la categoria';
					//Vista de la pagina actual
					$this->_view->renderizar('nuevo_insumos','insumos');
					//Saca de la funcion principal
					exit;
				}			
			
				if (!$this->getTexto('producto')) {
					//Si no cumple la validacion sale mensaje de error
					$this->_view->_error = 'Debe ingresar el insumo';
					//Vista de la pagina actual
					$this->_view->renderizar('nuevo_insumos','insumos');
					//Saca de la funcion principal
					exit;
				}

							
				$this->_insumos->crear_insumos($this->getInt('unidad'),
					$this->getTexto('producto'));
				$this->_view->_mensaje = 'Datos Creados Correctamente';
			}

			$this->_view->renderizar('nuevo_insumos', 'insumos');
		} else {
      		$this->redireccionar('index');
      	}
	}

	public function editar_insumos($id) {
		
		//VALIDAR QUE ESTE LOGUEADO EL USUARIO
    	if (Session::Get('autenticado') == true ){ 
			Session::set('modulo', "admin");
		
			if (!$this->filtrarInt($id)) {
	            //Se redirecciona al index
	            $this->redireccionar('index','insumos');
	        }
	        //Si no existe un registro con ese id
	        if (!$this->_insumos->getinsumos($this->filtrarInt($id))) {
	            //Se redirecciona al index
	            $this->redireccionar('index','insumos');
	        }

				
			$this->_view->categoria = $this->_insumos->getcategorias();
			$this->_view->datos = $this->_insumos->getinsumo($this->filtrarInt($id));
			 /* VALIDACION */
				if ($this->getInt('guardar') == 1) {
					
					$this->_view->datos = (object) $_POST; /* No se debe realizar de esta formaaaa */
				//Se valida que las dos contraseñas digitadas coincidan
				
				if (!$this->getInt('id_cat_insumos') || $this->getInt('id_cat_insumos')== 0) {
					//Si no cumple la validacion sale mensaje de error
					$this->_view->_error = 'Debe Ingresar la categoria de insumo';
					//Vista de la pagina actual
					$this->_view->renderizar('editar_insumos',false,true);
					//Saca de la funcion principal
					exit;
				}		

				if (!$this->getTexto('insumos')) {
					//Si no cumple la validacion sale mensaje de error
					$this->_view->_error = 'Debe ingresar el insumos';
					//Vista de la pagina actual
					$this->_view->renderizar('editar_insumos',false,true);
					//Saca de la funcion principal
					exit;
				}
				
				
					$this->_insumos->editar_insumos($this->filtrarInt($id),
					$this->getInt('id_cat_insumos'),
					$this->getTexto('insumos'));
				
				$this->_view->_mensaje = 'Datos Actualizados Correctamente';
				}		
			 	
				$this->_view->datos = $this->_insumos->getinsumo($this->filtrarInt($id));
				
			 $this->_view->renderizar('editar_insumos',false,true);

		} else {
      		$this->redireccionar('index');
      	}
    }

    public function eliminarinsumo($id) {
		
		//VALIDAR QUE ESTE LOGUEADO EL USUARIO
    	if (Session::Get('autenticado') == true ){ 
			Session::set('modulo', "admin");
	        //Si el id no es un nro entero
	        if (!$this->filtrarInt($id)) {
	            //Se redirecciona al index
	            $this->redireccionar('index','insumos');
	        }
	        //Si no existe un registro con ese id
	        if (!$this->_insumos->getinsumo($this->filtrarInt($id))) {
	            //Se redirecciona al index
	            $this->redireccionar('index','insumos');
	        }

        	$this->_insumos->eliminar_insumo($this->filtrarInt($id));
        } else {
      		$this->redireccionar('index');
      	}
    }
	
}

?>
