<?php

//Clase extendida de la clase controller
class productosController extends Controller {

	private $_productos;

    //Se crea el constructor
    public function __construct() {
        parent::__construct();
        //Se cargan el modelo
        $this->_productos = $this->loadModel('productos');
    }

	public function index() {
		if (Session::Get('autenticado') == true ){ 
			Session::set('modulo', "admin");
			$this->_view->titulo = 'productos';
			$this->_view->navegacion = '';

				//Se instancia la libreria
			$paginador = new Paginador();
		
			$this->_view->producto = $paginador->paginar($this->_productos->getproductos(),1,20);
			$this->_view->paginacion = $paginador->getView('paginacion_dinamica');
			$this->_view->setJs(array('productos'));

			$this->_view->renderizar('index', "productos");
		} else {
      		$this->redireccionar('admin');
      	}
	}

	// paginacion listado
	public function paginacionDinamicaproductos() {
        
		if (Session::Get('autenticado') == true ){ 
			Session::set('modulo', "admin");
        	$pagina = $this->getInt('pagina');
				
        	$paginador = new Paginador();
        	$this->_view->cliente = $paginador->paginar($this->_productos->getproductos(), $pagina,20);
        	$this->_view->paginacion = $paginador->getView('paginacion_dinamica');
        	$this->_view->setJs(array('productos'));
        	$this->_view->renderizar('refrescar_listado_productos', false, true);
        } else {
      		$this->redireccionar('admin');
      	}
		
    }

    public function nuevo_producto() {
		if (Session::Get('autenticado') == true ){ 
			Session::set('modulo', "admin");
			$this->_view->titulo = 'Nuevo Producto';
			$this->_view->navegacion = '';

			
			$this->_view->unidad = $this->_productos->getunidades();

			if ($this->getInt('guardar') == 1) {
				
				$this->_view->datos = (object) $_POST; /* No se debe realizar de esta formaaaa */
			//Se valida que las dos contraseñas digitadas coincidan

				if (!$this->getInt('unidad') || $this->getInt('unidad')== 0) {
					//Si no cumple la validacion sale mensaje de error
					$this->_view->_error = 'Debe Ingresar la unidad de medida';
					//Vista de la pagina actual
					$this->_view->renderizar('nuevo_producto','productos');
					//Saca de la funcion principal
					exit;
				}

				if (!$this->getInt('precio') || $this->getInt('precio')< 1) {
					//Si no cumple la validacion sale mensaje de error
					$this->_view->_error = 'Debe Ingresar el precio';
					//Vista de la pagina actual
					$this->_view->renderizar('nuevo_producto','productos');
					//Saca de la funcion principal
					exit;
				}


				if (!$this->getTexto('producto')) {
					//Si no cumple la validacion sale mensaje de error
					$this->_view->_error = 'Debe ingresar el producto';
					//Vista de la pagina actual
					$this->_view->renderizar('nuevo_producto','productos');
					//Saca de la funcion principal
					exit;
				}

				
				//Se valida que no exista otro usuario con el mismo nombre
				if ($this->_productos->validarproducto($this->getTexto('producto'))) {
					//Si no cumple la validacion sale mensaje de error
					$this->_view->_error = 'El producto ya EXISTE !';
					//Vista de la pagina actual
					$this->_view->renderizar('nuevo_producto','productos');
					//Saca de la funcion principal
					exit;
				}

							
				$this->_productos->crear_producto($this->getInt('unidad'),
					$this->getInt('precio'),
					$this->getTexto('producto'));
				$this->_view->_mensaje = 'Datos Creados Correctamente';
			}

			$this->_view->renderizar('nuevo_producto', 'productos');
		} else {
      		$this->redireccionar('index');
      	}
	}

	public function editar_producto($id) {
		
		//VALIDAR QUE ESTE LOGUEADO EL USUARIO
    	if (Session::Get('autenticado') == true ){ 
			Session::set('modulo', "admin");
		
			if (!$this->filtrarInt($id)) {
	            //Se redirecciona al index
	            $this->redireccionar('index','productos');
	        }
	        //Si no existe un registro con ese id
	        if (!$this->_productos->getproducto($this->filtrarInt($id))) {
	            //Se redirecciona al index
	            $this->redireccionar('index','productos');
	        }

				
			$this->_view->unidad = $this->_productos->getunidades();
			$this->_view->datos = $this->_productos->getproducto($this->filtrarInt($id));
			 /* VALIDACION */
				if ($this->getInt('guardar') == 1) {
					
					$this->_view->datos = (object) $_POST; /* No se debe realizar de esta formaaaa */
				//Se valida que las dos contraseñas digitadas coincidan
				
				if (!$this->getInt('unidad') || $this->getInt('unidad')== 0) {
					//Si no cumple la validacion sale mensaje de error
					$this->_view->_error = 'Debe Ingresar la unidad de medida';
					//Vista de la pagina actual
					$this->_view->renderizar('editar_producto',false,true);
					//Saca de la funcion principal
					exit;
				}

				/*if ($this->_productos->validarproductoedita($this->filtrarInt($id),$this->getTexto('producto'))) {
					//Si no cumple la validacion sale mensaje de error
					$this->_view->_error = 'El producto ya EXISTE !';
					//Vista de la pagina actual
					$this->_view->renderizar('editar_producto',false,true);
					//Saca de la funcion principal
					exit;
				}*/

				if (!$this->getInt('precio') || $this->getInt('precio')< 1) {
					//Si no cumple la validacion sale mensaje de error
					$this->_view->_error = 'Debe Ingresar el precio';
					//Vista de la pagina actual
					$this->_view->renderizar('editar_producto',false,true);
					//Saca de la funcion principal
					exit;
				}


				if (!$this->getTexto('producto')) {
					//Si no cumple la validacion sale mensaje de error
					$this->_view->_error = 'Debe ingresar el producto';
					//Vista de la pagina actual
					$this->_view->renderizar('editar_producto',false,true);
					//Saca de la funcion principal
					exit;
				}
				
				
					$this->_productos->editar_producto($this->filtrarInt($id),
					$this->getInt('unidad'),
					$this->getInt('precio'),
					$this->getTexto('producto'));
				
				$this->_view->_mensaje = 'Datos Actualizados Correctamente';
				}		
			 	
				$this->_view->datos = $this->_productos->getproducto($this->filtrarInt($id));
				
			 $this->_view->renderizar('editar_producto',false,true);

		} else {
      		$this->redireccionar('index');
      	}
    }

    public function eliminarproducto($id) {
		
		//VALIDAR QUE ESTE LOGUEADO EL USUARIO
    	if (Session::Get('autenticado') == true ){ 
			Session::set('modulo', "admin");
	        //Si el id no es un nro entero
	        if (!$this->filtrarInt($id)) {
	            //Se redirecciona al index
	            $this->redireccionar('index','productos');
	        }
	        //Si no existe un registro con ese id
	        if (!$this->_productos->getproducto($this->filtrarInt($id))) {
	            //Se redirecciona al index
	            $this->redireccionar('index','productos');
	        }

        	$this->_productos->eliminar_producto($this->filtrarInt($id));
        } else {
      		$this->redireccionar('index');
      	}
    }
	
}

?>
