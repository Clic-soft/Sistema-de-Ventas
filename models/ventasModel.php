<?php
setlocale(LC_ALL,"es_ES@euro","es_ES","esp");
date_default_timezone_set('America/Bogota');
//Clase extendida de la clase model 
class ventasModel extends Model {

    //Se crea el constructor
    public function __construct() {
        parent::__construct();
    }

    public function getEncabezados() {
        //Se crea y ejecuta la consulta
            $consulta = $this->_db->get_results("SELECT e.*,c.nomcom, em.nombres, em.apellidos, v.placa 
                                                FROM encabezado_venta as e, clientes as c, empleados as em, vehiculos as v 
                                                WHERE e.id_cliente=c.id AND e.id_empleado=em.id AND e.id_placa=v.id
                                                order by e.fecha_venta DESC;");
        //Se retorna la consulta y se recorren los registros
        return $consulta;
    }

   

    public function getEncabezado($id) {
        //Se crea y ejecuta la consulta
        $id = (int) $id; /* Parse de la variable */
            $consulta = $this->_db->get_row("SELECT e.*,c.nomcom, em.nombres, em.apellidos, v.placa 
                                                FROM encabezado_venta as e, clientes as c, empleados as em, vehiculos as v 
                                                WHERE e.id_cliente=c.id AND e.id_empleado=em.id AND e.id_placa=v.id AND e.id = $id;");
        //Se retorna la consulta y se recorren los registros
        return $consulta;
    }

    public function get_prefijo($id) {
        //Se crea y ejecuta la consulta
        $id = (int) $id; /* Parse de la variable */
            $consulta = $this->_db->get_row("SELECT p.* FROM prefijos as p WHERE id=$id");
        //Se retorna la consulta y se recorren los registros
        return $consulta;
    }

    public function getplacas() {
        //Se crea y ejecuta la consulta
            $consulta = $this->_db->get_results("SELECT * from vehiculos");
        //Se retorna la consulta y se recorren los registros
        return $consulta;
    }

    public function getclientes() {
        //Se crea y ejecuta la consulta
            $consulta = $this->_db->get_results("SELECT * from clientes");
        //Se retorna la consulta y se recorren los registros
        return $consulta;
    }

    public function getempleados() {
        //Se crea y ejecuta la consulta
            $consulta = $this->_db->get_results("SELECT * from empleados");
        //Se retorna la consulta y se recorren los registros
        return $consulta;
    }
  
    
    public function act_consecutivo($id, $nactual) {

        $this->_db->query("UPDATE prefijos SET actual='".$nactual."' WHERE id = $id;");
    }

    
    public function crear_venta($id_cliente, $id_empleado, $id_placa, $forma, $prefijo, $numero) {
        $fechaactual = date("Y-m-d H:i:s");
        $this->_db->query("INSERT INTO encabezado_venta (prefijo, num_prefijo, id_cliente, id_empleado,
            fecha_venta, forma_pago, id_placa ) 
            VALUES ('".$prefijo."', '".$numero."', '".$id_cliente."', '".$id_empleado."', '".$fechaactual."',
             '".$forma."', '".$id_placa."');");
    }

    public function editar_vehiculo($id, $cliente, $placa) {

        $this->_db->query("UPDATE vehiculos SET id_cliente='".$cliente."', placa='".$placa."' WHERE id = $id;");
    }

    public function eliminar_vehiculo($id) {
        $id = (int) $id; /* Parse de la variable */
        $this->_db->query("Delete FROM vehiculos Where id = $id;");
    }
}

?>
