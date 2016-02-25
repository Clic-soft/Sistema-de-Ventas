<?php

class reportesController extends Controller {

    private $_reportes;

    //Se crea el constructor
    public function __construct() {
        parent::__construct();
        //Se cargan el modelo
        $this->_reportes = $this->loadModel('reportes');
    }

    public function index() {

            $this->_view->titulo = 'Sistema De Ventas';
			
            $this->_view->renderizar('index', 'reportes');

    }

    public function buscar_factura() {

            $this->_view->titulo = 'Sistema De Ventas';


			
            $this->_view->renderizar('buscar_factura', 'reportes');

    }

    public function buscar_venta() {

            $this->_view->titulo = 'Sistema De Ventas';
			
            $this->_view->renderizar('buscar_venta', 'reportes');

    }

}

?>