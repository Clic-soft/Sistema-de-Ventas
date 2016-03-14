<?php

class nominaController extends Controller {

    private $_nomina;

    //Se crea el constructor
    public function __construct() {
        parent::__construct();
        //Se cargan el modelo
        $this->_nomina = $this->loadModel('nomina');
    }

    public function index() {

            $this->_view->titulo = 'Sistema De Ventas';
			
            $this->_view->renderizar('index', 'nomina');

    }
}

?>