<?php
setlocale(LC_ALL,"es_ES@euro","es_ES","esp");
date_default_timezone_set('America/Bogota');
//Clase extendida de la clase model 
class productosModel extends Model {

    //Se crea el constructor
    public function __construct() {
        parent::__construct();
    }

    public function getproductos() {
        //Se crea y ejecuta la consulta
            $consulta = $this->_db->get_results("SELECT p.*,u.Simbolo,u.unidad_medida
                                                FROM productos AS p, unidades_medida as u 
                                                WHERE p.id_und_medida = u.id;");
        //Se retorna la consulta y se recorren los registros
        return $consulta;
    }

   

    public function getproducto($id) {
        //Se crea y ejecuta la consulta
        $id = (int) $id; /* Parse de la variable */
            $consulta = $this->_db->get_row("SELECT p.*,u.Simbolo,u.unidad_medida
                                                FROM productos AS p, unidades_medida as u 
                                                WHERE p.id_und_medida = u.id 
                                                AND p.id = $id;");
        //Se retorna la consulta y se recorren los registros
        return $consulta;
    }

    public function getunidades() {
        //Se crea y ejecuta la consulta
            $consulta = $this->_db->get_results("SELECT * from unidades_medida");
        //Se retorna la consulta y se recorren los registros
        return $consulta;
    }
    
    public function validarproducto($producto) {
        //Se crea y ejecuta la consulta
            $consulta = $this->_db->get_row("SELECT c.id FROM productos AS c 
                                            WHERE c.producto = '".$producto."';");
        //Se retorna la consulta y se recorren los registros
        return $consulta;
    }
    
    /*public function validarproductoedita($id,$producto) {
        //Se crea y ejecuta la consulta
            $consulta = $this->_db->get_row("SELECT c.id FROM productos AS c 
                                            WHERE  c.producto = '".$producto."'
                                             AND c.id <> $id;");
        //Se retorna la consulta y se recorren los registros
        return $consulta;
    }*/

    public function crear_producto($unidad, $precio, $producto) {

        $this->_db->query("INSERT INTO productos (producto, precio, id_und_medida) VALUES
                            ('".$producto."',".$precio.", ".$unidad.");");
    }

    public function editar_producto($id, $unidad, $precio, $producto) {

        $this->_db->query("UPDATE productos SET producto='".$producto."', 
                            precio=".$precio.",
                            id_und_medida='".$unidad."'
                            WHERE id = $id;");
    }

    public function eliminar_producto($id) {
        $id = (int) $id; /* Parse de la variable */
        $this->_db->query("Delete FROM productos Where id = $id;");
        echo "Delete FROM productos Where id = $id;";
    }
}

?>
