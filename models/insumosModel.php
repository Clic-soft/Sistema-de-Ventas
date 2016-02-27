<?php
setlocale(LC_ALL,"es_ES@euro","es_ES","esp");
date_default_timezone_set('America/Bogota');
//Clase extendida de la clase model 
class insumosModel extends Model {

    //Se crea el constructor
    public function __construct() {
        parent::__construct();
    }

    public function getinsumos() {
        //Se crea y ejecuta la consulta
            $consulta = $this->_db->get_results("SELECT i.*,c.categoria
                                                FROM insumos AS i, categoria_insumos as c 
                                                WHERE i.id_cat_insumos = c.id;");
        //Se retorna la consulta y se recorren los registros
        return $consulta;
    }

    public function getinsumo($id) {
        //Se crea y ejecuta la consulta
            $consulta = $this->_db->get_row("SELECT i.*,c.categoria
                                                FROM insumos AS i, categoria_insumos as c 
                                                WHERE i.id_cat_insumos = c.id AND i.id=$id;");
        //Se retorna la consulta y se recorren los registros
        return $consulta;
    }

    public function getcategorias() {
        //Se crea y ejecuta la consulta
            $consulta = $this->_db->get_results("SELECT * from categoria_insumos");
        //Se retorna la consulta y se recorren los registros
        return $consulta;
    }
    

    public function crear_Insumos($categoria, $insumo) {

        $this->_db->query("INSERT INTO insumos (id_cat_insumos,insumo) VALUES
                            (".$categoria.", '".$insumo."');");
    }

    public function editar_insumos($id,$categoria, $insumo) {

        $this->_db->query("UPDATE insumos SET id_cat_insumos='".$categoria."', 
                            insumo='".$insumo."'
                           WHERE id = $id;");
    }

    public function eliminar_insumo($id) {
        $id = (int) $id; /* Parse de la variable */
        $this->_db->query("Delete FROM insumos Where id = $id;");

    }
}

?>
