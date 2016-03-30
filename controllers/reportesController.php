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


    //////////////////////// REPORTE CLIENTES //////////////////////////

    public function buscar_cliente() {

            $this->_view->titulo = 'Sistema De Ventas';
            $this->_view->clientes = $this->_reportes->getclientes();           
            $this->_view->renderizar('buscar_cliente', 'reportes');

    }

    public function lista_clientes() {

            $this->_view->titulo = 'Sistema De Ventas';

            if ($this->getInt('guardar') == 1) {
                
            $this->_view->datos = (object) $_POST; /* No se debe realizar de esta formaaaa */
            //Se valida que las dos contraseñas digitadas coincidan

            $_SESSION["id_cliente"]=$this->getInt('id_cliente');

            $_SESSION["fecha_ini"]=$this->getSql('fecha_ini');
            $_SESSION["fecha_fin"]=$this->getSql('fecha_fin');


            $id_cliente = $_SESSION["id_cliente"];
            $condicion = "";


            if ($id_cliente > 0) {
                $condicion= $condicion . " AND c.id = ".$id_cliente;
            }

            if ($_SESSION["fecha_ini"] != "" && $_SESSION["fecha_fin"] != "") {
                $condicion= $condicion . " AND c.fecha_creacion between  '".$_SESSION["fecha_ini"] ."' AND '" .$_SESSION["fecha_fin"]."'";
            }

            

            }
            $this->_view->reporte = $this->_reportes->getClienterep($condicion);
            $this->_view->renderizar('listado_clientes', 'reportes');

    }

    public function exportar_listado_clientes() {

            $this->_view->titulo = 'Sistema De Ventas';
                
            $this->_view->datos = (object) $_POST; /* No se debe realizar de esta formaaaa */
            //Se valida que las dos contraseñas digitadas coincidan

            if ($_SESSION["fecha_ini"]!="" && $_SESSION["fecha_fin"]!="") {
                $fecha_ini = date('Y-m-d', strtotime($_SESSION["fecha_ini"]));
                $fecha_fin = date('Y-m-d', strtotime($_SESSION["fecha_fin"]));
            }

            $id_cliente = $_SESSION["id_cliente"];
            
            $condicion = "";


            if ($id_cliente > 0) {
                $condicion= $condicion . " AND c.id = ".$id_cliente;
            }

            if ($_SESSION["fecha_ini"] != "" && $_SESSION["fecha_fin"] != "") {
                $condicion= $condicion . " AND e.fecha_creacion between  '".$fecha_ini ."' AND '" .$_SESSION["fecha_fin"]."'";
            }

            $this->_view->reporte = $this->_reportes->getClienterep($condicion);
            $this->_view->renderizar('exportar_listado_clientes',false,true);

    }



    //////////////////////// REPORTE FACTURAS //////////////////////////

    public function buscar_factura() {

            $this->_view->titulo = 'Sistema De Ventas';
            $this->_view->clientes = $this->_reportes->getclientes();			
            $this->_view->renderizar('buscar_factura', 'reportes');

    }

    public function lista_factura() {

            $this->_view->titulo = 'Sistema De Ventas';

            if ($this->getInt('guardar') == 1) {
                
            $this->_view->datos = (object) $_POST; /* No se debe realizar de esta formaaaa */
            //Se valida que las dos contraseñas digitadas coincidan

            $_SESSION["id_cliente"]=$this->getInt('id_cliente');

            $_SESSION["fecha_ini"]=$this->getSql('fecha_ini');
            $_SESSION["fecha_fin"]=$this->getSql('fecha_fin');


            $id_cliente = $_SESSION["id_cliente"];
            $condicion = "";


            if ($id_cliente > 0) {
                $condicion= $condicion . " AND c.id = ".$id_cliente;
            }

            if ($_SESSION["fecha_ini"] != "" && $_SESSION["fecha_fin"] != "") {
                $condicion= $condicion . " AND e.fecha_venta between  '".$_SESSION["fecha_ini"] ."' AND '" .$_SESSION["fecha_fin"]."'";
            }

            

            }
            $this->_view->reporte = $this->_reportes->getFacturas($condicion);
            $this->_view->renderizar('listado_facturas', 'reportes');

    }

    public function exportar_listado_factura() {

            $this->_view->titulo = 'Sistema De Ventas';
                
            $this->_view->datos = (object) $_POST; /* No se debe realizar de esta formaaaa */
            //Se valida que las dos contraseñas digitadas coincidan

            if ($_SESSION["fecha_ini"]!="" && $_SESSION["fecha_fin"]!="") {
                $fecha_ini = date('Y-m-d', strtotime($_SESSION["fecha_ini"]));
                $fecha_fin = date('Y-m-d', strtotime($_SESSION["fecha_fin"]));
            }

            $id_cliente = $_SESSION["id_cliente"];
            
            $condicion = "";


            if ($id_cliente > 0) {
                $condicion= $condicion . " AND c.id = ".$id_cliente;
            }

            if ($_SESSION["fecha_ini"] != "" && $_SESSION["fecha_fin"] != "") {
                $condicion= $condicion . " AND e.fecha_venta between  '".$fecha_ini ."' AND '" .$_SESSION["fecha_fin"]."'";
            }

            $this->_view->reporte = $this->_reportes->getFacturas($condicion);
            $this->_view->renderizar('exportar_listado_facturas',false,true);

    }


        //////////////////////// REPORTE FACTURAS //////////////////////////

    public function buscar_certificado() {

            $this->_view->titulo = 'Sistema De Ventas';
            $this->_view->clientes = $this->_reportes->getclientes();           
            $this->_view->renderizar('buscar_certificado', 'reportes');

    }

    public function lista_certificado() {

            $this->_view->titulo = 'Sistema De Ventas';

            if ($this->getInt('guardar') == 1) {
                
            $this->_view->datos = (object) $_POST; /* No se debe realizar de esta formaaaa */
            //Se valida que las dos contraseñas digitadas coincidan

            $_SESSION["id_cliente"]=$this->getInt('id_cliente');

            $_SESSION["fecha_ini"]=$this->getSql('fecha_ini');
            $_SESSION["fecha_fin"]=$this->getSql('fecha_fin');


            $id_cliente = $_SESSION["id_cliente"];
            $condicion = "";


            if ($id_cliente > 0) {
                $condicion= $condicion . " AND c.id = ".$id_cliente;
            }

            if ($_SESSION["fecha_ini"] != "" && $_SESSION["fecha_fin"] != "") {
                $condicion= $condicion . " AND e.fecha_venta between  '".$_SESSION["fecha_ini"] ."' AND '" .$_SESSION["fecha_fin"]."'";
            }

            

            }
            $this->_view->reporte = $this->_reportes->getFacturas($condicion);
            $this->_view->renderizar('listado_certificados', 'reportes');

    }

    public function exportar_listado_certificado() {

            $this->_view->titulo = 'Sistema De Ventas';
                
            $this->_view->datos = (object) $_POST; /* No se debe realizar de esta formaaaa */
            //Se valida que las dos contraseñas digitadas coincidan

            if ($_SESSION["fecha_ini"]!="" && $_SESSION["fecha_fin"]!="") {
                $fecha_ini = date('Y-m-d', strtotime($_SESSION["fecha_ini"]));
                $fecha_fin = date('Y-m-d', strtotime($_SESSION["fecha_fin"]));
            }

            $id_cliente = $_SESSION["id_cliente"];
            
            $condicion = "";


            if ($id_cliente > 0) {
                $condicion= $condicion . " AND c.id = ".$id_cliente;
            }

            if ($_SESSION["fecha_ini"] != "" && $_SESSION["fecha_fin"] != "") {
                $condicion= $condicion . " AND e.fecha_venta between  '".$fecha_ini ."' AND '" .$_SESSION["fecha_fin"]."'";
            }

            $this->_view->reporte = $this->_reportes->getFacturas($condicion);
            $this->_view->renderizar('exportar_listado_certificados',false,true);

    }



    //////////////////////// REPORTE COMPRAS //////////////////////////



    public function buscar_compra() {

            $this->_view->titulo = 'Sistema De Ventas';
            $this->_view->proveedores = $this->_reportes->getproveedores();           
            $this->_view->renderizar('buscar_compra', 'reportes');

    }

    public function lista_compra() {

            $this->_view->titulo = 'Sistema De Ventas';

            if ($this->getInt('guardar') == 1) {
                
            $this->_view->datos = (object) $_POST; /* No se debe realizar de esta formaaaa */
            //Se valida que las dos contraseñas digitadas coincidan

            $_SESSION["id_proveedor"]=$this->getInt('id_proveedor');

            $_SESSION["fecha_ini"]=$this->getSql('fecha_ini');
            $_SESSION["fecha_fin"]=$this->getSql('fecha_fin');


            $id_proveedor = $_SESSION["id_proveedor"];
            $condicion = "";


            if ($id_proveedor > 0) {
                $condicion= $condicion . " AND p.id = ".$id_proveedor;
            }

            if ($_SESSION["fecha_ini"] != "" && $_SESSION["fecha_fin"] != "") {
                $condicion= $condicion . " AND e.fecha_compra between  '".$_SESSION["fecha_ini"] ."' AND '" .$_SESSION["fecha_fin"]."'";
            }

            

            }
            $this->_view->reporte = $this->_reportes->getCompras($condicion);
            $this->_view->renderizar('listado_compras', 'reportes');

    }

    public function exportar_listado_compra() {

            $this->_view->titulo = 'Sistema De Ventas';
                
            $this->_view->datos = (object) $_POST; /* No se debe realizar de esta formaaaa */
            //Se valida que las dos contraseñas digitadas coincidan

            if ($_SESSION["fecha_ini"]!="" && $_SESSION["fecha_fin"]!="") {
                $fecha_ini = date('Y-m-d', strtotime($_SESSION["fecha_ini"]));
                $fecha_fin = date('Y-m-d', strtotime($_SESSION["fecha_fin"]));
            }

            $id_proveedor = $_SESSION["id_proveedor"];
            
            $condicion = "";


            if ($id_proveedor > 0) {
                $condicion= $condicion . " AND p.id = ".$id_proveedor;
            }

            if ($_SESSION["fecha_ini"] != "" && $_SESSION["fecha_fin"] != "") {
                $condicion= $condicion . " AND e.fecha_compra between  '".$_SESSION["fecha_ini"] ."' AND '" .$_SESSION["fecha_fin"]."'";
            }

            $this->_view->reporte = $this->_reportes->getCompras($condicion);
            $this->_view->renderizar('exportar_listado_compras',false,true);

    }


    //////////////////////// REPORTE General //////////////////////////



    public function buscar_general() {

            $this->_view->titulo = 'Sistema De Ventas';
            $this->_view->clientes = $this->_reportes->getclientes();           
            $this->_view->renderizar('buscar_general', 'reportes');

    }

    public function lista_general() {

            $this->_view->titulo = 'Sistema De Ventas';

            if ($this->getInt('guardar') == 1) {
                
            $this->_view->datos = (object) $_POST; /* No se debe realizar de esta formaaaa */
            //Se valida que las dos contraseñas digitadas coincidan

            $_SESSION["id_cliente"]=$this->getInt('id_cliente');

            $_SESSION["fecha_ini"]=$this->getSql('fecha_ini');
            $_SESSION["fecha_fin"]=$this->getSql('fecha_fin');


            $id_cliente = $_SESSION["id_cliente"];
            $condicion = "";


            if ($id_cliente > 0) {
                $condicion= $condicion . " AND c.id = ".$id_cliente;
            }

            if ($_SESSION["fecha_ini"] != "" && $_SESSION["fecha_fin"] != "") {
                $condicion= $condicion . " AND e.fecha_venta between  '".$_SESSION["fecha_ini"] ."' AND '" .$_SESSION["fecha_fin"]."'";
            }

            }
            $this->_view->reporte = $this->_reportes->getGeneral($condicion);
            $this->_view->renderizar('listado_general', 'reportes');

    }

    public function exportar_listado_general() {

            $this->_view->titulo = 'Sistema De Ventas';
                
            $this->_view->datos = (object) $_POST; /* No se debe realizar de esta formaaaa */
            //Se valida que las dos contraseñas digitadas coincidan

            if ($_SESSION["fecha_ini"]!="" && $_SESSION["fecha_fin"]!="") {
                $fecha_ini = date('Y-m-d', strtotime($_SESSION["fecha_ini"]));
                $fecha_fin = date('Y-m-d', strtotime($_SESSION["fecha_fin"]));
            }

            $id_cliente = $_SESSION["id_cliente"];
            
            $condicion = "";


            if ($id_cliente > 0) {
                $condicion= $condicion . " AND c.id = ".$id_cliente;
            }

            if ($_SESSION["fecha_ini"] != "" && $_SESSION["fecha_fin"] != "") {
                $condicion= $condicion . " AND e.fecha_venta between  '".$fecha_ini ."' AND '" .$_SESSION["fecha_fin"]."'";
            }

            $this->_view->reporte = $this->_reportes->getGeneral($condicion);
            $this->_view->renderizar('exportar_listado_general',false,true);

    }

}

?>