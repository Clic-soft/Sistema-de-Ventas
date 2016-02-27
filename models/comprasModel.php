<?php
setlocale(LC_ALL,"es_ES@euro","es_ES","esp");
date_default_timezone_set('America/Bogota');
//Clase extendida de la clase model 
class comprasModel extends Model {

    //Se crea el constructor
    public function __construct() {
        parent::__construct();
    }

    public function getEncabezados() {
        //Se crea y ejecuta la consulta
            $consulta = $this->_db->get_results("SELECT e.*,p.*
                                                FROM encabezado_compra as e, proveedores as p
                                                WHERE e.id_proveedor=p.id
                                                order by e.estado_compra ASC, e.fecha_compra DESC;");
        //Se retorna la consulta y se recorren los registros
        return $consulta;
    }

    public function getEncabezadosimp($id) {
        //Se crea y ejecuta la consulta
            $consulta = $this->_db->get_row("SELECT e.* FROM encabezado_compra as e WHERE e.id=$id ;");
        //Se retorna la consulta y se recorren los registros
        return $consulta;
    }   

    public function getEncabezado($id) {
        //Se crea y ejecuta la consulta
        $id = (int) $id; /* Parse de la variable */
            $consulta = $this->_db->get_row("SELECT e.*,p.*
                                                FROM encabezado_compra as e, proveedores as p 
                                                WHERE e.id_proveedor=p.id AND e.id = $id;");
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


    public function getproveedores() {
        //Se crea y ejecuta la consulta
            $consulta = $this->_db->get_results("SELECT * from proveedores");
        //Se retorna la consulta y se recorren los registros
        return $consulta;
    }

    public function getproveedor($id) {
        //Se crea y ejecuta la consulta
            $consulta = $this->_db->get_row("SELECT * from proveedores where id=$id");
        //Se retorna la consulta y se recorren los registros
        return $consulta;
    }

    public function getinsumos($id) {
        //Se crea y ejecuta la consulta
            $consulta = $this->_db->get_results("SELECT i.* from insumos as i, proveedores as p where i.id_cat_insumos = p.tipo_proveedor and p.id=$id");
        //Se retorna la consulta y se recorren los registros
        return $consulta;
    }

    public function getDetalles($id) {
        //Se crea y ejecuta la consulta
            $consulta = $this->_db->get_results("SELECT d.*,p.insumo from detalle_compras as d, insumos as p
                where p.id=d.id_insumo and d.id_compra=$id");
        //Se retorna la consulta y se recorren los registros
        return $consulta;
    }
  
    
    public function act_consecutivo($id, $nactual) {

        $this->_db->query("UPDATE prefijos SET actual='".$nactual."' WHERE id = $id;");
    }

    
    public function crear_compra($id_proveedor, $prefijo, $numero) {
        $fechaactual = date("Y-m-d H:i:s");
        $this->_db->query("INSERT INTO encabezado_compra (prefijo, num_prefijo, id_proveedor, fecha_compra) 
            VALUES ('".$prefijo."', '".$numero."', '".$id_proveedor."', '".$fechaactual."');");
    }


    public function cambiar_estado($id, $estado, $sub, $ret, $iva, $total) {
        
        $this->_db->query("UPDATE encabezado_compra SET estado_compra ='".$estado."',
                                 sub_total_compra = '".$sub."',
                                 retencion = '".$ret."',
                                 iva_compra = '".$iva."',
                                 total_compra = '".$total."'
                                 where id = $id" );

        echo "UPDATE encabezado_compra SET estado_compra ='".$estado."',
                                 sub_total_compra = '".$sub."',
                                 retencion = '".$ret."',
                                 iva_compra = '".$iva."',
                                 total_compra = '".$total."'
                                 where id = $id";
            
    }


    public function getDetalle($id) {
        //Se crea y ejecuta la consulta
            $consulta = $this->_db->get_row("SELECT d.* from detalle_compras as d where d.id=$id");
        //Se retorna la consulta y se recorren los registros
        return $consulta;
    }

    public function agregar_detalle($id, $insumo, $precio, $cant, $total) {
        $this->_db->query("INSERT INTO detalle_compras (id_compra, id_insumo, precio, cantidad, total_detalle) 
            VALUES ('".$id."','".$insumo."', '".$precio."', '".$cant."', '".$total."');");
    }

    public function editar_detalle($id, $insumo, $precio, $cant, $total) {
        
        $this->_db->query("UPDATE detalle_compras SET id_insumo ='".$insumo."',
                                 precio = '".$precio."',
                                 cantidad = '".$cant."',
                                 total_detalle = '".$total."'
                                 where id = $id" ); 
            
    }


    public function eliminar_detalle($id) {
        $id = (int) $id; /* Parse de la variable */
        $this->_db->query("Delete FROM detalle_compras Where id = $id;");
    }
    
}

?>
