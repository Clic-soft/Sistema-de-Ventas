<?php

//Clase extendida de la clase controller
class comprasController extends Controller {

	private $_compras;

    //Se crea el constructor
    public function __construct() {
        parent::__construct();
        //Se cargan el modelo
        $this->_compras = $this->loadModel('compras');
    }

	public function index() {
		if (Session::Get('autenticado') == true ){ 
			$this->_view->titulo = 'COMPRAS';
			$this->_view->navegacion = '';

				//Se instancia la libreria
			$paginador = new Paginador();
		
			$this->_view->encabezado = $paginador->paginar($this->_compras->getEncabezados(),1,20);
			$this->_view->paginacion = $paginador->getView('paginacion_dinamica');
			$this->_view->setJs(array('compras'));

			$this->_view->renderizar('index', "compras");
		} else {
      		$this->redireccionar('admin');
      	}
	}

	// paginacion listado
	public function paginacionDinamicacompras() {
        
		if (Session::Get('autenticado') == true ){ 
			Session::set('modulo', "admin");
        	$pagina = $this->getInt('pagina');
				
        	$paginador = new Paginador();
        	$this->_view->encabezado = $paginador->paginar($this->_compras->getEncabezados(),$pagina,20);
        	$this->_view->paginacion = $paginador->getView('paginacion_dinamica');
        	$this->_view->setJs(array('compras'));
        	$this->_view->renderizar('refrescar_listado_compras', false, true);
        } else {
      		$this->redireccionar('admin');
      	}
		
    }

    public function nueva_compra() {
		if (Session::Get('autenticado') == true ){ 
			$this->_view->titulo = 'Nueva Venta';
			$this->_view->navegacion = '';

			$this->_view->proveedor = $this->_compras->getproveedores();

			if ($this->getInt('guardar') == 1) {
				
				$this->_view->datos = (object) $_POST; /* No se debe realizar de esta formaaaa */
			//Se valida que las dos contraseñas digitadas coincidan

				if (!$this->getInt('id_proveedor') || $this->getInt('id_proveedor')== 0) {
					//Si no cumple la validacion sale mensaje de error
					$this->_view->_error = 'Debe Ingresar el proveedor';
					//Vista de la pagina actual
					$this->_view->renderizar('nueva_compra','compras');
					//Saca de la funcion principal
					exit;
				}


				$prefijo;
				$numero;
				$id_cons;
				$nactual;

				$pref = $this->_compras->get_prefijo(6);

				$id_cons=$pref->id;
				$prefijo=$pref->prefijo;
				$numero=$pref->actual;

				$nactual=$numero+1;			

				$this->_compras->crear_compra($this->getInt('id_proveedor'),
					$prefijo,
					$numero);

				$this->_compras->act_consecutivo($id_cons,$nactual);

				$this->_view->_mensaje = 'Datos Creados Correctamente';
			}

			$this->_view->renderizar('nueva_compra', "compras");
		} else {
      		$this->redireccionar('admin');
      	}
	}

    public function cambiar_estado($id) {
		
		//VALIDAR QUE ESTE LOGUEADO EL USUARIO
    	if (Session::Get('autenticado') == true ){ 
	        //Si el id no es un nro entero
	        if (!$this->filtrarInt($id)) {
	            //Se redirecciona al index
	            $this->redireccionar('index','compras');
	        }
	        //Si no existe un registro con ese id
	        if (!$this->_compras->getEncabezado($this->filtrarInt($id))) {
	            //Se redirecciona al index
	            $this->redireccionar('index','compras');
	        }

	        $datos = $this->_compras->getEncabezado($this->filtrarInt($id));
	        $detalles = $this->_compras->getDetalles($this->filtrarInt($id));
	        $proveedor = $this->_compras->getproveedor($datos->id_proveedor);

	        $estado=2;

	        foreach ($detalles as $detalle) {
	        	$subtotal = $subtotal + $detalle->total_detalle;
	        }

	        $ret=0;
	        $iva=0;
	        $total=0;

	        if ($proveedor->tipo_proveedor == 1) {

	        	if ($proveedor->autoretenedor == 1) {
	        		$iva = $subtotal * 0.16;
	        		$total = $subtotal - $ret + $iva;
	        	} else {
	        		$ret= $subtotal * 0.10;
	        		$iva = $subtotal * 0.16;
	        		$total = $subtotal - $ret + $iva;
	        	}

	        } else if ($proveedor->tipo_proveedor == 2) {

	        	if ($subtotal < 803000) {
	        		$iva = $subtotal * 0.16;
	        		$total = $subtotal - $ret + $iva;
	        	} else {
	        		$ret= $subtotal * 0.025;
	        		$iva = $subtotal * 0.16;
	        		$total = $subtotal - $ret + $iva;
	        	}

	        } else if ($proveedor->tipo_proveedor == 3) {

	        	if ($proveedor->id_tipo_cliente == 1) {
	        		$ret= $subtotal * 0.06;
	        		$iva = $subtotal * 0.16;
	        		$total = $subtotal - $ret + $iva;
	        	} else {
	        		$ret= $subtotal * 0.04;
	        		$iva = $subtotal * 0.16;
	        		$total = $subtotal - $ret + $iva;
	        	}


	        } 

        	$this->_compras->cambiar_estado($this->filtrarInt($id),$estado, $subtotal, $ret, $iva, $total);
        } else {
      		$this->redireccionar('admin');
      	}
    }

