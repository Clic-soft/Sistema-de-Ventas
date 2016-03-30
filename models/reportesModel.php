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

    public function getClienterep($condicion = "") {
        //Se crea y ejecuta la consulta
            $consulta = $this->_db->get_results("SELECT c.*,td.tipo_documento as tipdoc, tc.tipo_cliente, ciu.ciudad, d.departamento
                                                FROM clientes as c,tipo_clientes as tc, tipo_documento as td, ciudades as ciu,
                                                departamentos as d
                                                WHERE c.id_tipo_cliente=tc.id
                                                AND c.tipo_documento=td.id
                                                AND c.id_depto=d.id
                                                AND c.id_ciudad=ciu.id
                                                 ".$condicion. "
                                                 order by c.razon_social DESC;");
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

    public function getGeneral($condicion = "") {
        //Se crea y ejecuta la consulta
            $consulta = $this->_db->get_results("SELECT e.*,c.nomcom, em.nombres, em.apellidos, v.placa,
                                                des.nombres as desnom, des.apellidos as desape,
                                                tc.tipo_cliente, td.tipo_documento as tdoc, c.nit,
                                                ciu.ciudad, d.departamento
                                                FROM encabezado_venta as e, clientes as c, empleados as em, 
                                                vehiculos as v, empleados as des, tipo_clientes as tc, 
                                                tipo_documento as td, ciudades as ciu, departamentos as d
                                                WHERE e.id_cliente=c.id 
                                                AND e.id_empleado=em.id 
                                                AND e.id_placa=v.id
                                                and e.estado_venta = 4
                                                and e.id_despachador = des.id
                                                and c.id_tipo_cliente = tc.id
                                                and c.tipo_documento =td.id
                                                and c.id_ciudad=ciu.id 
                                                and c.id_depto= d.id 
                                                ".$condicion. " 
                                                order by e.estado_venta ASC, e.fecha_venta DESC;");

             //Se retorna la consulta y se recorren los registros
        return $consulta;
    }
}

?>
