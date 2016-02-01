<?php
setlocale(LC_ALL,"es_ES@euro","es_ES","esp");
date_default_timezone_set('America/Bogota');
//Clase extendida de la clase model 
class clientesModel extends Model {

    //Se crea el constructor
    public function __construct() {
        parent::__construct();
    }

    public function getClientes() {
        //Se crea y ejecuta la consulta
            $consulta = $this->_db->get_results("SELECT c.*,te.tipo_cliente,td.tipo_documento as tdoc
                                                FROM clientes AS c, tipo_documento AS td, tipo_clientes as te 
                                                WHERE c.tipo_documento = td.id AND c.id_tipo_cliente = te.id ;");
        //Se retorna la consulta y se recorren los registros
        return $consulta;
    }

   

    public function getCliente($id) {
        //Se crea y ejecuta la consulta
        $id = (int) $id; /* Parse de la variable */
            $consulta = $this->_db->get_row("SELECT c.*,te.tipo_cliente,td.tipo_documento as tdoc
                                                FROM clientes AS c, tipo_documento AS td, tipo_clientes as te 
                                                WHERE c.tipo_documento = td.id AND c.id_tipo_cliente = te.id 
                                                AND c.id = $id;");
        //Se retorna la consulta y se recorren los registros
        return $consulta;
    }

    public function gettipe() {
        //Se crea y ejecuta la consulta
            $consulta = $this->_db->get_results("SELECT * from tipo_clientes");
        //Se retorna la consulta y se recorren los registros
        return $consulta;
    }

    public function gettido() {
        //Se crea y ejecuta la consulta
            $consulta = $this->_db->get_results("SELECT * from tipo_documento");
        //Se retorna la consulta y se recorren los registros
        return $consulta;
    }
    
    public function validarnumdoc($tipodoc, $numdoc) {
        //Se crea y ejecuta la consulta
        $tipodoc = (int) $tipodoc; /* Parse de la variable */
            $consulta = $this->_db->get_row("SELECT c.id FROM clientes AS c 
                                            WHERE c.tipo_documento = $tipodoc
                                            AND c.nit = '".$numdoc."';");
        //Se retorna la consulta y se recorren los registros
        return $consulta;
    }
    
    public function validarrucom($rucom) {
        //Se crea y ejecuta la consulta
            $consulta = $this->_db->get_row("SELECT c.id FROM clientes AS c 
                                            WHERE c.rucom = '".$rucom."';");
        //Se retorna la consulta y se recorren los registros
        return $consulta;
    }

    public function validarnumdocedita($id,$tipodoc, $numdoc) {
        //Se crea y ejecuta la consulta
        $id = (int) $id; /* Parse de la variable */
            $consulta = $this->_db->get_row("SELECT c.id FROM clientes AS c 
                                            WHERE c.tipo_documento = $tipodoc
                                            AND c.nit = '".$numdoc."'
                                             AND c.id <> $id;");
        //Se retorna la consulta y se recorren los registros
        return $consulta;
    }
    
    public function validarrucomedita($id,$rucom) {
        //Se crea y ejecuta la consulta
        $id = (int) $id; /* Parse de la variable */
            $consulta = $this->_db->get_row("SELECT c.id FROM clientes AS c 
                                            WHERE c.rucom = '".$rucom."'
                                             AND c.id <> $id;");
        //Se retorna la consulta y se recorren los registros
        return $consulta;
    }


    public function crear_cliente($tipo_emp, $tipo_doc, $numdoc, $rucom, $rsocial, $nomcom, $telefono1, $telefono2,
                    $dir, $email) {

        $this->_db->query("INSERT INTO clientes (id_tipo_cliente, tipo_documento, nit, rucom, razon_social,
                            nomcom, telefono1, telefono2, direccion, email) VALUES
                            (".$tipo_emp.", ".$tipo_doc.", '".$numdoc."', '".$rucom."', '".$rsocial."',
                            '".$nomcom."', '".$telefono1."', '".$telefono2."', '".$dir."', '".$email."');");
    }

    public function editar_cliente($id, $tipo_emp, $tipo_doc, $numdoc, $rucom, $rsocial, $nomcom, $telefono1, $telefono2,
                    $dir, $email, $estado) {

        $this->_db->query("UPDATE clientes SET id_tipo_cliente='".$tipo_emp."', 
                            tipo_documento=".$tipo_doc.",
                            nit='".$numdoc."', 
                            rucom='".$rucom."', 
                            razon_social='".$rsocial."', 
                            nomcom='".$nomcom."', 
                            telefono1='".$telefono1."', 
                            telefono2='".$telefono2."', 
                            direccion='".$dir."', 
                            email='".$email."', 
                            estado=".$estado."
                            WHERE id = $id;");
    }

    public function eliminar_cliente($id) {
        $id = (int) $id; /* Parse de la variable */
        $this->_db->query("Delete FROM clientes Where id = $id;");
    }
}

?>