    public function detalle($id) {
		if (Session::Get('autenticado') == true ){ 
			$this->_view->titulo = 'VENTAS';
			$this->_view->navegacion = '';

			$this->_view->setJs(array('detalle'));
			
			$this->_view->detalle =$this->_compras->getDetalles($this->filtrarInt($id));
			$this->_view->idenc=$this->filtrarInt($id);
			


			$this->_view->renderizar('detalle', "comrpas");
		} else {
      		$this->redireccionar('admin');
      	}
	}

    public function agregar_detalle($id) {
		if (Session::Get('autenticado') == true ){ 
			$this->_view->titulo = 'Nueva Compra';
			$this->_view->navegacion = '';
			$this->_view->idenc=$this->filtrarInt($id);
			$proveedor = $this->_compras->getEncabezado($this->filtrarInt($id));
			$this->_view->insumos = $this->_compras->getinsumos($proveedor->id_proveedor);


			if ($this->getInt('guardar') == 1) {
				
				$this->_view->datos = (object) $_POST; /* No se debe realizar de esta formaaaa */
			//Se valida que las dos contraseñas digitadas coincidan

				if (!$this->getInt('id_insumo') || $this->getInt('id_insumo')== 0) {
					//Si no cumple la validacion sale mensaje de error
					$this->_view->_error = 'Debe Ingresar el insumo';
					//Vista de la pagina actual
					$this->_view->renderizar('agregar_detalle','compras');
					//Saca de la funcion principal
					exit;
				}

				if (!$this->getInt('precio') || $this->getInt('precio')<1) {
					//Si no cumple la validacion sale mensaje de error
					$this->_view->_error = 'Debe Ingresar el precio';
					//Vista de la pagina actual
					$this->_view->renderizar('agregar_detalle','compras');
					//Saca de la funcion principal
					exit;
				}

				if (!$this->getDecimal('cant') || $this->getDecimal('cant')<=0) {
					//Si no cumple la validacion sale mensaje de error
					$this->_view->_error = 'Debe Ingresar la cantidad';
					//Vista de la pagina actual
					$this->_view->renderizar('agregar_detalle','compras');
					//Saca de la funcion principal
					exit;
				}

				$total=$this->getInt('precio')*$this->getDecimal('cant');				

				$this->_compras->agregar_detalle($this->filtrarInt($id),
					$this->getInt('id_insumo'),
					$this->getInt('precio'),
					$this->getDecimal('cant'),
					$total);

				$this->_view->_mensaje = 'Datos Creados Correctamente';
			}

			$this->_view->renderizar('agregar_detalle', "compras");
		} else {
      		$this->redireccionar('admin');
      	}
	}

