<?php
setlocale(LC_ALL,"es_ES@euro","es_ES","esp");
date_default_timezone_set('America/Bogota');
//Clase extendida de la clase model 
class reportesModel extends Model {

    //Se crea el constructor
    public function __construct() {
        parent::__construct();
    }

    public function getFacturas() {
        //Se crea y ejecuta la consulta
            $consulta = $this->_db->get_results("SELECT e.*,c.nomcom, em.nombres, em.apellidos, v.placa 
                                                FROM encabezado_venta as e, clientes as c, empleados as em, vehiculos as v 
                                                WHERE e.id_cliente=c.id AND e.id_empleado=em.id AND e.id_placa=v.id
                                                and e.estado_venta == 4 order by e.estado_venta ASC, e.fecha_venta DESC;");
        //Se retorna la consulta y se recorren los registros
        return $consulta;
    }

    public function getVentas() {
        //Se crea y ejecuta la consulta
            $consulta = $this->_db->get_results("SELECT e.*,c.nomcom, em.nombres, em.apellidos, v.placa 
                                                FROM encabezado_venta as e, clientes as c, empleados as em, vehiculos as v 
                                                WHERE e.id_cliente=c.id AND e.id_empleado=em.id AND e.id_placa=v.id
                                                order by e.estado_venta ASC, e.fecha_venta DESC;");
        //Se retorna la consulta y se recorren los registros
        return $consulta;
    }
}

?>
