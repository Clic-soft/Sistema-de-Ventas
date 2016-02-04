<?php
setlocale(LC_ALL,"es_ES@euro","es_ES","esp");
date_default_timezone_set('America/Bogota');
//Clase extendida de la clase model 
class vehiculosModel extends Model {

    //Se crea el constructor
    public function __construct() {
        parent::__construct();
    }

    public function getVehiculos() {
        //Se crea y ejecuta la consulta
            $consulta = $this->_db->get_results("SELECT v.*,c.nomcom from vehiculos as v, clientes as c 
                                                WHERE v.id_cliente=c.id ORDER BY c.nomcom ASC;");
        //Se retorna la consulta y se recorren los registros
        return $consulta;
    }

   

    public function getVehiculo($id) {
        //Se crea y ejecuta la consulta
        $id = (int) $id; /* Parse de la variable */
            $consulta = $this->_db->get_row("SELECT v.*,c.nomcom from vehiculos as v, clientes as c 
                                                WHERE v.id_cliente=c.id AND v.id = $id;");
        //Se retorna la consulta y se recorren los registros
        return $consulta;
    }

    public function getcliente() {
        //Se crea y ejecuta la consulta
            $consulta = $this->_db->get_results("SELECT id,nomcom from clientes");
        //Se retorna la consulta y se recorren los registros
        return $consulta;
    }
  
    public function validavehiculo($cliente, $placa) {
        //Se crea y ejecuta la consulta
        $cliente = (int) $cliente; /* Parse de la variable */
            $consulta = $this->_db->get_row("SELECT v.id FROM vehiculos as v 
                                            WHERE v.id_cliente = $cliente
                                            AND v.placa = '".$placa."';");
        //Se retorna la consulta y se recorren los registros
        return $consulta;
    }
    
    public function validavehiculoedita($id,$cliente, $placa) {
        //Se crea y ejecuta la consulta
        $id = (int) $id; /* Parse de la variable */
            $consulta = $this->_db->get_row("SELECT v.id FROM vehiculos as v 
                                            WHERE v.id_cliente = $cliente
                                            AND v.placa = '".$placa."'
                                             AND v.id <> $id;");
        //Se retorna la consulta y se recorren los registros
        return $consulta;
    }
    
    public function crear_vehiculo($cliente, $placa) {

        $this->_db->query("INSERT INTO vehiculos (id_cliente, placa) VALUES (".$cliente.", '".$placa."');");
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
