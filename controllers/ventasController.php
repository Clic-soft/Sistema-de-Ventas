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
			$this->_view->setJs(array('ventas','comboplacas'));

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

    public function getplacascombo() {
		if (Session::Get('autenticado') == true ){ 
       	
        	$id_cliente = $_POST['id_cliente'];
			$vehiculo = $this->_ventas->getplacas($this->filtrarInt($id_cliente));
			echo $vehiculo;	
        } else {
      		$this->redireccionar('admin');
      	}
	}

    public function nueva_venta() {
		if (Session::Get('autenticado') == true ){ 
			$this->_view->titulo = 'Nueva Venta';
			$this->_view->navegacion = '';
			$this->_view->setJs(array('comboplacas'));

			$this->_view->cliente = $this->_ventas->getclientes();
			$this->_view->empleado = $this->_ventas->getempleados();

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

				$prefijoco;
				$numeroco;
				$id_consco;
				$nactualco;


				if($this->getInt('forma') ==1){
				$pref = $this->_ventas->get_prefijo(1);
				$prefco = $this->_ventas->get_prefijo(3);
				$id_cons=$pref->id;
				$prefijo=$pref->prefijo;
				$numero=$pref->actual;

				$prefijoco=$prefco->prefijo;
				$numeroco=$prefco->actual;
				$id_consco=$prefco->id;

				}else if($this->getInt('forma') ==2){
				$pref = $this->_ventas->get_prefijo(2);
				$prefco = $this->_ventas->get_prefijo(4);
				$id_cons=$pref->id;
				$prefijo=$pref->prefijo;
				$numero=$pref->actual;

				$prefijoco=$prefco->prefijo;
				$numeroco=$prefco->actual;
				$id_consco=$prefco->id;
				} 

				else if($this->getInt('forma') ==3){
				$pref = $this->_ventas->get_prefijo(2);
				$prefco = $this->_ventas->get_prefijo(4);
				$id_cons=$pref->id;
				$prefijo=$pref->prefijo;
				$numero=$pref->actual;

				$prefijoco=$prefco->prefijo;
				$numeroco=$prefco->actual;
				$id_consco=$prefco->id;
				} 

				$nactualco=$numeroco+1;
				$nactual=$numero+1;
				
				

				$this->_ventas->crear_venta($this->getInt('id_cliente'),
					$this->getInt('id_empleado'),
					$this->getInt('id_placa'),
					$this->getInt('forma'),
					$prefijo,
					$numero,
					$prefijoco,
					$numeroco);

				$this->_ventas->act_consecutivo($id_cons,$nactual);
				$this->_ventas->act_consecutivo($id_consco,$nactualco);

				$this->_view->_mensaje = 'Datos Creados Correctamente';
			}

			$this->_view->renderizar('nueva_venta', "ventas");
		} else {
      		$this->redireccionar('admin');
      	}
	}

	public function editar_venta($id) {
		
		//VALIDAR QUE ESTE LOGUEADO EL USUARIO
    	if (Session::Get('autenticado') == true ){ 
			Session::set('modulo', "admin");
		
			if (!$this->filtrarInt($id)) {
	            //Se redirecciona al index
	            $this->redireccionar('index','ventas');
	        }
	        //Si no existe un registro con ese id
	        if (!$this->_ventas->getEncabezado($this->filtrarInt($id))) {
	            //Se redirecciona al index
	            $this->redireccionar('index','ventas');
	        }
			$this->_view->setJs(array('comboplacas'));

			$this->_view->cliente = $this->_ventas->getclientes();
			$this->_view->empleado = $this->_ventas->getempleados();
			$this->_view->placa = $this->_ventas->get_placas();

			$this->_view->datos = $this->_ventas->getEncabezado($this->filtrarInt($id));
			 /* VALIDACION */
				if ($this->getInt('guardar') == 1) {
					
					$this->_view->datos = (object) $_POST; /* No se debe realizar de esta formaaaa */
				//Se valida que las dos contraseñas digitadas coincidan
				
				if (!$this->getInt('id_cliente') || $this->getInt('id_cliente')== 0) {
					//Si no cumple la validacion sale mensaje de error
					$this->_view->_error = 'Debe Ingresar el cliente';
					//Vista de la pagina actual
					$this->_view->renderizar('editar_venta',false,true);
					//Saca de la funcion principal
					exit;
				}

				if (!$this->getInt('id_empleado') || $this->getInt('id_empleado')== 0) {
					//Si no cumple la validacion sale mensaje de error
					$this->_view->_error = 'Debe Ingresar el empleado';
					//Vista de la pagina actual
					$this->_view->renderizar('editar_venta',false,true);
					//Saca de la funcion principal
					exit;
				}

				if (!$this->getInt('id_placa') || $this->getInt('id_placa')== 0) {
					//Si no cumple la validacion sale mensaje de error
					$this->_view->_error = 'Debe Ingresar la placa del vehiculo';
					//Vista de la pagina actual
					$this->_view->renderizar('editar_venta',false,true);
					//Saca de la funcion principal
					exit;
				}

				
					$this->_ventas->editar_venta($this->filtrarInt($id),
						$this->getInt('id_cliente'),
						$this->getInt('id_empleado'),
						$this->getInt('id_placa'));
				
				$this->_view->_mensaje = 'Datos Actualizados Correctamente';
				}		
			 	
				$this->_view->datos = $this->_ventas->getEncabezado($this->filtrarInt($id));
				
			 $this->_view->renderizar('editar_venta',false,true);

		} else {
      		$this->redireccionar('admin');
      	}
    }

    public function eliminarventa($id) {
		
		//VALIDAR QUE ESTE LOGUEADO EL USUARIO
    	if (Session::Get('autenticado') == true ){ 
	        //Si el id no es un nro entero
	        if (!$this->filtrarInt($id)) {
	            //Se redirecciona al index
	            $this->redireccionar('index','vehiculos');
	        }
	        //Si no existe un registro con ese id
	        if (!$this->_ventas->getEncabezado($this->filtrarInt($id))) {
	            //Se redirecciona al index
	            $this->redireccionar('index','vehiculos');
	        }

        	$this->_ventas->eliminar_venta($this->filtrarInt($id));
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
	            $this->redireccionar('index','vehiculos');
	        }
	        //Si no existe un registro con ese id
	        if (!$this->_ventas->getEncabezado($this->filtrarInt($id))) {
	            //Se redirecciona al index
	            $this->redireccionar('index','vehiculos');
	        }

	        $datos = $this->_ventas->getEncabezado($this->filtrarInt($id));
	        $detalles = $this->_ventas->getDetalles($this->filtrarInt($id));

	        if($datos->forma_pago == 3){
	        	$estado=2;
	        }else{
	        	$estado=4;
	        }

	        foreach ($detalles as $detalle) {
	        	$descuento = $descuento + $detalle->descuento;
	        	$total = $total + $detalle->total_detalle;
	        }

	        $subtotal=$total+$descuento;

        	$this->_ventas->cambiar_estado($this->filtrarInt($id),$estado, $subtotal, $descuento, $total);
        } else {
      		$this->redireccionar('admin');
      	}
    }

    public function detalle($id) {
		if (Session::Get('autenticado') == true ){ 
			$this->_view->titulo = 'VENTAS';
			$this->_view->navegacion = '';

			$this->_view->setJs(array('detalle'));
			
			$this->_view->detalle =$this->_ventas->getDetalles($this->filtrarInt($id));
			$this->_view->idenc=$this->filtrarInt($id);
			


			$this->_view->renderizar('detalle', "ventas");
		} else {
      		$this->redireccionar('admin');
      	}
	}

    public function agregar_detalle($id) {
		if (Session::Get('autenticado') == true ){ 
			$this->_view->titulo = 'Nueva Venta';
			$this->_view->navegacion = '';
			$this->_view->idenc=$this->filtrarInt($id);
			$this->_view->producto = $this->_ventas->getproductos();


			if ($this->getInt('guardar') == 1) {
				
				$this->_view->datos = (object) $_POST; /* No se debe realizar de esta formaaaa */
			//Se valida que las dos contraseñas digitadas coincidan

				if (!$this->getInt('producto') || $this->getInt('producto')== 0) {
					//Si no cumple la validacion sale mensaje de error
					$this->_view->_error = 'Debe Ingresar el producto';
					//Vista de la pagina actual
					$this->_view->renderizar('agregar_detalle','ventas');
					//Saca de la funcion principal
					exit;
				}

				if (!$this->getInt('precio') || $this->getInt('precio')<1) {
					//Si no cumple la validacion sale mensaje de error
					$this->_view->_error = 'Debe Ingresar el precio';
					//Vista de la pagina actual
					$this->_view->renderizar('agregar_detalle','ventas');
					//Saca de la funcion principal
					exit;
				}

				if (!$this->getDecimal('cant') || $this->getDecimal('cant')<=0) {
					//Si no cumple la validacion sale mensaje de error
					$this->_view->_error = 'Debe Ingresar la placa del vehiculo';
					//Vista de la pagina actual
					$this->_view->renderizar('agregar_detalle','ventas');
					//Saca de la funcion principal
					exit;
				}

				$total=($this->getInt('precio')*$this->getDecimal('cant'))-$this->getInt('desc');				

				$this->_ventas->agregar_detalle($this->filtrarInt($id),
					$this->getInt('producto'),
					$this->getInt('precio'),
					$this->getDecimal('cant'),
					$this->getInt('desc'),
					$total);

				$this->_view->_mensaje = 'Datos Creados Correctamente';
			}

			$this->_view->renderizar('agregar_detalle', "ventas");
		} else {
      		$this->redireccionar('admin');
      	}
	}

	public function editar_detalle($id) {
		if (Session::Get('autenticado') == true ){ 
			$this->_view->titulo = 'Nueva Venta';
			$this->_view->navegacion = '';

			$this->_view->producto = $this->_ventas->getproductos();
			
			$this->_view->datos = $this->_ventas->getDetalle($this->filtrarInt($id));
			
			$dato = $this->_ventas->getDetalle($this->filtrarInt($id));
			$this->_view->id =$dato->id;

			if ($this->getInt('guardar') == 1) {
				
				$this->_view->datos = (object) $_POST; /* No se debe realizar de esta formaaaa */
			//Se valida que las dos contraseñas digitadas coincidan

				if (!$this->getInt('producto') || $this->getInt('producto')== 0) {
					//Si no cumple la validacion sale mensaje de error
					$this->_view->_error = 'Debe Ingresar el producto';
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
					$this->_view->_error = 'Debe Ingresar la placa del vehiculo';
					//Vista de la pagina actual
					$this->_view->renderizar('editar_detalle',false,true);
					//Saca de la funcion principal
					exit;
				}

				$total=($this->getInt('precio')*$this->getDecimal('cant'))-$this->getInt('desc');				

				$this->_ventas->editar_detalle($this->filtrarInt($id),
					$this->getInt('producto'),
					$this->getInt('precio'),
					$this->getDecimal('cant'),
					$this->getInt('desc'),
					$total);

				$this->_view->_mensaje = 'Datos Creados Correctamente';
			}

			$this->_view->datos = $this->_ventas->getDetalle($this->filtrarInt($id));
			$dato = $this->_ventas->getDetalle($this->filtrarInt($id));
			$this->_view->id =$dato->id;

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
	        if (!$this->_ventas->getDetalle($this->filtrarInt($id))) {
	            //Se redirecciona al index
	            $this->redireccionar('detalle','ventas');
	        }

        	$this->_ventas->eliminar_detalle($this->filtrarInt($id));
        } else {
      		$this->redireccionar('admin');
      	}
    }

    public function ges_inforem($id) {
		
		//VALIDAR QUE ESTE LOGUEADO EL USUARIO
    	if (Session::Get('autenticado') == true ){ 
	        //Si el id no es un nro entero
	        if (!$this->filtrarInt($id)) {
	            //Se redirecciona al index
	            $this->redireccionar('index','vehiculos');
	        }
	        //Si no existe un registro con ese id
	        if (!$this->_ventas->getEncabezado($this->filtrarInt($id))) {
	            //Se redirecciona al index
	            $this->redireccionar('index','vehiculos');
	        }

	        $this->_view->setJs(array('ventas','facturar'));

	        $datos = $this->_ventas->getEncabezado($this->filtrarInt($id));
	        $this->_view->pendientes = $this->_ventas->getpendienteFacturas($datos->id_cliente,3);
	        $this->_view->idenc = $this->filtrarInt($id);

        	$this->_view->renderizar('gestionar_remision', 'ventas');
        } else {
      		$this->redireccionar('admin');
      	}
    }



