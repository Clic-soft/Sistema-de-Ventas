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

    public function getEncabezadosimp($id) {
        //Se crea y ejecuta la consulta
            $consulta = $this->_db->get_row("SELECT e.* FROM encabezado_venta as e WHERE e.id=$id ;");
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

    public function getplacas($id) {
        //Se crea y ejecuta la consulta
            $consulta = $this->_db->get_results("SELECT * from vehiculos where id_cliente=$id order by placa ASC");
        return json_encode($consulta);

    }

    public function get_placas() {
        //Se crea y ejecuta la consulta
            $consulta = $this->_db->get_results("SELECT * from vehiculos");
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

    public function getproductos() {
        //Se crea y ejecuta la consulta
            $consulta = $this->_db->get_results("SELECT * from productos");
        //Se retorna la consulta y se recorren los registros
        return $consulta;
    }

    public function getDetalles($id) {
        //Se crea y ejecuta la consulta
            $consulta = $this->_db->get_results("SELECT d.*,p.producto from detalle_ventas as d, productos as p
                where p.id=d.id_producto and d.id_venta=$id");
        //Se retorna la consulta y se recorren los registros
        return $consulta;
    }
  
    
    public function act_consecutivo($id, $nactual) {

        $this->_db->query("UPDATE prefijos SET actual='".$nactual."' WHERE id = $id;");
    }

    
    public function crear_venta($id_cliente, $id_empleado, $id_placa, $forma, $prefijo, $numero, $prefijoco, $numeroco) {
        $fechaactual = date("Y-m-d H:i:s");
        $this->_db->query("INSERT INTO encabezado_venta (prefijo, num_prefijo, id_cliente, id_empleado,
            fecha_venta, forma_pago, id_placa, pref_co, num_co) 
            VALUES ('".$prefijo."', '".$numero."', '".$id_cliente."', '".$id_empleado."', '".$fechaactual."',
             '".$forma."', '".$id_placa."','".$prefijoco."', '".$numeroco."');");
    }


    public function cambiar_estado($id, $estado, $sub, $desc, $total) {
        
        $this->_db->query("UPDATE encabezado_venta SET estado_venta ='".$estado."',
                                 sub_total_venta = '".$sub."',
                                 descuento_venta = '".$desc."',
                                 total_venta = '".$total."'
                                 where id = $id" ); 
            
    }


    public function getDetalle($id) {
        //Se crea y ejecuta la consulta
            $consulta = $this->_db->get_row("SELECT d.* from detalle_ventas as d where d.id=$id");
        //Se retorna la consulta y se recorren los registros
        return $consulta;
    }

    public function agregar_detalle($id, $producto, $precio, $cant, $desc, $total) {
        $this->_db->query("INSERT INTO detalle_ventas (id_venta, id_producto, precio, cantidad, descuento,
            total_detalle) 
            VALUES ('".$id."','".$producto."', '".$precio."', '".$cant."', '".$desc."', '".$total."');");
    }

    public function editar_detalle($id, $producto, $precio, $cant, $desc, $total) {
        
        $this->_db->query("UPDATE detalle_ventas SET id_producto ='".$producto."',
                                 precio = '".$precio."',
                                 cantidad = '".$cant."',
                                 descuento = '".$desc."',
                                 total_detalle = '".$total."'
                                 where id = $id" ); 
            
    }



    public function eliminar_detalle($id) {
        $id = (int) $id; /* Parse de la variable */
        $this->_db->query("Delete FROM detalle_ventas Where id = $id;");
    }
    

    public function eliminar_vehiculo($id) {
        $id = (int) $id; /* Parse de la variable */
        $this->_db->query("Delete FROM vehiculos Where id = $id;");
    }

    public function getpendienteFacturas($id,$estado) {
        //Se crea y ejecuta la consulta
            $consulta = $this->_db->get_results("SELECT e.* from encabezado_venta as e where e.id_cliente=$id and e.estado_venta=$estado; ");
        //Se retorna la consulta y se recorren los registros
        return $consulta;
    }

}

?>