	public function editar_detalle($id) {
		if (Session::Get('autenticado') == true ){ 
			$this->_view->titulo = 'Nueva Venta';
			$this->_view->navegacion = '';

			$dato = $this->_compras->getDetalle($this->filtrarInt($id));
			$this->_view->id =$dato->id;
			$proveedor = $this->_compras->getEncabezado($dato->id_compra);
			$this->_view->insumos = $this->_compras->getinsumos($proveedor->id_proveedor);
			
			$this->_view->datos = $this->_compras->getDetalle($this->filtrarInt($id));
			
			

			if ($this->getInt('guardar') == 1) {
				
				$this->_view->datos = (object) $_POST; /* No se debe realizar de esta formaaaa */
			//Se valida que las dos contraseñas digitadas coincidan

				if (!$this->getInt('id_insumo') || $this->getInt('id_insumo')== 0) {
					//Si no cumple la validacion sale mensaje de error
					$this->_view->_error = 'Debe Ingresar el insumo';
					//Vista de la pagina actual
					$this->_view->renderizar('editar_detalle',false,true);
					//Saca de la funcion principal
					exit;
				}

				if (!$this->getInt('precio') || $this->getInt('precio')<1) {
					//Si no cumple la validacion sale mensaje de error
					$this->_view->_error = 'Debe Ingresar el precio';
					//Vista de la pagina actual
					$this->_view->renderizar('editar_detalle',false,true);
					//Saca de la funcion principal
					exit;
				}

				if (!$this->getDecimal('cant') || $this->getDecimal('cant')<=0) {
					//Si no cumple la validacion sale mensaje de error
					$this->_view->_error = 'Debe Ingresar la cantidad';
					//Vista de la pagina actual
					$this->_view->renderizar('editar_detalle',false,true);
					//Saca de la funcion principal
					exit;
				}

				$total=$this->getInt('precio')*$this->getDecimal('cant');				

				$this->_compras->editar_detalle($this->filtrarInt($id),
					$this->getInt('id_insumo'),
					$this->getInt('precio'),
					$this->getDecimal('cant'),
					$total);

				$this->_view->_mensaje = 'Datos Creados Correctamente';
			}

			$dato = $this->_compras->getDetalle($this->filtrarInt($id));
			$this->_view->id =$dato->id;
			$proveedor = $this->_compras->getEncabezado($dato->id_compra);
			$this->_view->insumos = $this->_compras->getinsumos($proveedor->id_proveedor);
			$this->_view->datos = $this->_compras->getDetalle($this->filtrarInt($id));

			$this->_view->renderizar('editar_detalle', false, true);
		} else {
      		$this->redireccionar('admin');
      	}
	}


	public function eliminardetalle($id) {
		
		//VALIDAR QUE ESTE LOGUEADO EL USUARIO
    	if (Session::Get('autenticado') == true ){ 
	        //Si el id no es un nro entero
	        if (!$this->filtrarInt($id)) {
	            //Se redirecciona al index
	            $this->redireccionar('detalle','ventas');
	        }
	        //Si no existe un registro con ese id
	        if (!$this->_compras->getDetalle($this->filtrarInt($id))) {
	            //Se redirecciona al index
	            $this->redireccionar('detalle','ventas');
	        }

        	$this->_compras->eliminar_detalle($this->filtrarInt($id));
        } else {
      		$this->redireccionar('admin');
      	}
    }





    ///  VISTA  DE VER  FACTURA 
	public function ver_factura($id) {
		
		//VALIDAR QUE ESTE LOGUEADO EL USUARIO
    	if (Session::Get('autenticado') == true ){ 
	        //Si el id no es un nro entero
	     
    			$this->_view->datos = $this->_ventas->getEncabezado($this->filtrarInt($id));
    			$data=$this->_ventas->getEncabezado($this->filtrarInt($id));

    			$this->_view->empleado = $this->_ventas->getempleado($data->id_empleado);
    			$this->_view->cliente = $this->_ventas->getcliente($data->id_cliente);
    			$this->_view->detalle = $this->_ventas->getDetalles($this->filtrarInt($id));
    			$deta = $this->_ventas->getDetalles($this->filtrarInt($id));  			


        $this->_view->renderizar('factura', false,true);	
        } else {
      		$this->redireccionar('admin');
      	}
    }

//CERTIFICADO VER

	public function ver_certificado($id) {
		
		//VALIDAR QUE ESTE LOGUEADO EL USUARIO
    	if (Session::Get('autenticado') == true ){ 
	        //Si el id no es un nro entero
	     

    	$this->_view->datos = $this->_ventas->getEncabezado($this->filtrarInt($id));
    	$data=$this->_ventas->getEncabezado($this->filtrarInt($id));
    	$this->_view->vehiculo = $this->_ventas->get_placas_certificado($data->id_placa);


        $this->_view->renderizar('certificado', false,true);	
        } else {
      		$this->redireccionar('admin');
      	}
    }




}

?>
