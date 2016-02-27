<?php
setlocale(LC_ALL,"es_ES@euro","es_ES","esp");
date_default_timezone_set('America/Bogota');
//Clase extendida de la clase model 
class reportesModel extends Model {

    //Se crea el constructor
    public function __construct() {
        parent::__construct();
    }

    public function getFacturas($condicion = "") {
        //Se crea y ejecuta la consulta
            $consulta = $this->_db->get_results("SELECT e.*,c.nomcom, em.nombres, em.apellidos, v.placa 
                                                FROM encabezado_venta as e, clientes as c, empleados as em, vehiculos as v 
                                                WHERE e.id_cliente=c.id AND e.id_empleado=em.id AND e.id_placa=v.id
                                                and e.estado_venta = 4 ".$condicion. " order by e.estado_venta ASC, e.fecha_venta DESC;");

             //Se retorna la consulta y se recorren los registros
        return $consulta;
    }

    public function getclientes() {
        //Se crea y ejecuta la consulta
            $consulta = $this->_db->get_results("SELECT * FROM clientes");
        //Se retorna la consulta y se recorren los registros
        return $consulta;
    }

    public function getCompras($condicion = "") {
        //Se crea y ejecuta la consulta
            $consulta = $this->_db->get_results("SELECT e.*,p.*
                                                FROM encabezado_compra as e, proveedores as p
                                                WHERE e.id_proveedor=p.id AND e.estado_compra=2 ".$condicion. "
                                                 order by e.estado_compra ASC, e.fecha_compra DESC;");
        //Se retorna la consulta y se recorren los registros
        return $consulta;
    }

    public function getproveedores() {
        //Se crea y ejecuta la consulta
            $consulta = $this->_db->get_results("SELECT * FROM proveedores");
        //Se retorna la consulta y se recorren los registros
        return $consulta;
    }
}

?>