public function facturar($idrem, $idfac) {
		
		//VALIDAR QUE ESTE LOGUEADO EL USUARIO
    	if (Session::Get('autenticado') == true ){ 
	        //Si el id no es un nro entero
	        if (!$this->filtrarInt($idfac)) {
	            //Se redirecciona al index
	            $this->redireccionar('index','vehiculos');
	        }
	        //Si no existe un registro con ese id
	        if (!$this->_ventas->getEncabezado($this->filtrarInt($idfac))) {
	            //Se redirecciona al index
	            $this->redireccionar('index','vehiculos');
	        }

	        $datos = $this->_ventas->getEncabezado($this->filtrarInt($idfac));
	        $detalles = $this->_ventas->getDetalles($this->filtrarInt($idrem));
	        
	        $estado=4;


	        foreach ($detalles as $detalle) {

	        	$this->_ventas->agregar_detalle_ges($this->filtrarInt($idfac),
					$detalle->id_producto,
					$detalle->precio,
					$detalle->cantidad,
					$detalle->descuento,
					$detalle->total_detalle,
					$this->filtrarInt($idrem));
	        }

        	$this->_ventas->cambiar_estado_ges($this->filtrarInt($idrem),$estado);

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






public function abonos($id) {
		if (Session::Get('autenticado') == true ){ 
			$this->_view->titulo = 'VENTAS';
			$this->_view->navegacion = '';

			$this->_view->setJs(array('abonos'));
			
			$this->_view->datos = $this->_ventas->getEncabezado($this->filtrarInt($id));
			$this->_view->abono =$this->_ventas->getAbonos($this->filtrarInt($id));
			$this->_view->idenc=$this->filtrarInt($id);
			$abonos =$this->_ventas->getAbonos($this->filtrarInt($id));
			$total_abonos=0;

			foreach ($abonos as $abono) {
					$total_abonos = $total_abonos + $abono->valor;
				}

			$this->_view->tabono = $total_abonos;


			$this->_view->renderizar('abonos', "ventas");
		} else {
      		$this->redireccionar('admin');
      	}
	}

    public function agregar_abono($id) {
		if (Session::Get('autenticado') == true ){ 
			$this->_view->titulo = 'Nueva Venta';
			$this->_view->navegacion = '';
			$this->_view->idenc=$this->filtrarInt($id);

			$encabezado = $this->_ventas->getEncabezado($this->filtrarInt($id));
			$abonos =$this->_ventas->getAbonos($this->filtrarInt($id));
			$total_abonos=0;

			foreach ($abonos as $abono) {
					$total_abonos = $total_abonos + $abono->valor;
				}

			$this->_view->sugerido = $encabezado->total_venta - $total_abonos;

			if ($this->getInt('guardar') == 1) {
				
				$this->_view->datos = (object) $_POST; /* No se debe realizar de esta formaaaa */
			//Se valida que las dos contraseñas digitadas coincidan

				if (!$this->getInt('valor') || $this->getInt('valor')== 0) {
					//Si no cumple la validacion sale mensaje de error
					$this->_view->_error = 'Debe Ingresar el valor';
					//Vista de la pagina actual
					$this->_view->renderizar('agregar_abono','ventas');
					//Saca de la funcion principal
					exit;
				}

				if ($this->getInt('valor') > $encabezado->total_venta) {
					//Si no cumple la validacion sale mensaje de error
					$this->_view->_error = 'El valor del abono es mayor al valor total de la venta';
					//Vista de la pagina actual
					$this->_view->renderizar('agregar_abono','ventas');
					//Saca de la funcion principal
					exit;
				}

				$totabn= $total_abonos+ $this->getInt('valor');

				if ($totabn > $encabezado->total_venta) {
					//Si no cumple la validacion sale mensaje de error
					$this->_view->_error = 'la sumatoria de los abonos es mayor al total de la venta';
					//Vista de la pagina actual
					$this->_view->renderizar('agregar_abono','ventas');
					//Saca de la funcion principal
					exit;
				}				

				$this->_ventas->agregar_abono($this->filtrarInt($id),
					$this->getInt('valor'));


				$abonos2 =$this->_ventas->getAbonos($this->filtrarInt($id));
				$encabezado = $this->_ventas->getEncabezado($this->filtrarInt($id));
				$total_abonos2=0;

				foreach ($abonos2 as $abono2) {
					$total_abonos2 = $total_abonos2 + $abono2->valor;
				}

				if ($total_abonos2 == $encabezado->total_venta) {
					$this->_ventas->cambiar_estado_ges($this->filtrarInt($id),3);
				}

				$this->_view->_mensaje = 'Datos Creados Correctamente';
			}

			$this->_view->renderizar('agregar_abono', "ventas");
		} else {
      		$this->redireccionar('admin');
      	}
	}

	public function editar_abono($id) {
		if (Session::Get('autenticado') == true ){ 
			$this->_view->titulo = 'Nueva Venta';
			$this->_view->navegacion = '';

			$this->_view->producto = $this->_ventas->getproductos();
			
			$this->_view->datos = $this->_ventas->getDetalle($this->filtrarInt($id));
			
			$dato = $this->_ventas->getDetalle($this->filtrarInt($id));
			$this->_view->id =$dato->id;

			if ($this->getInt('guardar') == 1) {
				
				$this->_view->datos = (object) $_POST; /* No se debe realizar de esta formaaaa */
			//Se valida que las dos contraseñas digitadas coincidan

				if (!$this->getInt('producto') || $this->getInt('producto')== 0) {
					//Si no cumple la validacion sale mensaje de error
					$this->_view->_error = 'Debe Ingresar el producto';
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
					$this->_view->_error = 'Debe Ingresar la placa del vehiculo';
					//Vista de la pagina actual
					$this->_view->renderizar('editar_detalle',false,true);
					//Saca de la funcion principal
					exit;
				}

				$total=($this->getInt('precio')*$this->getDecimal('cant'))-$this->getInt('desc');				

				$this->_ventas->editar_detalle($this->filtrarInt($id),
					$this->getInt('producto'),
					$this->getInt('precio'),
					$this->getDecimal('cant'),
					$this->getInt('desc'),
					$total);

				$this->_view->_mensaje = 'Datos Creados Correctamente';
			}

			$this->_view->datos = $this->_ventas->getDetalle($this->filtrarInt($id));
			$dato = $this->_ventas->getDetalle($this->filtrarInt($id));
			$this->_view->id =$dato->id;

			$this->_view->renderizar('editar_detalle', false, true);
		} else {
      		$this->redireccionar('admin');
      	}
	}


	public function eliminarabono($id) {
		
		//VALIDAR QUE ESTE LOGUEADO EL USUARIO
    	if (Session::Get('autenticado') == true ){ 
	        //Si el id no es un nro entero
	        if (!$this->filtrarInt($id)) {
	            //Se redirecciona al index
	            $this->redireccionar('abonos','ventas');
	        }
	        //Si no existe un registro con ese id
	        if (!$this->_ventas->getAbono($this->filtrarInt($id))) {
	            //Se redirecciona al index
	            $this->redireccionar('abonos','ventas');
	        }

        	$this->_ventas->eliminar_abono($this->filtrarInt($id));
        } else {
      		$this->redireccionar('admin');
      	}
    }







	
}

?>
